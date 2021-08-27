<?php

namespace Tests\Unit;

use App\Empleo;
use App\Escuela;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EscuelaTest extends TestCase
{
    use RefreshDatabase;

    public function test_escuela_model_has_empleos_collection()
    {
        $escuela = Escuela::find(1); // id of ingenieria en sistemas

        factory(Empleo::class, 2)->create([
            'carrera_id' => 1
        ]);

        $this->assertInstanceOf(Collection::class, $escuela->empleos);

        $this->assertEquals(2, $escuela->empleos->count());
    }
}
