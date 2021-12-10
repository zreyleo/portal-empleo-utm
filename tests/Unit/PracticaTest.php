<?php

namespace Tests\Unit;

use App\Practica;
use App\Empresa;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class PracticaTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_empresa_of_a_practica_is_instance_of_empresa_class()
    {
        $practica = factory(practica::class)->create([
            'empresa_id' => 44 // empresa = El DIARIO EDIASA
        ]);

        // dd($practica);
        $this->assertInstanceOf(Empresa::class, $practica->empresa);
    }
}
