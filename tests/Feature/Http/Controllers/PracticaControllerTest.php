<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\EmpresaController;

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
            'facultad_id' => 1,
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
            'facultad_id' => 1,
        ])->assertSessionHasErrors('requerimientos');

        $this->post(route('practicas.store'), [
            'requerimientos' => 'Para hacer un CRUD',
            'facultad_id' => 1,
        ])->assertSessionHasErrors('titulo');

        $this->post(route('practicas.store'), [
            'titulo' => 'Se buscan pasantes',
            'requerimientos' => 'Para hacer un CRUD',
        ])->assertSessionHasErrors('facultad_id');

        $this->session([
            'role' => 'ESTUDIANTE'
        ]);

        $this->post(route('practicas.store'), [
            'titulo' => 'Se buscan pasantes',
            'requerimientos' => 'Para hacer un CRUD',
            'facultad_id' => 1,
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

        $empleo = factory(Empleo::class)->create([
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

        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 44
        ]);

        $this->get(route('practicas.edit', $empleo->id))
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

        $this->get(route('practicas.show', $empleo->id))
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

        $this->put(route('practicas.update', $empleo->id), [
            'titulo' => 'Se necesita Ingeniero',
            'requerimientos' => $empleo->requerimientos,
            'facultad_id' => $empleo->facultad_id,
        ])->assertRedirect(route('practicas.edit', $empleo->id));

        $this->assertDatabaseHas('practicas',
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

        $this->put(route('practicas.update', $empleo->id), [
            'titulo' => 'Se necesita Ingeniero',
            'requerimientos' => $empleo->requerimientos,
            'facultad_id' => $empleo->facultad_id,
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

        $this->put(route('practicas.update', $empleo->id), [
            'titulo' => 'Se buscan pasantes',
            'facultad_id' => 1,
        ])->assertSessionHasErrors('requerimientos');

        $this->put(route('practicas.update', $empleo->id), [
            'requerimientos' => 'Para hacer un CRUD',
            'facultad_id' => 1,
        ])->assertSessionHasErrors('titulo');

        $this->put(route('practicas.update', $empleo->id), [
            'titulo' => 'Se buscan pasantes',
            'requerimientos' => 'Para hacer un CRUD',
        ])->assertSessionHasErrors('facultad_id');
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

        $this->delete(route('practicas.destroy', $empleo->id))
            ->assertRedirect(route('practicas.index'));

        $this->assertDatabaseMissing('practicas', [
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

        $this->delete(route('practicas.destroy', $empleo->id))
            ->assertStatus(403);
    }

    // public function test_()
    // {

    // }
}
