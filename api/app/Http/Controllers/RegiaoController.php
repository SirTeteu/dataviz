<?php

namespace App\Http\Controllers;

use App\Regiao;

class RegiaoController extends Controller
{
    public function indexEstados() {
        $estados = Regiao::getEstados();

        return response()->json(["data" => $estados], 200);
    }
}
