<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProyectoEnRevision extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    public $nombre_proyecto;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $nombre_proyecto)
    {
        $this->username = $username;
        $this->nombre_proyecto = $nombre_proyecto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.proyecto_en_revision')
        ->with([
            'username' => $this->username,
            'email' => $this->nombre_proyecto,
        ])
        ->subject('Proyecto para Revisión');
    }
}
