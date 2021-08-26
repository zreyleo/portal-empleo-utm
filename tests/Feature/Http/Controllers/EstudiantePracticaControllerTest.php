<?php

namespace Tests\Feature;

use App\Http\Controllers\EstudianteController;

use App\Practica;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class EstudiantePracticaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_estudiante_can_reserve_a_place_in_practica_offer()
    {
        $this->session([
            'id_personal' => 66710,
            'role' => EstudianteController::get_role()
        ]);

        $practica = factory(Practica::class)->create([
            'facultad_id' => 2
        ]);

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'));

        $this->assertDatabaseHas('estudiantes_practicas', [
            'estudiante_id' => 66710,
            'practica_id' => $practica->id
        ]);
    }

    public function test_estudiante_can_not_reserve_another_practica_within_a_month()
    {
        $this->session([
            'id_personal' => 66710,
            'role' => EstudianteController::get_role()
        ]);

        $practica = factory(Practica::class)->create([
            'facultad_id' => 2
        ]);

        $practica_2 = factory(Practica::class)->create([
            'facultad_id' => 2
        ]);

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'));

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica_2->id]))
            ->assertRedirect(route('estudiantes.practicas_offers'))
            ->assertSessionHasErrors();
    }

    // public function test_()
    // {

    // }
}
