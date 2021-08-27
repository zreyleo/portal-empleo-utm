<?php

namespace Tests\Feature;

use App\Empleo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class EstudianteEmpleoControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->session([
            'id_personal' => 66710, // id_personal of a random estudiante
            'idfacultad' => 2,
            'idescuela' => 1, // id = ingenieria en sistemas
            'role' => EstudianteController::get_role()
        ]);
    }

    public function text_estudiante_can_post_to_empleo_offer()
    {
        $empleo = factory(Empleo::class)->create([
            'carrera_id' => 1
        ]);

        $this->post(route('estudiantes.empleos_offers', ['empleo' => $empleo->id]))
            ->assertRedirect(route('estudiantes_emplos.index'));

        $this->assertDatabaseHas('estudiantes_empleos', [
            'estudiante_id' => 66710,
            'empleo_id' => $empleo->id
        ]);
    }

    // public function text_()
    // {

    // }
}
