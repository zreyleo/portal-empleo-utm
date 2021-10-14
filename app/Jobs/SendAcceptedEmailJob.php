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

    private string $estudianteEmail;
    private string $nombreEmpresa;
    private string $empleoTitulo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $estudianteEmail, string $nombreEmpresa, string $empleoTitulo)
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
