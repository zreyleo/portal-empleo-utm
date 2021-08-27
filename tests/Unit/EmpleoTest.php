<?php

namespace Tests\Unit;

use App\Empleo;
use App\Empresa;
use App\Escuela;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class EmpleoTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_empresa_of_a_empleo_is_instance_of_empresa_class()
    {
        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 44 // empresa = El DIARIO EDIASA
        ]);

        // dd($empleo);
        $this->assertInstanceOf(Empresa::class, $empleo->empresa);
    }

    public function test_the_escuela_of_a_empleo_is_instance_of_escuela_model()
    {
        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 44, // empresa = El DIARIO EDIASA
            'carrera_id' => 1 // carrera = ingenieria en sistemas
        ]);

        // dd($empleo);
        $this->assertInstanceOf(Escuela::class, $empleo->escuela);
    }
}
