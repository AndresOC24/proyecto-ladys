<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ServicioIA
{
    private string $baseUrl;
    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.ia.url'), '/');
        $this->timeout = (int) config('services.ia.timeout', 30);
    }

    public function health(): array
    {
        return $this->cliente()->get('/health')->throw()->json();
    }

    public function procesarCedula(string $rutaAnverso, string $rutaReverso, ?string $rutaSelfie = null): array
    {
        $request = $this->cliente()
            ->timeout(120)
            ->attach('anverso', file_get_contents($rutaAnverso), basename($rutaAnverso))
            ->attach('reverso', file_get_contents($rutaReverso), basename($rutaReverso));

        if ($rutaSelfie !== null) {
            $request = $request->attach('selfie', file_get_contents($rutaSelfie), basename($rutaSelfie));
        }

        return $request->post('/procesar-cedula')->throw()->json();
    }

    /**
     * Valida una licencia de conducir (categoría profesional) vía OCR.
     *
     * @param string $rutaLicencia  ruta absoluta a la imagen de la licencia
     */
    public function procesarLicencia(string $rutaLicencia): array
    {
        return $this->cliente()
            ->timeout(120)
            ->attach('licencia', file_get_contents($rutaLicencia), basename($rutaLicencia))
            ->post('/procesar-licencia')
            ->throw()
            ->json();
    }

    /**
     * @param string $rutaDocumento  ruta absoluta a la imagen del documento
     * @param string $rutaSelfie     ruta absoluta a la imagen facial en vivo
     */
    public function verificarRostro(string $rutaDocumento, string $rutaSelfie): array
    {
        try {
            return $this->cliente()
                ->attach('documento', file_get_contents($rutaDocumento), basename($rutaDocumento))
                ->attach('selfie', file_get_contents($rutaSelfie), basename($rutaSelfie))
                ->post('/verificar-rostro')
                ->throw()
                ->json();
        } catch (ConnectionException $e) {
            Log::error('IA service down', ['error' => $e->getMessage()]);
            throw new \RuntimeException('El servicio de IA no está disponible.');
        } catch (RequestException $e) {
            Log::error('IA request failed', ['status' => $e->response->status(), 'body' => $e->response->body()]);
            throw new \RuntimeException('Error procesando la verificación facial.');
        }
    }

    public function ocrCedula(string $rutaDocumento): array
    {
        return $this->cliente()
            ->attach('documento', file_get_contents($rutaDocumento), basename($rutaDocumento))
            ->post('/ocr-cedula')
            ->throw()
            ->json();
    }

    private function cliente()
    {
        return Http::baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->acceptJson();
    }
}