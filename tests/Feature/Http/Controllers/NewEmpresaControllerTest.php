<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewEmpresaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_a_new_empresa()
    {
        $response = $this->get('/registro');

        $response->assertStatus(200);

        $nueva_empresa = [
            'credula' => '1311742041',
            'apellido_p' => 'zambrano',
            'apellido_m' => 'perero',
            'nombres' => 'regynald Leonardo',
            'titulo' => 'ingeniero',
            'genero' => 'M',
            'ruc' => '1311742041001',
            'nombre_empresa' => 'tamarindo software',
            'id_provincia' => '1',
            'id_canton' => '1',
            'id_parroquia' => '2',
            'direccion' => 'Pedro gual y morales',
            'descripcion' => 'empresa desarrolladora de software',
            'telefono' => '555555555',
            'email' => 'rrhh@tamarindo.xyz',
            'tipo' => '0',
        ];

        $this->post(route('new_empresas.store'), $nueva_empresa)
            ->assertRedirect();

        $this->assertDatabaseHas('nuevas_empresas', [
            'ruc' => '1311742041001',
            'nombre_empresa' => 'tamarindo software',
        ]);
    }

    // public function test_()
    // {

    // }
}
