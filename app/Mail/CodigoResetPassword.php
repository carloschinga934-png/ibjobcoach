<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodigoResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $codigo;

    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }

    public function build()
    {
        return $this->subject(' Código de restablecimiento IBJobCoach')
            ->priority(1) // Alta prioridad (marca como importante)
            ->view('emails.codigo-reset-password')
            ->withSwiftMessage(function ($message) {
                // Agrega encabezados para marcar como importante
                $message->getHeaders()->addTextHeader('X-Priority', '1 (Highest)');
                $message->getHeaders()->addTextHeader('X-MSMail-Priority', 'High');
                $message->getHeaders()->addTextHeader('Importance', 'High');
            });
    }
}
