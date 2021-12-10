<?php

namespace Tests\Unit;

use App\Empresa;
use App\Pasantia;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class PasantiaTest extends TestCase
{
    public function test_the_empresa_of_a_pasantia_is_instance_of_empresa_class()
    {
        $pasantia = Pasantia::where('id_pasante', 66710)->get()->first();

        $this->assertInstanceOf(Empresa::class, $pasantia->empresa);
    }
}
