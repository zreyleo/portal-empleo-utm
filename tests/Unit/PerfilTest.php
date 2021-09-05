<?php

namespace Tests\Unit;

use App\Perfil;
use App\Personal;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class PerfilTest extends TestCase
{
    use RefreshDatabase;

    public function test_personal_of_perfil_is_an_instance_of_personal_model()
    {
        $perfil = factory(Perfil::class)->create([
            'personal_id' => 66710
        ]);

        $this->assertInstanceOf(Personal::class, $perfil->personal);
    }

    // public function test_()
    // {

    // }
}
