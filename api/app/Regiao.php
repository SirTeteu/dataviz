<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regiao extends Model
{
    const NORTE = 1;
    const NORDESTE = 2;
    const CENTRO_OESTE = 3;
    const SUDESTE = 4;
    const SUL = 5;

    public $timestamps = false;

    protected $fillable = [
        "nome"
    ];

    public function estados() {
        return $this->hasMany(Estado::class);
    }

    static function getEstados() {
        $regioes = Regiao::with(['estados'])->get();
        return $regioes->toArray();
    }
}
