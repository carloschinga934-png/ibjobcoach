<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellido'  => 'required|string|max:255',
            'correo'    => 'required|string|email|max:255|unique:usuarios,correo',
            'telefono'  => 'nullable|string|max:32',
            'pais'      => 'required|string|max:255',
            'cargo'     => 'nullable|string|max:255',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        $usuario = Usuario::create([
            'nombre'    => $request->nombre,
            'apellido'  => $request->apellido,
            'correo'    => $request->correo,
            'telefono'  => $request->telefono,
            'pais'      => $request->pais,
            'cargo'     => $request->cargo,
            'password'  => Hash::make($request->password),
            'status'    => 'Enabled', // Si quieres ponerlo por defecto
        ]);

        Auth::login($usuario);

        return redirect()->route('dashboard');
    }
}
