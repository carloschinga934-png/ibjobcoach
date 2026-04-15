<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Foro;
use Illuminate\Http\Request;

class ForoController extends Controller
{
    public function create()
    {
        return view('auth.admin.foro.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'autor'       => 'required|string|max:100',
            'titulo'      => 'required|string|max:150',
            'descripcion' => 'required|string|max:500',
            'foto'        => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Guarda en storage/app/public/foros y devuelve "foros/xxxx.jpg"
        $storedPath = $request->file('foto')->store('foros', 'public');

        Foro::create([
            'autor'       => $data['autor'],
            'foto'        => $storedPath,                           // <- ruta RELATIVA
            'tipo'        => $request->file('foto')->getMimeType(),
            'tamanio'     => $request->file('foto')->getSize(),
            'titulo'      => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'fecha'       => now(),
            'estado'      => 'Enabled',
            'vistas'      => 0,
        ]);

        return redirect()
            ->route('admin.foro.create')
            ->with('success', 'Foro registrado correctamente.');
    }
}
