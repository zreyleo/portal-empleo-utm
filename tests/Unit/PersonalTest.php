<?php

namespace Tests\Unit;

use App\Personal;

use Tests\TestCase;

class PersonalTest extends TestCase
{
    public function test_get_full_name_of_personal_model()
    {
        $personal = Personal::find(66710); // ID of system's author

        $this->assertEquals('ZAMBRANO PERERO REGYNALD LEONARDO', $personal->nombres_completos);
    }
}
