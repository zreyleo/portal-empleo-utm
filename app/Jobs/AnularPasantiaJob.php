<?php

namespace App\Jobs;

use App\Mail\AnulacionPasantiaEmpresaMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AnularPasantiaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $pasantias = [];
    private $empresa;
    private $practica;
    private $razon;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pasantias, $empresa, $practica, $razon)
    {
        $this->pasantias = $pasantias;
        $this->empresa = $empresa;
        $this->practica = $practica;
        $this->razon = $razon;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $detalle = 'La empresa ' . $this->empresa . ' decidio anular esta pasantia por esta razon: ' . $this->razon;

        $this->pasantias->toQuery()->update([
            'estado' => 4,
            'detalle' => $detalle
        ]);

        foreach ($this->pasantias as $pasantia) {
            $estudiante_id = $pasantia->id_pasante;

            $sql = "
                select email_utm
                from public.f_obtiene_persona('$estudiante_id');
            ";

            $estudiante_email = DB::connection('DB_ppp_sistema_SCHEMA_public')->select($sql)[0]->email_utm;

            $mail = new AnulacionPasantiaEmpresaMail($this->empresa, $this->practica, $this->razon);

            Mail::to($estudiante_email)->send($mail);
        }
    }
}
