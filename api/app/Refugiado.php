<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Refugiado extends Model
{
    public $timestamps = false;

    protected $fillable = [
        "fundamentacao",
        "sexo",
        "idade",
        "pais",
        "tipo_processo",
        "ano_inicio",
        "ano_decisao"
    ];

    protected $belongsToRelations = [
        "estado"
    ];

    public function estado() {
        return $this->belongsTo(Estado::class, 'estado_codigo');
    }

    static public function getDeferido() {
        $refugiados = Refugiado::join('estados', 'refugiados.estado_codigo', '=', 'estados.codigo')
            ->where('ano_inicio', '>=', '2010')
            ->where('ano_inicio', '!=', 'NE')
            ->where(function ($q) {
                $q->where('tipo_processo', 'DEFERIDO')
                    ->orWhere('tipo_processo', 'EXTENSÃO DEFERIDA');
            })->select([DB::raw("COUNT(*) as count"), 'pais', 'sigla as estado', 'ano_inicio'])
            ->groupBy('pais')->groupBy('estado')->groupBy('ano_inicio')
            ->orderBy('ano_inicio', 'desc')->orderBy('count', 'desc')->get();

        $refugiadosArray = $refugiados->toArray();
        $refugiadosByYear = Refugiado::formatByYear($refugiadosArray);

        return $refugiadosByYear;
    }
    static function formatByYear($refugiados) {
        $refugiadoFormatted = [];

        foreach($refugiados as $refugiado) {
            if(Refugiado::contains($refugiado["ano_inicio"], $refugiadoFormatted)) {
                $anoIndex = Refugiado::index($refugiado["ano_inicio"], $refugiadoFormatted);

                if(Refugiado::contains($refugiado["pais"], $refugiadoFormatted[$anoIndex]["items"])){
                    $paisIndex = Refugiado::index($refugiado["pais"], $refugiadoFormatted[$anoIndex]["items"]);

                    array_push($refugiadoFormatted[$anoIndex]["items"][$paisIndex]["items"], [
                        "key" => $refugiado["estado"],
                        "count" => $refugiado["count"]
                    ]);

                } else {
                    array_push($refugiadoFormatted[$anoIndex]["items"], [
                        "key" => $refugiado["pais"],
                        "items" => [[
                            "key" => $refugiado["estado"],
                            "count" => $refugiado["count"]
                        ]]
                    ]);

                }

            } else {
                array_push($refugiadoFormatted, [
                    "key" => $refugiado["ano_inicio"],
                    "items" => [[
                        "key" => $refugiado["pais"],
                        "items" => [[
                            "key" => $refugiado["estado"],
                            "count" => $refugiado["count"]
                        ]]
                    ]]
                ]);

            }

        }

        return $refugiadoFormatted;
    }

    static function contains($key, $array) {
        foreach($array as $element) {
            if($element['key'] == $key) {
                return true;
            }
        }

        return false;
    }

    static function index($key, $array) {
        foreach($array as $index => $element) {
            if($element['key'] == $key) {
                return $index;
            }
        }

        return -1;
    }
}
