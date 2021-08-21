<?php

namespace Tests\Unit;

use App\Empleo;
use App\Empresa;

use Illuminate\Database\Eloquent\Collection;

use Tests\TestCase;

class EmpresaTest extends TestCase
{
    public function test_get_slug()
    {
        $empresa = Empresa::find(44); // Empresa = EL DIARIO EDIASA
        // dd($empresa);
        $this->assertEquals('el-diario-ediasa', $empresa->slug);
    }

    public function test_empleos_of_empresa_are_a_collection()
    {
        factory(Empleo::class)->create([
            'empresa_id' => 44
        ]);
        $empresa = Empresa::find(44); // Empresa = EL DIARIO EDIASA
        $this->assertInstanceOf(Collection::class, $empresa->empleos);
    }
}
