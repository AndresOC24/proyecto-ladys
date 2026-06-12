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

            // 4. Decisión final
            if (empty($motivos) && $veredictoFacial === 'aprobado') {
                $estadoFinal = 'verificada';
            } elseif (empty($motivos) && $veredictoFacial === 'revision_humana') {
                $estadoFinal = 'pendiente';
                $motivos[] = 'La coincidencia facial es ambigua. Tu registro será revisado por un administrador.';
            } else {
                $estadoFinal = 'rechazada';
            }

            $user->update([
                'estado_verificacion' => $estadoFinal,
                'resultado_analisis' => array_merge($resultado, [
                    'numero_declarado' => $declarado,
                    'numero_extraido' => $extraido,
                    'motivo_rechazo' => empty($motivos) ? null : implode(' ', $motivos),
                ]),
                'analizado_en' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('AnalizarRegistroJob falló', ['user' => $this->userId, 'error' => $e->getMessage()]);
            $user->update([
                'estado_verificacion' => 'rechazada',
                'resultado_analisis' => ['motivo_rechazo' => 'Error al procesar las imágenes: '.$e->getMessage()],
                'analizado_en' => now(),
            ]);
        }
    }

    private function normalizar(string $valor): string
    {
        return preg_replace('/\D/', '', $valor) ?? '';
    }
}