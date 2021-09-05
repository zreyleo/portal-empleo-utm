<?php

namespace Tests\Unit;

use App\Perfil;
use App\Personal;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class PersonalTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_full_name_of_personal_model()
    {
        $personal = Personal::find(66710); // ID of system's author

        $this->assertEquals('ZAMBRANO PERERO REGYNALD LEONARDO', $personal->nombres_completos);
    }

    public function test_perfil_of_personal_is_an_instance_of_perfil_model()
    {
        $personal = Personal::find(66710); // ID of system's author
        $perfil = Perfil::create([
            'personal_id' => $personal->idpersonal
        ]);
        // dd($perfil);

        // $this->assertEquals('ZAMBRANO PERERO REGYNALD LEONARDO', $personal->nombres_completos);
        $this->assertInstanceOf(Perfil::class,  $personal->perfil);
    }
}
