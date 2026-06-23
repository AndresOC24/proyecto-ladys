<?php

namespace App\Jobs;

use App\Models\ParametroControl;
use App\Models\RegistroVerificacion;
use App\Models\ResultadoValidacion;
use App\Models\Role;
use App\Models\User;
use App\Notifications\CasoPendienteRevision;
use App\Notifications\ResultadoVerificacion;
use App\Services\ServicioIA;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AnalizarRegistroJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;

    public function __construct(public int $userId) {}

    public function handle(ServicioIA $ia): void
    {
        $user = User::find($this->userId);
        if (! $user) {
            return;
        }

        $user->update(['estado_verificacion' => 'analizando']);

        // Obtener el registro normalizado más reciente
        $registro = RegistroVerificacion::where('user_id', $user->id)
            ->latest()
            ->first();

        if ($registro) {
            $registro->update(['estado_resultado' => 'analizando']);
        }

        try {
            $resultado = $ia->procesarCedula(
                Storage::disk('local')->path($user->carnet_anverso_path),
                Storage::disk('local')->path($user->carnet_reverso_path),
                $user->selfie_path ? Storage::disk('local')->path($user->selfie_path) : null,
            );

            // --- Poblar dato_documento con campos OCR ---
            if ($registro) {
                $docAnverso = $registro->documentos()->where('tipo_documento', 'cedula_anverso')->first();
                if ($docAnverso) {
                    $camposOcr = [
                        'numero_cedula'    => $resultado['numero_cedula'] ?? null,
                        'fecha_nacimiento' => $resultado['fecha_nacimiento'] ?? null,
                        'nombres'          => $resultado['nombres'] ?? null,
                        'apellidos'        => $resultado['apellidos'] ?? null,
                        'complemento'      => $resultado['complemento'] ?? null,
                        'fecha_emision'    => $resultado['fecha_emision'] ?? null,
                        'fecha_expiracion' => $resultado['parametros_control']['fecha_expiracion'] ?? null,
                    ];
                    $docAnverso->update(['calidad_legible' => ($resultado['numero_cedula'] ?? null) !== null]);
                    $docAnverso->datos()->delete();
                    foreach (array_filter($camposOcr, fn($v) => $v !== null) as $campo => $valor) {
                        $docAnverso->datos()->create([
                            'nombre_campo'   => $campo,
                            'valor_extraido' => (string) $valor,
                        ]);
                    }
                }
            }

            $motivos = [];
            $parametros = ParametroControl::all()->keyBy('nombre_parametro');

            // 1. Número de carnet
            $extraido = $this->normalizar($resultado['numero_cedula'] ?? '');
            $declarado = $this->normalizar($user->numero_carnet);

            // C. Detección de duplicado por carnet extraído por OCR
            $posibleDuplicado = null;
            if ($extraido !== '') {
                $otraUsuaria = User::where('numero_carnet', $extraido)
                    ->where('id', '!=', $user->id)
                    ->first();
                if ($otraUsuaria) {
                    $posibleDuplicado = [
                        'user_id' => $otraUsuaria->id,
                        'nombre'  => $otraUsuaria->name,
                        'email'   => $otraUsuaria->email,
                        'estado'  => $otraUsuaria->estado_verificacion,
                    ];
                }
            }
            if ($extraido === '') {
                $motivos[] = 'No se pudo leer el número de cédula del documento.';
                $this->guardarResultado($registro, null, 'rechazado', 'OCR no pudo extraer el número de cédula.');
            } elseif ($extraido !== $declarado) {
                $motivos[] = 'El número de carnet declarado no coincide con el del documento.';
                $this->guardarResultado($registro, null, 'rechazado',
                    "Declarado: {$declarado} — OCR: {$extraido}");
            } else {
                $this->guardarResultado($registro, null, 'aprobado',
                    "Número cédula coincide: {$extraido}");
            }

            // 1b. Parámetros de control del documento
            $control = $resultado['parametros_control'] ?? null;
            if ($control) {
                $vigente = $control['vigente'] ?? null;
                $paramVigencia = $parametros->get('vigencia_cedula') ?? $parametros->get('vigencia');
                if ($vigente === false) {
                    $motivos[] = 'El documento de identidad está vencido.';
                    $this->guardarResultado($registro, $paramVigencia?->id, 'rechazado',
                        'Fecha de expiración: '.($control['fecha_expiracion'] ?? 'desconocida'));
                } elseif ($vigente === true) {
                    $this->guardarResultado($registro, $paramVigencia?->id, 'aprobado',
                        'Documento vigente. Expira: '.($control['fecha_expiracion'] ?? 'N/A'));
                }

                foreach ($control['errores'] ?? [] as $error) {
                    $motivos[] = $error;
                    $this->guardarResultado($registro, null, 'rechazado', $error);
                }
            }

            // 1c. Cruce de fecha de nacimiento
            $nacOcr = $this->fechaOcr($resultado['fecha_nacimiento'] ?? null);
            $nacDeclarada = optional($user->fecha_nacimiento)->format('Y-m-d');
            if ($nacOcr && $nacDeclarada && $nacOcr !== $nacDeclarada) {
                $motivos[] = 'La fecha de nacimiento declarada no coincide con la del documento.';
                $this->guardarResultado($registro, null, 'rechazado',
                    "Declarada: {$nacDeclarada} — OCR: {$nacOcr}");
            } elseif ($nacOcr && $nacDeclarada) {
                $this->guardarResultado($registro, null, 'aprobado', 'Fecha de nacimiento coherente.');
            }

            // 2. Detección de vida
            $vida = $resultado['deteccion_vida'] ?? null;
            $paramVida = $parametros->get('deteccion_vida') ?? $parametros->get('liveness');
            if ($vida === null) {
                $motivos[] = 'No se ejecutó la detección de vida.';
                $this->guardarResultado($registro, $paramVida?->id, 'rechazado', 'Servicio de liveness no respondió.');
            } elseif ($vida['error'] ?? false) {
                $motivos[] = 'Detección de vida: '.$vida['error'];
                $this->guardarResultado($registro, $paramVida?->id, 'rechazado', $vida['error']);
            } elseif (! ($vida['es_real'] ?? false)) {
                $motivos[] = 'La selfie no proviene de una persona real frente a la cámara.';
                $this->guardarResultado($registro, $paramVida?->id, 'rechazado',
                    'Score: '.($vida['score'] ?? 'N/A').' (umbral: '.($vida['umbral'] ?? 'N/A').')');
            } else {
                $this->guardarResultado($registro, $paramVida?->id, 'aprobado',
                    'Score: '.($vida['score'] ?? 'N/A').' (umbral: '.($vida['umbral'] ?? 'N/A').')');
            }

            // 3. Verificación facial
            $facial = $resultado['verificacion_facial'] ?? null;
            $veredictoFacial = $facial['veredicto'] ?? null;
            $paramFacial = $parametros->get('coincidencia_facial') ?? $parametros->get('verificacion_facial');

            if ($vida && ($vida['es_real'] ?? false)) {
                if ($facial === null) {
                    $motivos[] = 'No se realizó la verificación facial.';
                    $this->guardarResultado($registro, $paramFacial?->id, 'rechazado', 'Servicio facial no respondió.');
                } elseif ($facial['error'] ?? false) {
                    $motivos[] = 'Verificación facial: '.$facial['error'];
                    $this->guardarResultado($registro, $paramFacial?->id, 'rechazado', $facial['error']);
                } elseif ($veredictoFacial === 'rechazado') {
                    $motivos[] = 'El rostro de la selfie no coincide con la fotografía del carnet.';
                    $this->guardarResultado($registro, $paramFacial?->id, 'rechazado',
                        'Distancia: '.($facial['distancia'] ?? 'N/A').' (umbral: '.($facial['umbral_aprobar'] ?? 'N/A').')');
                } elseif ($veredictoFacial === 'revision_humana') {
                    $this->guardarResultado($registro, $paramFacial?->id, 'observado',
                        'Distancia ambigua: '.($facial['distancia'] ?? 'N/A').' (umbral: '.($facial['umbral_aprobar'] ?? 'N/A').')');
                } else {
                    $this->guardarResultado($registro, $paramFacial?->id, 'aprobado',
                        'Distancia: '.($facial['distancia'] ?? 'N/A').' (umbral: '.($facial['umbral_aprobar'] ?? 'N/A').')');
                }
            }

            // 3b. Licencia de conducir (solo conductoras)
            $licencia = null;
            $licenciaIndeterminada = false;
            if ($user->hasRole('conductora')) {
                if (! $user->licencia_path) {
                    $motivos[] = 'No se cargó la licencia de conducir.';
                    $this->guardarResultado($registro, null, 'rechazado', 'Licencia no cargada.');
                } else {
                    try {
                        $licencia = $ia->procesarLicencia(Storage::disk('local')->path($user->licencia_path));
                    } catch (\Throwable $e) {
                        $motivos[] = 'No se pudo validar la licencia de conducir.';
                        Log::warning('Validación de licencia falló', ['user' => $this->userId, 'error' => $e->getMessage()]);
                    }

                    $veredictoLic = $licencia['veredicto'] ?? null;
                    if ($licencia && ($licencia['error'] ?? false)) {
                        $motivos[] = 'Licencia: '.$licencia['error'];
                        $this->guardarResultado($registro, null, 'rechazado', 'Error licencia: '.$licencia['error']);
                    } elseif ($veredictoLic === 'no_profesional') {
                        $motivos[] = 'La licencia de conducir no es de categoría profesional.';
                        $this->guardarResultado($registro, null, 'rechazado',
                            'Categoría: '.($licencia['categoria'] ?? 'N/A'));
                    } elseif ($veredictoLic === 'indeterminado') {
                        $licenciaIndeterminada = true;
                        $this->guardarResultado($registro, null, 'observado',
                            'Categoría profesional no determinada. Requiere revisión.');
                    } else {
                        $this->guardarResultado($registro, null, 'aprobado',
                            'Licencia profesional. Categoría: '.($licencia['categoria'] ?? 'N/A'));
                    }
                }
            }

            // 4. Decisión final
            $facialAprobado = $veredictoFacial === 'aprobado';
            $requiereRevision = $veredictoFacial === 'revision_humana' || $licenciaIndeterminada;

            if (empty($motivos) && $facialAprobado && ! $requiereRevision) {
                $estadoFinal = 'verificada';
                $estadoRegistro = 'aprobado';
            } elseif (empty($motivos) && $requiereRevision) {
                $estadoFinal = 'pendiente';
                $estadoRegistro = 'observado';
                if ($veredictoFacial === 'revision_humana') {
                    $motivos[] = 'La coincidencia facial es ambigua. Tu registro será revisado por un administrador.';
                }
                if ($licenciaIndeterminada) {
                    $motivos[] = 'No se pudo confirmar automáticamente la categoría profesional de la licencia. Será revisada por un administrador.';
                }
            } else {
                $estadoFinal = 'rechazada';
                $estadoRegistro = 'rechazado';
            }

            $motivoFinal = empty($motivos) ? null : implode(' ', $motivos);

            $user->update([
                'estado_verificacion' => $estadoFinal,
                'resultado_analisis' => array_merge($resultado, [
                    'numero_declarado'   => $declarado,
                    'numero_extraido'    => $extraido,
                    'validacion_licencia' => $licencia,
                    'motivo_rechazo'     => $motivoFinal,
                    'posible_duplicado'  => $posibleDuplicado,
                ]),
                'analizado_en' => now(),
            ]);

            if ($registro) {
                $registro->update(['estado_resultado' => $estadoRegistro]);
            }

            // Notificar a la usuaria por email
            try {
                $user->notify(new ResultadoVerificacion($estadoFinal, $motivoFinal));
            } catch (\Throwable $e) {
                Log::warning('No se pudo enviar notificación email a usuaria', [
                    'user' => $this->userId,
                    'error' => $e->getMessage(),
                ]);
            }

            // Si el caso quedó pendiente, notificar a todos los admins
            if ($estadoFinal === 'pendiente') {
                try {
                    $admins = User::whereHas('role', fn ($q) => $q->where('nombre', Role::ADMINISTRADOR))
                        ->where('activa', true)
                        ->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new CasoPendienteRevision($user, $motivoFinal));
                    }
                } catch (\Throwable $e) {
                    Log::warning('No se pudo notificar a admins de caso pendiente', ['error' => $e->getMessage()]);
                }
            }

        } catch (\Throwable $e) {
            Log::error('AnalizarRegistroJob falló', ['user' => $this->userId, 'error' => $e->getMessage()]);
            $user->update([
                'estado_verificacion' => 'pendiente',
                'resultado_analisis' => array_merge($user->resultado_analisis ?? [], [
                    'motivo_rechazo' => 'No se pudo completar la verificación automática. Tu registro será revisado por un administrador.',
                    'error_tecnico'  => $e->getMessage(),
                ]),
                'analizado_en' => now(),
            ]);

            if ($registro) {
                $registro->update(['estado_resultado' => 'observado']);
            }
        }
    }

    private function guardarResultado(
        ?RegistroVerificacion $registro,
        ?int $parametroId,
        string $resultado,
        ?string $detalle = null
    ): void {
        if (! $registro) {
            return;
        }

        ResultadoValidacion::create([
            'registro_id'  => $registro->id,
            'parametro_id' => $parametroId,
            'resultado'    => $resultado,
            'detalle'      => $detalle,
        ]);
    }

    private function normalizar(string $valor): string
    {
        return preg_replace('/\D/', '', $valor) ?? '';
    }

    private function fechaOcr(?string $valor): ?string
    {
        if (! $valor) {
            return null;
        }

        // Eliminar prefijos comunes que algunos carnets incluyen en el campo
        $texto = preg_replace(
            '/\b(expira(?:ción)?|vence|válido?\s+hasta|hasta|el|fecha:?)\b\s*/iu',
            '',
            trim($valor)
        );
        $texto = trim($texto);

        // Formatos numéricos
        foreach (['d/m/Y', 'd-m-Y', 'Y-m-d', 'd.m.Y'] as $fmt) {
            $dt = \DateTime::createFromFormat('!' . $fmt, $texto);
            $errores = \DateTime::getLastErrors();
            if ($dt && empty($errores['errors']) && empty($errores['warnings'])) {
                return $dt->format('Y-m-d');
            }
        }

        // Formato textual en español: "18 de julio de 1978" / "8 de noviembre 2031"
        $meses = [
            'enero' => 1, 'febrero' => 2, 'marzo' => 3, 'abril' => 4,
            'mayo' => 5, 'junio' => 6, 'julio' => 7, 'agosto' => 8,
            'septiembre' => 9, 'octubre' => 10, 'noviembre' => 11, 'diciembre' => 12,
        ];

        if (preg_match('/(\d{1,2})\s+de\s+(\w+)(?:\s+de)?\s+(\d{4})/iu', $texto, $m)) {
            $dia  = (int) $m[1];
            $mes  = $meses[strtolower($m[2])] ?? null;
            $anio = (int) $m[3];
            if ($mes && checkdate($mes, $dia, $anio)) {
                return sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
            }
        }

        return null;
    }
}
