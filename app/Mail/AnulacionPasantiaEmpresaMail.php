<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnulacionPasantiaEmpresaMail extends Mailable
{
    use Queueable, SerializesModels;

    private $empresa;
    private $practica;
    private $razon;

    public $subject = 'Tu Solicitud de PPP ha sido anulada';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($empresa, $practica, $razon)
    {
        $this->empresa = $empresa;
        $this->practica = $practica;
        $this->razon = $razon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.anulacion', [
            'empresa' => $this->empresa,
            'practica' => $this->practica,
            'razon' => $this->razon
        ]);
    }
}
