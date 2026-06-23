<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CasoPendienteRevision extends Notification
{
    public function __construct(
        public User $usuaria,
        public ?string $motivo = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuevo caso pendiente de revisión — Lady\'s On Go')
            ->greeting("Hola, {$notifiable->name}")
            ->line("El registro de **{$this->usuaria->name}** requiere revisión manual.")
            ->when($this->motivo, fn ($m) => $m->line("**Motivo:** {$this->motivo}"))
            ->action('Revisar caso', url("/admin/usuarias/{$this->usuaria->id}"))
            ->line('Por favor revisa y resuelve este caso a la brevedad posible.');
    }
}
