<?php

namespace Tests\Unit;

use App\NewPersonalExterno;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class NewPersonalExternoTest extends TestCase
{
    use RefreshDatabase;

    public function test_assert_create_nuevo_personal_externo()
    {
        NewPersonalExterno::create([
            'cedula' => '1311742041',
            'apellido_p' => 'zambrano',
            'apellido_m' => 'perero',
            'nombres' => 'regynald Leonardo',
            'titulo' => 'ingeniero',
            'genero' => 'M'
        ]);

        $this->assertDatabaseHas('nuevo_personal_externo', [
            'cedula' => '1311742041',
        ]);
    }

    // public function test_()
    // {

    // }
}
