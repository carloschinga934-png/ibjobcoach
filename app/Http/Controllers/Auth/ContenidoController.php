<?php
namespace App\Http\Controllers\Auth;

use App\Models\CategoriaContenido;
use App\Http\Controllers\Controller;

class ContenidoController extends Controller
{
    public function create()
    {
        $categorias = CategoriaContenido::all();
        return view('auth.admin.contenidos.registrarcontenido', compact('categorias'));
    }
}