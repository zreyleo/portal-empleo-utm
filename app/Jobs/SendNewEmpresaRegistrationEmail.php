<?php

namespace App\Jobs;

use App\Escuela;
use App\Personal;
use App\Mail\NewEmpresaRegistrationEmail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendNewEmpresaRegistrationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $docentes;
    private string $nombreEmpresa;
    private int $area;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $docentes, string $nombreEmpresa, int $area)
    {
        $this->docentes = $docentes;
        $this->nombreEmpresa = $nombreEmpresa;
        $this->area = $area;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->docentes as $docente) {
            $idescuela = explode('|', $docente->idescuela)[0];
            $escuela = Escuela::find($idescuela);
            if ($escuela->idfacultad == $this->area) {
                $personal = Personal::find($docente->id_personal);
                if ($personal) {
                    $sql_datos_docentes = "
                        select *
                        from f_obtiene_persona_str('$personal->cedula');
                    ";

                    $responsable = DB::connection('DB_ppp_sistema_SCHEMA_public')->select($sql_datos_docentes)[0];

                    // dd($responsable);

                    // enviar_correo(
                    //     "$responsable->email_utm",
                    //     "Una nueva EMPRESA quiere registrarse",
                    //     "$nombre_empresa Quiere registrarse como nueva empresa para publicar ofertas de empleo y PPP"
                    // );

                    $mail = new NewEmpresaRegistrationEmail($this->nombreEmpresa);

                    Mail::to($responsable->email_utm)->send($mail);
                }
            }
        }

    }
}
