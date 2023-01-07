<?php

use Illuminate\Database\Seeder;
use App\Estado;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Estado::count()) {
            $cargaFile = Storage::disk("carga")->get("estados.json");
            $json = json_decode($cargaFile);

            foreach ($json as $estado) {
                $model = new Estado([
                    "nome" => $estado->nome,
                    "sigla" => $estado->sigla,
                    "codigo" => $estado->codigo,
                    "regiao_id" => $estado->regiao_id
                ]);
                $model->save();
            }
        }
    }
}
