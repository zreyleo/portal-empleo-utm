<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEmpresaRegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $nombreEmpresa;
    private $nombreFacultad;

    public $subject = 'Una nueva empresa quiere registrarse';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombreEmpresa, $nombreFacultad)
    {
        $this->nombreEmpresa = $nombreEmpresa;
        $this->nombreFacultad = $nombreFacultad;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('mails.registration', [
                'nombreEmpresa' => $this->nombreEmpresa,
                'nombreFacultad' => $this->nombreFacultad,
            ]);
    }
}
