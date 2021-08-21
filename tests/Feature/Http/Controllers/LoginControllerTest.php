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
}
