<?php

namespace App\Http\Controllers;

use App\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function index() {
        $estados = Estado::get();

        return response()->json(["data" => $estados], 200);
    }
}
