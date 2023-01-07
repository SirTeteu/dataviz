<?php

use Illuminate\Database\Seeder;

use App\Regiao;

class RegiaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Regiao::count()) {
            $cargaFile = Storage::disk("carga")->get("regioes.json");
            $json = json_decode($cargaFile);

            foreach ($json as $regiao) {
                $model = new Regiao([
                    "id" => $regiao->id,
                    "nome" => $regiao->nome
                ]);
                $model->save();
            }
        }
    }
}
