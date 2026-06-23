<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResultadoVerificacion extends Notification
{
    /**
     * @param  string  $estado    'verificada' | 'rechazada' | 'pendiente'
     * @param  string|null  $motivo   Razón del rechazo u observación
     * @param  string  $origen   'automatico' | 'administrador'
     */
    public function __construct(
        public string $estado,
        public ?string $motivo = null,
        public string $origen = 'automatico',
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $nombre = $notifiable->name;

        return match ($this->estado) {
            'verificada' => (new MailMessage)
                ->subject('¡Tu registro fue aprobado! — Lady\'s On Go')
                ->greeting("Hola, {$nombre}")
                ->line('Nos complace informarte que tu proceso de verificación de identidad fue **aprobado**.')
                ->line('Ya puedes acceder a todos los servicios de la plataforma.')
                ->action('Ir a la plataforma', url('/dashboard'))
                ->line('Gracias por confiar en Lady\'s On Go.'),

            'rechazada' => (new MailMessage)
                ->subject('Tu registro requiere corrección — Lady\'s On Go')
                ->greeting("Hola, {$nombre}")
                ->line('Lamentamos informarte que tu proceso de verificación **no pudo ser aprobado**.')
                ->when($this->motivo, fn ($m) => $m->line('**Motivo:** '.$this->motivo))
                ->line('Puedes volver a enviar tu documentación corregida desde la plataforma.')
                ->action('Reenviar documentos', url('/registro/reenviar'))
                ->line('Si tienes dudas, contacta al equipo de Lady\'s On Go.'),

            'pendiente' => (new MailMessage)
                ->subject('Tu registro está en revisión — Lady\'s On Go')
                ->greeting("Hola, {$nombre}")
                ->line('Tu proceso de verificación requiere una **revisión manual** por parte de nuestro equipo.')
                ->when($this->motivo, fn ($m) => $m->line('**Detalle:** '.$this->motivo))
                ->line('Te notificaremos en cuanto tengamos una resolución. Esto generalmente toma menos de 24 horas.')
                ->action('Ver mi estado', url('/mi-perfil'))
                ->line('Gracias por tu paciencia.'),

            default => (new MailMessage)
                ->subject('Actualización de tu registro — Lady\'s On Go')
                ->greeting("Hola, {$nombre}")
                ->line('Hubo una actualización en tu proceso de verificación. Ingresa a la plataforma para más detalles.')
                ->action('Ver mi estado', url('/mi-perfil')),
        };
    }
}
