<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewEmpresaControllerTest extends TestCase
{
    public function test_register_a_new_empresa()
    {
        $response = $this->get('/registro');

        $response->assertStatus(200);

        $nueva_empresa = [

        ];
    }

    // public function test_()
    // {

    // }
}
