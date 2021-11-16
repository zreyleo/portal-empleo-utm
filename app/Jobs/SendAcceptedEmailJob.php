<?php

namespace App\Jobs;

use App\Mail\AcceptedEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAcceptedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $estudianteEmail;
    private $nombreEmpresa;
    private $empleoTitulo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($estudianteEmail, $nombreEmpresa, $empleoTitulo)
    {
        $this->estudianteEmail = $estudianteEmail;
        $this->nombreEmpresa = $nombreEmpresa;
        $this->empleoTitulo = $empleoTitulo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new AcceptedEmail($this->empleoTitulo, $this->nombreEmpresa);

        Mail::to($this->estudianteEmail)->send($mail);
    }
}
