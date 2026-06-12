<?php

namespace App\Jobs;

use App\Models\User;
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

        try {
            $resultado = $ia->procesarCedula(
                Storage::disk('local')->path($user->carnet_anverso_path),
                Storage::disk('local')->path($user->carnet_reverso_path),
                $user->selfie_path ? Storage::disk('local')->path($user->selfie_path) : null,
            );

            $motivos = [];

            // 1. Número de carnet
            $extraido = $this->normalizar($resultado['numero_cedula'] ?? '');
            $declarado = $this->normalizar($user->numero_carnet);
            if ($extraido === '') {
                $motivos[] = 'No se pudo leer el número de cédula del documento.';
            } elseif ($extraido !== $declarado) {
                $motivos[] = 'El número de carnet declarado no coincide con el del documento.';
            }

            // 1b. Parámetros de control del documento (vigencia y campos mínimos)
            $control = $resultado['parametros_control'] ?? null;
            if ($control) {
                foreach ($control['errores'] ?? [] as $error) {
                    $motivos[] = $error;
                }
            }

            // 1c. Cruce de fecha de nacimiento: OCR del documento vs. declarada
            $nacOcr = $this->fechaOcr($resultado['fecha_nacimiento'] ?? null);
            $nacDeclarada = optional($user->fecha_nacimiento)->format('Y-m-d');
            if ($nacOcr && $nacDeclarada && $nacOcr !== $nacDeclarada) {
                $motivos[] = 'La fecha de nacimiento declarada no coincide con la del documento.';
            }

            // 2. Detección de vida (anti-spoofing) — bloqueante
            $vida = $resultado['deteccion_vida'] ?? null;
            if ($vida === null) {
                $motivos[] = 'No se ejecutó la detección de vida.';
            } elseif ($vida['error'] ?? false) {
                $motivos[] = 'Detección de vida: '.$vida['error'];
            } elseif (! ($vida['es_real'] ?? false)) {
                $motivos[] = 'La selfie no proviene de una persona real frente a la cámara.';
            }

            // 3. Verificación facial (solo si vida pasó)
            $facial = $resultado['verificacion_facial'] ?? null;
            $veredictoFacial = $facial['veredicto'] ?? null;

            if ($vida && ($vida['es_real'] ?? false)) {
                if ($facial === null) {
                    $motivos[] = 'No se realizó la verificación facial.';
                } elseif ($facial['error'] ?? false) {
                    $motivos[] = 'Verificación facial: '.$facial['error'];
                } elseif ($veredictoFacial === 'rechazado') {
                    $motivos[] = 'El rostro de la selfie no coincide con la fotografía del carnet.';
                }
            }

            // 3b. Licencia de conducir profesional (solo conductoras)
            $licencia = null;
            $licenciaIndeterminada = false;
            if ($user->hasRole('conductora')) {
                if (! $user->licencia_path) {
                    $motivos[] = 'No se cargó la licencia de conducir.';
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
                    } elseif ($veredictoLic === 'no_profesional') {
                        $motivos[] = 'La licencia de conducir no es de categoría profesional.';
                    } elseif ($veredictoLic === 'indeterminado') {
                        $licenciaIndeterminada = true;
                    }
                }
            }

            // 4. Decisión final
            $facialAprobado = $veredictoFacial === 'aprobado';
            $requiereRevision = $veredictoFacial === 'revision_humana' || $licenciaIndeterminada;

            if (empty($motivos) && $facialAprobado && ! $requiereRevision) {
                $estadoFinal = 'verificada';
            } elseif (empty($motivos) && $requiereRevision) {
                $estadoFinal = 'pendiente';
                if ($veredictoFacial === 'revision_humana') {
                    $motivos[] = 'La coincidencia facial es ambigua. Tu registro será revisado por un administrador.';
                }
                if ($licenciaIndeterminada) {
                    $motivos[] = 'No se pudo confirmar automáticamente la categoría profesional de la licencia. Será revisada por un administrador.';
                }
            } else {
                $estadoFinal = 'rechazada';
            }

            $user->update([
                'estado_verificacion' => $estadoFinal,
                'resultado_analisis' => array_merge($resultado, [
                    'numero_declarado' => $declarado,
                    'numero_extraido' => $extraido,
                    'validacion_licencia' => $licencia,
                    'motivo_rechazo' => empty($motivos) ? null : implode(' ', $motivos),
                ]),
                'analizado_en' => now(),
            ]);
        } catch (\Throwable $e) {
            // Un fallo del servicio de IA (caído, timeout, error) NO debe rechazar a
            // la usuaria: queda en revisión manual para que un administrador reintente.
            Log::error('AnalizarRegistroJob falló', ['user' => $this->userId, 'error' => $e->getMessage()]);
            $user->update([
                'estado_verificacion' => 'pendiente',
                'resultado_analisis' => array_merge($user->resultado_analisis ?? [], [
                    'motivo_rechazo' => 'No se pudo completar la verificación automática. Tu registro será revisado por un administrador.',
                    'error_tecnico' => $e->getMessage(),
                ]),
                'analizado_en' => now(),
            ]);
        }
    }

    private function normalizar(string $valor): string
    {
        return preg_replace('/\D/', '', $valor) ?? '';
    }

    /** Convierte una fecha OCR 'DD/MM/YYYY' a 'YYYY-MM-DD'; null si no es válida. */
    private function fechaOcr(?string $valor): ?string
    {
        if (! $valor) {
            return null;
        }
        $fecha = \DateTime::createFromFormat('d/m/Y', trim($valor));
        return $fecha ? $fecha->format('Y-m-d') : null;
    }
}