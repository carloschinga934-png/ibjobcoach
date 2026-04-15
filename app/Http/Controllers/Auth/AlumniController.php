<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumni;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    public function create()
    {
        return view('auth.admin.alumni.registraralumni');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'foto'     => 'required|file|mimes:jpg,jpeg,png|max:4096',
            'email'    => 'required|email|max:255',
            'empresa'  => 'required|string|max:255',
            'posicion' => 'required|string|max:255',
        ]);

        // Guardar archivo
        $file = $request->file('foto');
        $path = $file->store('alumni', 'public');
        $filename = $file->getClientOriginalName();
        $mime = $file->getClientMimeType();
        $size = $file->getSize();

        // Insertar en la base de datos
        Alumni::create([
            'nombre'   => $request->nombre,
            'name'     => $filename,
            'tipo'     => $mime,
            'tamanio'  => $size,
            'email'    => $request->email,
            'empresa'  => $request->empresa,
            'posicion' => $request->posicion,
        ]);

        return redirect()->route('alumni.create')->with('success', 'Alumni registrado correctamente.');
    }
}
