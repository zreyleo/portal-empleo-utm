<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEmpresaRegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    private string $nombreEmpresa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $nombreEmpresa)
    {
        $this->nombreEmpresa = $nombreEmpresa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            // ->from('rzambrano2041@utm.edu.ec')
            ->view('new_empresas.registration', [
                'nombreEmpresa' => $this->nombreEmpresa
            ]);
    }
}
