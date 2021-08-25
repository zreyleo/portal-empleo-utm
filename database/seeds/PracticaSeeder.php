<?php

use App\Practica;

use Illuminate\Database\Seeder;

class PracticaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Practica::class, 10)->create();
    }
}
