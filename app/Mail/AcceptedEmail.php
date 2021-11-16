<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcceptedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Tu aplicacion esta en observacion';

    private $vacante;
    private $nombreEmpresa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vacante, $nombreEmpresa)
    {
        $this->vacante = $vacante;
        $this->nombreEmpresa = $nombreEmpresa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.accepted', [
            'vacante' => $this->vacante,
            'nombreEmpresa' => $this->nombreEmpresa,
        ]);
    }
}
