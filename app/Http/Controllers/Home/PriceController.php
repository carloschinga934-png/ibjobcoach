<?php

namespace App\Http\Controllers\Home;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PriceController extends Controller
{
    public function index()
    {
        // Trae los cargos y separa el valor en meses y precio
        $positions = Position::orderBy('id')->get()->map(function($pos){
            $parts = explode('-', $pos->valor); // separa en [meses, precio]
            $pos->meses  = isset($parts[0]) ? trim($parts[0]) : '';
            $pos->precio = isset($parts[1]) ? trim($parts[1]) : '';
            return $pos;
        });


        return view('Home.Precios.precios', compact('positions'));
    }

    public function cargoInfo(Request $request)
    {
        $cargo = $request->query('cargo');
        $position = Position::where('nombre', $cargo)->first();

        // Si necesitas también aquí devolver meses/precio separados:
        if ($position) {
            $parts = explode('-', $position->valor);
            $position->meses  = isset($parts[0]) ? trim($parts[0]) : '';
            $position->precio = isset($parts[1]) ? trim($parts[1]) : '';
        }

        return response()->json([$position]);
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'empresa' => 'required|string|max:120',
            'email' => 'required|email',
            'pais' => 'required|string|max:60',
            'telefono' => 'required|string|max:20',
            'name' => 'required|string|max:120',
            'cargo' => 'required|string|max:120',
        ]);

        return back()->with('success', '¡Gracias! Te contactaremos pronto.');
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|min:2|max:60',
            'apellido'  => 'required|string|min:2|max:60',
            'correo'    => 'required|email|max:100',
            'clave'     => 'required|string|min:4|max:100',
            'telefono'  => 'required|digits_between:7,15',
            'cupon'     => 'nullable|string|max:40',
            'pago'      => 'required|in:paypal,transfer',
        ]);

        if ($validated['pago'] === 'paypal') {
            session(['paypalData' => $validated]);
            return redirect()->route('paypal.direct.form');
        }

        return redirect()->route('precios.index')->with('success', 'Compra realizada. ¡Gracias por tu preferencia!');
    }
}
