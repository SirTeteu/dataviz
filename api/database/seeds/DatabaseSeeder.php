<?php

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
        $this->call(RegiaoSeeder::class);

        $this->call(EstadosSeeder::class);

        $this->call(RefugiadosSeeder::class);
    }
}
