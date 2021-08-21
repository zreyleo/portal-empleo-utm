<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\EmpresaController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\Session;

use Tests\TestCase;

class EmpleoControllerTest extends TestCase
{
    // use RefreshDatabase;

    public function test_index_empty()
    {
        // $empleo = factory(Empleo::class)->create();
        $this->session([
            'id_empresa' => 44,
            'role' => EmpresaController::get_role()
        ]);

        $response = $this->get(route('empleos.index'));

        $response->assertStatus(200);
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
            'carrera_id' => 1,
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
            'carrera_id' => 1,
        ])->assertSessionHasErrors('requerimientos');

        $this->post(route('empleos.store'), [
            'requerimientos' => 'Para hacer un CRUD',
            'carrera_id' => 1,
        ])->assertSessionHasErrors('titulo');

        $this->post(route('empleos.store'), [
            'titulo' => 'Se necesita Ingeniero en Sistemas',
            'requerimientos' => 'Para hacer un CRUD',
        ])->assertSessionHasErrors('carrera_id');

        $this->session([
            'role' => 'ESTUDIANTE'
        ]);

        $this->post(route('empleos.store'), [
            'titulo' => 'Se necesita Ingeniero en Sistemas',
            'requerimientos' => 'Para hacer un CRUD',
            'carrera_id' => 1,
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

    // public function test_()
    // {

    // }
}
