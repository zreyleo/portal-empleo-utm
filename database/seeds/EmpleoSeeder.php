<?php

use App\Empleo;
use Illuminate\Database\Seeder;

class EmpleoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Empleo::class, 10)->create();
        factory(Empleo::class)->create([
            'empresa_id' => 44,
            'carrera_id' => 2
        ]);
    }
}
