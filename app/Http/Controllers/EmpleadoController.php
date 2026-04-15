<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class EmpleadoController extends Controller
{
    // Dashboard empleado
    public function dashboard()
    {
        $empleado = Auth::usuario();
        return view('empleado.dashboard', compact('empleado'));
    }

    // Aquí puedes agregar métodos extra según funciones de los empleados
}
