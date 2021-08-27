<?php

namespace Tests\Feature\Http\Controllers;

use App\Empleo;

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
        $this->session([
            'id_empresa' => 44,
            'role' => EmpresaController::get_role()
        ]);

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

        $this->session([
            'id_empresa' => 44,
            'role' => EmpresaController::get_role()
        ]);

        $response = $this->get(route('empleos.index'));

        $response->assertStatus(200)
            ->assertSee('Ver');
    }

    public function test_store()
    {
        $this->session([
            'id_empresa' => 44,
            'role' => EmpresaController::get_role()
        ]);

        $this->post(route('empleos.store'), [
            'titulo' => 'Se necesita Ingeniero en Sistemas',
            'requerimientos' => 'Para hacer un CRUD',
            'carrera' => 1,
        ])->assertRedirect(route('empleos.index'));
    }

    public function test_store_validate()
    {
        $this->session([
            'id_empresa' => 44,
            'role' => EmpresaController::get_role()
        ]);

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
        $this->session([
            'id_personal' => 66710, // id_personal of a random estudiante
            'idfacultad' => 2,
            'idescuela' => 1, // id = ingenieria en sistemas
            'role' => EstudianteController::get_role()
        ]);

        $response = $this->get(route('estudiantes.empleos_offers'));

        $response->assertStatus(200);
    }

    public function test_estudiante_can_see_a_empleo_details()
    {
        $this->withoutExceptionHandling();
        $this->session([
            'id_personal' => 66710, // id_personal of a random estudiante
            'idfacultad' => 2,
            'idescuela' => 1, // id = ingenieria en sistemas
            'role' => EstudianteController::get_role()
        ]);

        $empleo = factory(Empleo::class)->create([
            'carrera_id' => 1
        ]);

        $response = $this->get(route('estudiantes.empleo_details_for_estudiante', ['empleo' => $empleo->id]));

        $response->assertStatus(200)
            ->assertSee($empleo->titulo);
    }

    // public function test_()
    // {

    // }
}
