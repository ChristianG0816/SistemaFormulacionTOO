<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevoUsuarioCreado extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    public $email;
    public $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $email, $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.nuevo_usuario')
        ->with([
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ])
        ->subject('Nuevo usuario creado');
    }
}
