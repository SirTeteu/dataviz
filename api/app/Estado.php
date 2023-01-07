<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public $timestamps = false;

    protected $fillable = [
        "nome",
        "codigo"
    ];

    protected $belongsToRelations = [
        "regiao"
    ];

    public function regiao() {
        return $this->belongsTo(Regiao::class);
    }

    public function refugiados() {
        return $this->hasMany(Refugiado::class);
    }

    static function get() {
        $norte = Estado::join('regiaos', 'estados.regiao_id', '=', 'regiaos.id')
            ->where('regiaos.id', Regiao::NORTE)
            ->select(['estados.sigla as value', 'estados.nome as detail', 'regiaos.nome as param'])
            ->orderBy('value')->get()->toArray();

        $nordeste = Estado::join('regiaos', 'estados.regiao_id', '=', 'regiaos.id')
            ->where('regiaos.id', Regiao::NORDESTE)
            ->select(['estados.sigla as value', 'estados.nome as detail', 'regiaos.nome as param'])
            ->orderBy('value')->get()->toArray();

        $centro_oeste = Estado::join('regiaos', 'estados.regiao_id', '=', 'regiaos.id')
            ->where('regiaos.id', Regiao::CENTRO_OESTE)
            ->select(['estados.sigla as value', 'estados.nome as detail', 'regiaos.nome as param'])
            ->orderBy('value')->get()->toArray();

        $sudeste = Estado::join('regiaos', 'estados.regiao_id', '=', 'regiaos.id')
            ->where('regiaos.id', Regiao::SUDESTE)
            ->select(['estados.sigla as value', 'estados.nome as detail', 'regiaos.nome as param'])
            ->orderBy('value')->get()->toArray();

        $sul = Estado::join('regiaos', 'estados.regiao_id', '=', 'regiaos.id')
            ->where('regiaos.id', Regiao::SUL)
            ->select(['estados.sigla as value', 'estados.nome as detail', 'regiaos.nome as param'])
            ->orderBy('value')->get()->toArray();

        $estadosArray = array_merge($norte, $nordeste, $centro_oeste, $sudeste, $sul);

        return $estadosArray;
    }
}
