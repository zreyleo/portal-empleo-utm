<?php

namespace Tests\Feature\Http\Controllers;

use App\Empresa;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_empresa_post()
    {
        $this->post(route('login.empresas_post'), [
            'email' => 'mbravo@eldiario.ec'
        ])->assertStatus(302);
    }
}
