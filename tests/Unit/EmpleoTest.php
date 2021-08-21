<?php

namespace Tests\Unit;

use App\Empleo;
use App\Empresa;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class EmpleoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_the_empresa_of_a_empleo_is_instance_of_empresa_class()
    {
        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 44 // empresa = El DIARIO EDIASA
        ]);

        // dd($empleo);
        $this->assertInstanceOf(Empresa::class, $empleo->empresa);
    }
}
