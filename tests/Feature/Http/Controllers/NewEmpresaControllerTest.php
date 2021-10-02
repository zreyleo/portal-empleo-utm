<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\ResponsableController;
use App\NewEmpresa;
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

    public function test_send_new_empresas_to_responsable()
    {
        $this->session([
            'id_personal' => 2684,
            'nombres' => 'CARLOS PINARGOTE',
            'id_facultad' => 2, // id de la facultad de ciencia informaticas
            'id_escuela' => 1, // id = ingenieria en sistemas
            'role' => ResponsableController::get_role(),
        ]);

        $this->get(route('new_empresas.index'))
            ->assertStatus(200);
    }

    public function test_show_new_empresa_info()
    {
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

        $this->post(route('new_empresas.store'), $nueva_empresa);

        $this->session([
            'id_personal' => 2684,
            'nombres' => 'CARLOS PINARGOTE',
            'id_facultad' => 2, // id de la facultad de ciencia informaticas
            'id_escuela' => 1, // id = ingenieria en sistemas
            'role' => ResponsableController::get_role(),
        ]);

        $empresa = NewEmpresa::first();

        $this->get(route('new_empresas.show', ['empresa' => $empresa->id_empresa]))
            ->assertStatus(200)
            ->assertSee($empresa->nombre_empresa);
    }

    public function test_edit_form_new_empresa()
    {
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
            'area' => 2,
            'tipo' => '0',
        ];

        $this->post(route('new_empresas.store'), $nueva_empresa);

        $this->session([
            'id_personal' => 2684,
            'nombres' => 'CARLOS PINARGOTE',
            'id_facultad' => 2, // id de la facultad de ciencia informaticas
            'id_escuela' => 1, // id = ingenieria en sistemas
            'role' => ResponsableController::get_role(),
        ]);

        $empresa = NewEmpresa::first();

        // dd($empresa);

        $this->get(route('new_empresas.edit', ['empresa' => $empresa->id_empresa]))
            ->assertStatus(200)
            ->assertSee($empresa->ruc);
    }

    public function test_update_new_empresa_information()
    {
        $this->withoutExceptionHandling();
        $nueva_empresa = [
            'cedula' => '1311742041',
            'apellido_p' => 'zambrano',
            'apellido_m' => 'perero',
            'nombres' => 'regynald Leonardo',
            'titulo' => 'ingeniero',
            'genero' => 'M',
            'ruc' => '1311742041001',
            'nombre_empresa' => 'tamarindo SOLUTIONS',
            'provincia' => '13',
            'canton' => '1',
            'parroquia' => '1',
            'direccion' => 'Pedro gual y morales',
            'email' => 'rrhh@tamarindo.xyz',
            'telefono' => '555555555',
            'descripcion' => 'empresa desarrolladora de software',
            'area' => 2,
            'tipo' => '0',
        ];

        $this->post(route('new_empresas.store'), $nueva_empresa);

        $this->session([
            'id_personal' => 2684,
            'nombres' => 'CARLOS PINARGOTE',
            'id_facultad' => 2, // id de la facultad de ciencia informaticas
            'id_escuela' => 1, // id = ingenieria en sistemas
            'role' => ResponsableController::get_role(),
        ]);

        $empresa = NewEmpresa::first();

        // dd($empresa);

        $this->get(route('new_empresas.edit', ['empresa' => $empresa->id_empresa]))
            ->assertStatus(200)
            ->assertSee($empresa->ruc);

        $nueva_informacion_empresa = [
            'cedula' => '1301551352',
            'apellido_p' => 'zambrano',
            'apellido_m' => 'zambrano',
            'nombres' => 'leonardo alfredo',
            'titulo' => 'ingeniero',
            'genero' => 'M',
            'ruc' => '1301551352001',
            'nombre_empresa' => 'tamarindo software',
            'provincia' => '13',
            'canton' => '1',
            'parroquia' => '1',
            'direccion' => 'Pedro gual y morales',
            'email' => 'rrhh@tamarindo.xyz',
            'telefono' => '555555555',
            'descripcion' => 'empresa desarrolladora de software',
            'area' => 2,
            'tipo' => '0',
        ];

        $this->put(route('new_empresas.update', ['empresa' => $empresa->id_empresa]), $nueva_informacion_empresa)
            ->assertRedirect(route('new_empresas.edit', ['empresa' => $empresa->id_empresa]));

        $this->assertDatabaseHas('nuevo_personal_externo', [
            'cedula' => '1301551352',
            'nombres' => 'LEONARDO ALFREDO'
        ]);

        $this->assertDatabaseHas('nuevas_empresas', [
            'ruc' => '1301551352001',
            'nombre_empresa' => 'TAMARINDO SOFTWARE'
        ]);
    }

    // public function test_responsable_can_delete_new_empresa()
    // {
    //     $this->session([
    //         'id_personal' => 2684,
    //         'nombres' => 'CARLOS PINARGOTE',
    //         'id_facultad' => 2, // id de la facultad de ciencia informaticas
    //         'id_escuela' => 1, // id = ingenieria en sistemas
    //         'role' => ResponsableController::get_role(),
    //     ]);

    //     $this->delete(route('new_empresas.destroy'));
    // }

    // public function test_()
    // {

    // }
}
