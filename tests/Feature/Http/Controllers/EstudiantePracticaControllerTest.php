<?php

namespace Tests\Feature\Http\Controllers;

use App\EstudiantePractica;
use App\Http\Controllers\EstudianteController;
use App\Pasantia;
use App\Practica;

// use Carbon\Carbon;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class EstudiantePracticaControllerTest extends TestCase
{
    // use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session([
            'id_personal' => 66710,
            'nombres' => 'ZAMBRANO PERERO REGYNALD LEONARDO',
            'idescuela' => 1,
            'idmalla' => 1,
            'idperiodo' => 138,
            'idfacultad' => 2,
            'is_redesign' => false,
            'is_matriculado' => false,
            'can_register_ppp' => true,
            'role' => EstudianteController::get_role()
        ]);
    }

    public function test_estudiante_can_reserve_a_place_in_practica_offer()
    {
        $practica = factory(Practica::class)->create([
            'facultad_id' => 2
        ]);

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'));

        $this->assertDatabaseHas('estudiantes_practicas', [
            'estudiante_id' => 66710,
            'practica_id' => $practica->id
        ]);

        $estudiante_practica = EstudiantePractica::first();
        $estudiante_practica->delete();

        $practica->delete();

        $pasantia = Pasantia::where('id_pasante', 66710)->latest()->get()->first();
        $pasantia->delete();
    }

    public function test_estudiante_can_not_reserve_another_practica_with_other_with_state_pending()
    {
        $practica = factory(Practica::class)->create([
            'facultad_id' => 2
        ]);

        $practica_2 = factory(Practica::class)->create([
            'facultad_id' => 2
        ]);

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'));

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica_2->id]))
            ->assertRedirect(route('estudiantes_practicas.index'))
            ->assertSessionHasErrors();

        $estudiante_practica = EstudiantePractica::first();
        $estudiante_practica->delete();

        $practica->delete();
        $practica_2->delete();

        $pasantia = Pasantia::where('id_pasante', 66710)->latest()->get()->first();
        $pasantia->delete();
    }

    public function test_estudiante_can_not_reserve_the_same_practica_twice()
    {
        $practica = factory(Practica::class)->create([
            'facultad_id' => 2,
            'cupo' => 2
        ]);

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'));

        $pasantia = Pasantia::where('id_pasante', 66710)->latest()->get()->first();
        $pasantia->estado = 4;
        $pasantia->save();

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'))
            ->assertSessionHasErrors();

        $estudiante_practica = EstudiantePractica::first();
        $estudiante_practica->delete();

        $practica->delete();

        $pasantia->delete();
    }

    public function test_estudiante_can_destroy_its_own_estudiante_practica_record()
    {
        $practica = factory(Practica::class)->create([
            'facultad_id' => 2
        ]);

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'));

        $estudiante_practica = EstudiantePractica::where([
            'estudiante_id' => 66710,
            'practica_id' => $practica->id,
        ])->get()[0];

        $this->delete(route('estudiantes_practicas.destroy', ['estudiante_practica' => $estudiante_practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'));

        $this->assertDatabaseMissing('estudiantes_practicas', [
            'estudiante_id' => 66710,
            'practica_id' => $practica->id,
        ]);

        $estudiante_practica->delete();

        $practica->delete();
    }

    public function test_estudiante_can_see_empresa_contact_info_of_estudiante_practica_record()
    {
        $practica = factory(Practica::class)->create([
            'facultad_id' => 2
        ]);

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'));

        $estudiante_practica = EstudiantePractica::where([
            'estudiante_id' => 66710,
            'practica_id' => $practica->id,
        ])->get()[0];

        $this->get(route('estudiantes_practicas.show_empresa_contact_info', ['estudiante_practica' => $estudiante_practica]))
            ->assertStatus(200)
            ->assertSee($estudiante_practica->practica->empresa->nombre_empresa);

        $this->delete(route('estudiantes_practicas.destroy', ['estudiante_practica' => $estudiante_practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'));

        $practica->delete();
    }

    public function test_show_practica_from_estudiante_practica_record()
    {
        $practica = factory(Practica::class)->create([
            'facultad_id' => 2
        ]);

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'));

        $estudiante_practica = EstudiantePractica::where([
            'estudiante_id' => 66710,
            'practica_id' => $practica->id,
        ])->get()[0];

        $this->get(route('estudiantes_practicas.show_practica_details', ['estudiante_practica' => $estudiante_practica->id]))
            ->assertStatus(200)
            ->assertSee($practica->titulo)
            ->assertSee($practica->empresa->nombre_empresa)
            ->assertSee($practica->requerimientos);

        $this->delete(route('estudiantes_practicas.destroy', ['estudiante_practica' => $estudiante_practica->id]))
        ->assertRedirect(route('estudiantes_practicas.index'));

        $practica->delete();
    }

    // public function test_()
    // {

    // }
}
