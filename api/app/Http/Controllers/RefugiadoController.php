<?php

namespace App\Http\Controllers;

use App\Refugiado;
use Illuminate\Http\Request;

class RefugiadoController extends Controller
{
    public function index() {
        $refugiados = Refugiado::getDeferido();

        return response()->json(["data" => $refugiados], 200);
    }
}
