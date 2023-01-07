<?php

use App\Imports\RefugiadosImport;
use App\Refugiado;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class RefugiadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Refugiado::count()) {
            Excel::import(new RefugiadosImport(), "refugiados.csv", "carga");
        }
    }
}
