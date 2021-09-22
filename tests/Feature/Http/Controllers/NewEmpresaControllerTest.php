<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewEmpresaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_a_new_empresa_assert_session_has_errors()
    {
        $response = $this->get('/registro');

        $response->assertStatus(200);

        $nueva_empresa = [
            // 'cedula' => '1311742041',
            'apellido_p' => 'zambrano',
            'apellido_m' => 'perero',
            'nombres' => 'regynald Leonardo',
            'titulo' => 'ingeniero',
            'genero' => 'M',
            // 'ruc' => '1311742041001',
            // 'nombre_empresa' => 'tamarindo software',
            'provincia' => '1',
            'canton' => '1',
            'parroquia' => '2',
            'direccion' => 'Pedro gual y morales',
            'descripcion' => 'empresa desarrolladora de software',
            'telefono' => '555555555',
            'email' => 'rrhh@tamarindo.xyz',
            'tipo' => '0',
        ];

        $this->post(route('new_empresas.store'), $nueva_empresa)
            ->assertSessionHasErrors([
                'cedula',
                'ruc',
                'nombre_empresa'
        ]);
    }

    public function test_register_a_new_empresa_success()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/registro');

        $response->assertStatus(200);

        $nueva_empresa = [
            'cedula' => '1311742041',
            'apellido_p' => 'zambrano',
            'apellido_m' => 'perero',
            'nombres' => 'regynald Leonardo',
            'titulo' => 'ingeniero',
            'genero' => 'M',
            'ruc' => '1311742041001',
            'nombre_empresa' => 'tamarindo software',
            'provincia' => '13',
            'canton' => '1',
            'parroquia' => '1',
            'direccion' => 'Pedro gual y morales',
            'email' => 'rrhh@tamarindo.xyz',
            'telefono' => '555555555',
            'descripcion' => 'empresa desarrolladora de software',
            'area' => '2',
            'tipo' => '0',
        ];

        $this->post(route('new_empresas.store'), $nueva_empresa)
            ->assertRedirect(route('landing'));

        $this->assertDatabaseHas('nuevo_personal_externo', [
            'cedula' => '1311742041',
        ], 'DB_ppp_sistema_SCHEMA_esq_portal_empleos');

        $this->assertDatabaseHas('nuevas_empresas', [
            'ruc' => '1311742041001',
            'nombre_empresa' => 'TAMARINDO SOFTWARE',
        ]);
    }

    // public function test_()
    // {

    // }
}
