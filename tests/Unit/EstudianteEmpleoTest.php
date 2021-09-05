<?php

namespace Tests\Unit;

use App\Empleo;
use App\EstudianteEmpleo;
use App\Perfil;
use App\Personal;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class EstudianteEmpleoTest extends TestCase
{
    use RefreshDatabase;

    public function test_assert_that_estudianteEmpleo_personal_is_a_instance_Personal_model()
    {
        $empleo = factory(Empleo::class)->create();

        $estudiante_empleo = factory(EstudianteEmpleo::class)->create([
            'estudiante_id' => 66710,
            'empleo_id' => $empleo->id,
        ]);

        $this->assertInstanceOf(Personal::class, $estudiante_empleo->personal);

        $this->assertEquals('ZAMBRANO PERERO REGYNALD LEONARDO', $estudiante_empleo->personal->nombres_completos);
    }

    public function test_assert_that_estudianteEmpleo_perfil_is_a_instance_Perfil_model()
    {
        $empleo = factory(Empleo::class)->create();

        $estudiante_empleo = factory(EstudianteEmpleo::class)->create([
            'estudiante_id' => 66710,
            'empleo_id' => $empleo->id,
        ]);

        Perfil::create([
            'personal_id' => 66710
        ]);

        $this->assertInstanceOf(Personal::class, $estudiante_empleo->personal);

        $this->assertInstanceOf(Perfil::class, $estudiante_empleo->perfil);
    }
}
