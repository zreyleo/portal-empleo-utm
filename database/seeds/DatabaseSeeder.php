<?php

use App\Empleo;

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

        factory(Empleo::class, 5)->create([
            'carrera_id' => 1
        ]);
    }
}
