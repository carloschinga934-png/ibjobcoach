<?php

namespace App\Http\Controllers\Home;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PosicionController extends Controller
{
    public function consultarPosiciones(Request $request)
    {
        $cargo = $request->query('cargo');

        // Busca por nombre exacto
        $position = Position::where('nombre', $cargo)->first();

        if (!$position) {
            return response()->json([], 404);
        }

        // Parsear valor (ejemplo: "1-60.000")
        [$mes, $precio] = explode('-', $position->valor);

        return response()->json([
            [
                'nombre' => $position->nombre,
                'mes'    => $mes,
                'precio' => $precio
            ]
        ]);
    }
}
