<?php

namespace Tests\Feature\Http\Controllers;

use App\Empleo;
use App\EstudianteEmpleo;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EstudianteController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\Session;

use Tests\TestCase;

class EmpleoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);
    }

    public function test_index_empty()
    {
        factory(Empleo::class, 2)->create([
            'empresa_id' => 14
        ]);

        $response = $this->get(route('empleos.index'));

        $response->assertStatus(200)
            ->assertSee('No ofertas de empleo creadas');
    }

    public function test_index_with_data()
    {
        factory(Empleo::class, 2)->create([
            'empresa_id' => 44
        ]);

        // dd($empleos);

        $this->get(route('empleos.index'))
            ->assertStatus(200)
            ->assertSee('Ver');
    }

    public function test_store()
    {
        $this->post(route('empleos.store'), [
            'titulo' => 'Se necesita Ingeniero en Sistemas',
            'requerimientos' => 'Para hacer un CRUD',
            'carrera' => 1,
        ])->assertRedirect(route('empleos.index'));
    }

    public function test_store_validate()
    {
        $this->post(route('empleos.store'), [
            'titulo' => 'Se necesita Ingeniero en Sistemas',
            'carrera' => 1,
        ])->assertSessionHasErrors('requerimientos');

        $this->post(route('empleos.store'), [
            'requerimientos' => 'Para hacer un CRUD',
            'carrera' => 1,
        ])->assertSessionHasErrors('titulo');

        $this->post(route('empleos.store'), [
            'titulo' => 'Se necesita Ingeniero en Sistemas',
            'requerimientos' => 'Para hacer un CRUD',
        ])->assertSessionHasErrors('carrera');

        $this->session([
            'role' => 'ESTUDIANTE'
        ]);

        $this->post(route('empleos.store'), [
            'titulo' => 'Se necesita Ingeniero en Sistemas',
            'requerimientos' => 'Para hacer un CRUD',
            'carrera' => 1,
        ])->assertStatus(302);
    }

    public function test_crate_form()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $this->get(route('empleos.create'))
            ->assertStatus(200)
            ->assertSee('Crear una Oferta de Empleo');
    }

    public function test_show()
    {
        $this->withoutExceptionHandling();

        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 44
        ]);

        $this->get(route('empleos.show', $empleo->id))
            ->assertStatus(200)
            ->assertSee($empleo->titulo);
    }

    public function test_show_policy()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 14
        ]);

        $this->get(route('empleos.show', $empleo->id))
            ->assertStatus(403);
    }

    public function test_edit()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 44
        ]);

        $this->get(route('empleos.edit', $empleo->id))
            ->assertStatus(200);
    }

    public function test_edit_policy()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 14
        ]);

        $this->get(route('empleos.show', $empleo->id))
            ->assertStatus(403);
    }

    public function test_update()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'titulo' => 'Se necesita programador',
            'empresa_id' => 44
        ]);

        $this->put(route('empleos.update', $empleo->id), [
            'titulo' => 'Se necesita Ingeniero',
            'requerimientos' => $empleo->requerimientos,
            'carrera' => $empleo->carrera_id,
        ])->assertRedirect(route('empleos.edit', $empleo->id));

        $this->assertDatabaseHas('empleos',
            [
                'titulo' => 'Se necesita Ingeniero'
            ]
        );
    }

    public function test_update_policy()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'titulo' => 'Se necesita programador',
            'empresa_id' => 14
        ]);

        $this->put(route('empleos.update', $empleo->id), [
            'titulo' => 'Se necesita Ingeniero',
            'requerimientos' => $empleo->requerimientos,
            'carrera' => $empleo->carrera_id,
        ])->assertStatus(403);
    }

    public function test_update_validate()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'titulo' => 'Se necesita programador',
            'empresa_id' => 44
        ]);

        $this->put(route('empleos.update', $empleo->id), [
            'titulo' => 'Se necesita Ingeniero en Sistemas',
            'carrera' => 1,
        ])->assertSessionHasErrors('requerimientos');

        $this->put(route('empleos.update', $empleo->id), [
            'requerimientos' => 'Para hacer un CRUD',
            'carrera' => 1,
        ])->assertSessionHasErrors('titulo');

        $this->put(route('empleos.update', $empleo->id), [
            'titulo' => 'Se necesita Ingeniero en Sistemas',
            'requerimientos' => 'Para hacer un CRUD',
        ])->assertSessionHasErrors('carrera');
    }

    public function test_destroy()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 44
        ]);

        $this->delete(route('empleos.destroy', $empleo->id))
            ->assertRedirect(route('empleos.index'));

        $this->assertDatabaseMissing('empleos', [
            'titulo' => $empleo->titulo
        ]);
    }

    public function test_destroy_policy()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 14
        ]);

        $this->delete(route('empleos.destroy', $empleo->id))
            ->assertStatus(403);
    }

    public function test_estudiante_can_see_empleos_offers()
    {
        $this->withoutExceptionHandling();
        $this->session([
            'id_personal' => 66710, // id_personal of a random estudiante
            'idfacultad' => 2,
            'idescuela' => 1, // id = ingenieria en sistemas
            'role' => EstudianteController::get_role()
        ]);

        $response = $this->get(route('empleos.show_empleos_offers'));

        $response->assertStatus(200);
    }

    public function test_estudiante_can_see_a_empleo_details()
    {
        $this->session([
            'id_personal' => 66710, // id_personal of a random estudiante
            'idfacultad' => 2,
            'idescuela' => 1, // id = ingenieria en sistemas
            'role' => EstudianteController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'carrera_id' => 1
        ]);

        $response = $this->get(route('empleos.show_empleo_details', ['empleo' => $empleo->id]));

        $response->assertStatus(200)
            ->assertSee($empleo->titulo);
    }

    public function test_empresa_can_delete_empleo_offer_even_when_it_has_estudiante_empleo_records_related()
    {
        $this->withoutExceptionHandling();

        $this->session([]);

        $this->session([
            'id_personal' => 66710, // id_personal of a random estudiante
            'idfacultad' => 2,
            'idescuela' => 1, // id = ingenieria en sistemas
            'role' => EstudianteController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 44,
            'carrera_id' => 1
        ]);

        $this->post(route('estudiantes_empleos.store', ['empleo' => $empleo->id]))
            ->assertRedirect(route('estudiantes_empleos.index'));

        $this->session([]);

        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $this->delete(route('empleos.destroy', $empleo->id))
            ->assertRedirect(route('empleos.index'));

        $this->assertDatabaseMissing('empleos', [
                'id' => $empleo->id
        ]);

        $this->assertDatabaseMissing('estudiantes_empleos', [
            'estudiante_id' => 66710,
            'empleo_id' => $empleo->id,
        ]);
    }

    public function test_empresas_can_see_a_table_with_the_estudiantes_names()
    {
        $this->withoutExceptionHandling();
        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 44
        ]);

        $estudiantes_empleos = factory(EstudianteEmpleo::class, 2)->create([
            'empleo_id' => $empleo->id
        ]);

        $this->get(route('empleos.show_estudiantes_empleos', ['empleo' => $empleo->id]))
            ->assertStatus(200)
            ->assertSee($estudiantes_empleos[0]->personal->nombres_completos);
    }

    // public function test_()
    // {

    // }
}
