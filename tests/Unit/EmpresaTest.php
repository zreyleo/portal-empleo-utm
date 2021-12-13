<?php

namespace Tests\Unit;

use App\Empleo;
use App\Empresa;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class EmpresaTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_slug()
    {
        $empresa = Empresa::find(44); // Empresa = EL DIARIO EDIASA
        // dd($empresa);
        $this->assertEquals('el-diario-ediasa-s.a.', $empresa->slug);
    }

    public function test_empleos_of_empresa_are_a_collection()
    {
        factory(Empleo::class)->create([
            'empresa_id' => 44
        ]);
        $empresa = Empresa::find(44); // Empresa = EL DIARIO EDIASA
        $this->assertInstanceOf(Collection::class, $empresa->empleos);
    }

    public function test_practicas_of_empresa_are_a_collection()
    {
        factory(Empleo::class)->create([
            'empresa_id' => 44
        ]);
        $empresa = Empresa::find(44); // Empresa = EL DIARIO EDIASA
        $this->assertInstanceOf(Collection::class, $empresa->practicas);
    }
}
