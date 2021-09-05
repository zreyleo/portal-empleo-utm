<?php

use App\Empleo;
use App\EstudianteEmpleo;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(PracticaSeeder::class);
        $this->call(EmpleoSeeder::class);

        $empleo = factory(Empleo::class)->create([
            'empresa_id' => 44
        ]);

        factory(EstudianteEmpleo::class, 5)->create([
            'empleo_id' => $empleo->id
        ]);
        factory(EstudianteEmpleo::class)->create([
            'empleo_id' => $empleo->id,
            'estudiante_id' => 66710
        ]);
    }
}
