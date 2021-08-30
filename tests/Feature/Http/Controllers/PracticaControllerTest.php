<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EstudianteController;
use App\Practica;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class PracticaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_empty()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        factory(Practica::class)->create([
            'empresa_id' => 14
        ]);

        $response = $this->get(route('practicas.index'));

        $response->assertStatus(200)
            ->assertSee('No hay ofertas de practica creadas.');
    }

    public function test_index_with_data()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $practica = factory(Practica::class)->create([
            'empresa_id' => 44
        ]);

        $response = $this->get(route('practicas.index'));

        $response->assertStatus(200)
            ->assertSee($practica->titulo);
    }

    public function test_store()
    {
        $this->session([
            'id_empresa' => 44,
            'role' => EmpresaController::get_role()
        ]);

        $this->post(route('practicas.store'), [
            'titulo' => 'Se buscan pasantes',
            'requerimientos' => 'Para hacer un CRUD',
            'area' => 1,
        ])->assertRedirect(route('practicas.index'));

        $this->assertDatabaseHas('practicas', [
            'titulo' => 'Se buscan pasantes'
        ]);
    }

    public function test_store_validate()
    {
        $this->session([
            'id_empresa' => 44,
            'role' => EmpresaController::get_role()
        ]);

        $this->post(route('practicas.store'), [
            'titulo' => 'Se buscan pasantes',
            'area' => 1,
        ])->assertSessionHasErrors('requerimientos');

        $this->post(route('practicas.store'), [
            'requerimientos' => 'Para hacer un CRUD',
            'area' => 1,
        ])->assertSessionHasErrors('titulo');

        $this->post(route('practicas.store'), [
            'titulo' => 'Se buscan pasantes',
            'requerimientos' => 'Para hacer un CRUD',
        ])->assertSessionHasErrors('area');

        $this->session([
            'role' => 'ESTUDIANTE'
        ]);

        $this->post(route('practicas.store'), [
            'titulo' => 'Se buscan pasantes',
            'requerimientos' => 'Para hacer un CRUD',
            'area' => 1,
        ])->assertStatus(302);
    }

    public function test_crate_form()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $this->get(route('practicas.create'))
            ->assertStatus(200)
            ->assertSee('Crear una Oferta de Práctica')
            ->assertSee('Área');
    }

    public function test_show()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $practica = factory(Practica::class)->create([
            'empresa_id' => 44
        ]);

        $this->get(route('practicas.show', $practica->id))
            ->assertStatus(200)
            ->assertSee($practica->titulo);
    }

    public function test_show_policy()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $empleo = factory(Practica::class)->create([
            'empresa_id' => 14
        ]);

        $this->get(route('practicas.show', $empleo->id))
            ->assertStatus(403);
    }

    public function test_edit()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $practica = factory(Practica::class)->create([
            'empresa_id' => 44
        ]);

        $this->get(route('practicas.edit', $practica->id))
            ->assertStatus(200)
            ->assertSee($practica->titulo);
    }

    public function test_edit_policy()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $practica = factory(Practica::class)->create([
            'empresa_id' => 14
        ]);

        $this->get(route('practicas.show', $practica->id))
            ->assertStatus(403);
    }

    public function test_update()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $practica = factory(Practica::class)->create([
            'titulo' => 'Se necesita programador',
            'empresa_id' => 44
        ]);

        $this->withoutExceptionHandling();

        $this->put(route('practicas.update', $practica->id), [
            'titulo' => 'Se necesita programador en javascript',
            'area' => $practica->facultad_id,
            'cupo' => 3,
            'requerimientos' => $practica->requerimientos
        ])->assertRedirect(route('practicas.edit', $practica->id));


        $this->assertDatabaseHas('practicas',
            [
                'titulo' => 'Se necesita programador en javascript'
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

        $practica = factory(Practica::class)->create([
            'titulo' => 'Se necesita programador',
            'empresa_id' => 14
        ]);

        $this->put(route('practicas.update', $practica->id), [
            'titulo' => 'Se necesita Ingeniero',
            'requerimientos' => $practica->requerimientos,
            'area' => $practica->facultad_id,
        ])->assertStatus(403);
    }

    public function test_update_validate()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $practica = factory(Practica::class)->create([
            'titulo' => 'Se necesita programador',
            'empresa_id' => 44
        ]);

        $this->put(route('practicas.update', $practica->id), [
            'titulo' => 'Se buscan pasantes',
            'area' => 1,
        ])->assertSessionHasErrors('requerimientos');

        $this->put(route('practicas.update', $practica->id), [
            'requerimientos' => 'Para hacer un CRUD',
            'area' => 1,
        ])->assertSessionHasErrors('titulo');

        $this->put(route('practicas.update', $practica->id), [
            'titulo' => 'Se buscan pasantes',
            'requerimientos' => 'Para hacer un CRUD',
        ])->assertSessionHasErrors('area');
    }

    public function test_destroy()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $practica = factory(Practica::class)->create([
            'empresa_id' => 44
        ]);

        $this->delete(route('practicas.destroy', $practica->id))
            ->assertRedirect(route('practicas.index'));

        $this->assertDatabaseMissing('practicas', [
            'id' => $practica->id
        ]);
    }

    public function test_destroy_policy()
    {
        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $practica = factory(Practica::class)->create([
            'empresa_id' => 14
        ]);

        $this->delete(route('practicas.destroy', $practica->id))
            ->assertStatus(403);
    }

    public function test_show_practicas_offers_to_estudiantes()
    {
        $this->withoutExceptionHandling();
        $practicas = factory(Practica::class, 2)->create([
            'facultad_id' => 2
        ]);

        $this->session([
            'role' => EstudianteController::get_role(),
            'idfacultad' => 2,
        ]);

        $this->get(route('practicas.show_practicas_offers'))
            ->assertStatus(200)
            ->assertSee($practicas[0]->titulo);
    }

    public function test_empresa_can_delete_practica_offer_even_when_it_has_estudiante_practica_records_related()
    {
        $this->withoutExceptionHandling();

        $this->session([]);

        $this->session([
            'id_personal' => 66710, // id_personal of a random estudiante
            'idfacultad' => 2,
            'idescuela' => 1, // id = ingenieria en sistemas
            'role' => EstudianteController::get_role()
        ]);

        $practica = factory(Practica::class)->create([
            'empresa_id' => 44,
            'facultad_id' => 1
        ]);

        $this->post(route('estudiantes_practicas.store', ['practica' => $practica->id]))
            ->assertRedirect(route('estudiantes_practicas.index'));

        $this->session([]);

        $this->session([
            'id_empresa' => 44,
            'nombre_empresa' => 'EL DIARIO EDIASA',
            'role' => EmpresaController::get_role()
        ]);

        $this->delete(route('practicas.destroy', $practica->id))
            ->assertRedirect(route('practicas.index'));

        $this->assertDatabaseMissing('practicas', [
                'id' => $practica->id
        ]);

        $this->assertDatabaseMissing('estudiantes_practicas', [
            'estudiante_id' => 66710,
            'practica_id' => $practica->id,
        ]);
    }

    // public function test_()
    // {

    // }
}
