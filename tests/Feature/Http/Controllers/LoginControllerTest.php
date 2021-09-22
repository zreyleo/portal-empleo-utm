<?php

namespace Tests\Feature\Http\Controllers;

use App\Empresa;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function test_login_empresa_post()
    {
        $this->post(route('login.empresas_post'), [
            'email' => 'mbravo@eldiario.ec'
        ])->assertStatus(302);
    }

    public function test_login_empresa_username_not_found()
    {
        $this->post(route('login.empresas_post'), [
            'email' => 'no_existe_este_correo@no_existe_este_dominio.ec'
        ])->assertStatus(302)
        ->assertSessionHasErrors();
    }

    public function test_login_estudiante_process()
    {
        $this->post(route('login.estudiantes_post'), [
            'email' => 'rzambrano2041@utm.edu.ec'
        ])->assertStatus(302)
        ->assertRedirect(route('login.choose_carrera_get'));

        $this->post(route('login.choose_carrera_post'), [
            'carrera' => 1 // id of ingenieria en sistemas
        ])->assertRedirect(route('estudiantes.dashboard'));
    }

    public function test_login_estudiante_username_not_found()
    {
        $this->post(route('login.estudiantes_post'), [
            'email' => 'no_existe_este_correo@no_existe_este_dominio.ec'
        ])->assertStatus(302)
        ->assertSessionHasErrors();
    }

    public function test_login_responsable_pasantia_with_username_that_is_not_docente_responsable()
    {
        $this->post(route('login.responsables_post'), [
            'email' => 'rzambrano2041@utm.edu.ec',
            // 'password' => '12345678'
        ])->assertSessionHasErrors();



        // dd($personal_rol);
    }

    public function test_login_responsable_pasantia_success()
    {
        $this->post(route('login.responsables_post'), [
            'email' => 'carlos.pinargote@utm.edu.ec',
            // 'password' => '12345678'
        ])->assertRedirect();
    }
}
