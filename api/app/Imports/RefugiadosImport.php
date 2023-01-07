<?php

namespace App\Imports;

use App\Refugiado;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class RefugiadosImport implements ToModel, WithCustomCsvSettings
{
    public function model(array $column) {
        foreach ($column as $c)
            echo "$c ";
        echo "\n";

        return new Refugiado([
            "fundamentacao" => $column[0],
            "sexo" => $column[1],
            "idade" => $column[2],
            "pais" => $column[3],
            "tipo_processo" => $column[4],
            "ano_inicio" => $column[5],
            "ano_decisao" => $column[6],
            "estado_codigo" => $column[7]
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => ';'
        ];
    }
}
