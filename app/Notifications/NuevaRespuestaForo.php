<?php

namespace App\Notifications;

use App\Models\Foro;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NuevaRespuestaForo extends Notification
{
    use Queueable;

    public function __construct(
        public Foro $foro,
        public string $respondedor,
        public string $mensaje
    ) {}

    public function via($notifiable): array
    {
        return ['database']; // guardamos en BD
    }

    public function toDatabase($notifiable): array
    {
        return [
            'foro_id'      => $this->foro->idforo,
            'foro_titulo'  => $this->foro->titulo,
            'respondedor'  => $this->respondedor,
            'mensaje'      => Str::limit($this->mensaje, 120),
            'url'          => route('admin.foro.show', $this->foro->idforo),
        ];
    }
}
