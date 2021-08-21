<?php

namespace Tests\Unit;

use App\Empresa;

use Tests\TestCase;

class EmpresaTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_slug()
    {
        $empresa = Empresa::find(44); // Empresa = EL DIARIO EDIASA
        // dd($empresa);
        $this->assertEquals('el-diario-ediasa', $empresa->slug);
    }
}
