<?php

namespace App\Http\Controllers;

use App\Models\NotaUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotasController extends Controller
{
    // Ver todas las notas de un usuario
    public function index($usuarioId)
    {
        $usuario = Usuario::findOrFail($usuarioId);
        $usuarioActual = Auth::user();
        
        // Obtener notas que el usuario actual puede ver
        $notas = NotaUsuario::where('usuario_id', $usuario->idusuario)
                    ->where(function($query) use ($usuarioActual) {
                        $query->where('es_privada', false)
                              ->orWhere('autor_id', $usuarioActual->idusuario);
                    })
                    ->with('autor')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        // Estadísticas de notas
        $estadisticas = [
            'total' => NotaUsuario::where('usuario_id', $usuario->idusuario)->count(),
            'info' => NotaUsuario::where('usuario_id', $usuario->idusuario)->where('tipo', 'info')->count(),
            'importante' => NotaUsuario::where('usuario_id', $usuario->idusuario)->where('tipo', 'importante')->count(),
            'seguimiento' => NotaUsuario::where('usuario_id', $usuario->idusuario)->where('tipo', 'seguimiento')->count(),
            'problema' => NotaUsuario::where('usuario_id', $usuario->idusuario)->where('tipo', 'problema')->count(),
            'resuelto' => NotaUsuario::where('usuario_id', $usuario->idusuario)->where('tipo', 'resuelto')->count(),
        ];

        return view('notas.index', compact('usuario', 'notas', 'estadisticas'));
    }

    // Mostrar formulario para crear nota
    public function create($usuarioId)
    {
        $usuario = Usuario::findOrFail($usuarioId);
        return view('notas.create', compact('usuario'));
    }

    // Guardar nueva nota
    public function store(Request $request, $usuarioId)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'contenido' => 'required|string|max:5000',
            'tipo' => 'required|in:info,importante,seguimiento,problema,resuelto',
            'es_privada' => 'boolean'
        ]);

        $usuario = Usuario::findOrFail($usuarioId);

        NotaUsuario::create([
            'usuario_id' => $usuario->idusuario,
            'autor_id' => Auth::user()->idusuario,
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'tipo' => $request->tipo,
            'es_privada' => $request->boolean('es_privada', false)
        ]);

        return redirect()
            ->route('notas.index', $usuarioId)
            ->with('success', 'Nota añadida correctamente');
    }

    // Ver detalle de una nota
    public function show($usuarioId, $notaId)
    {
        $usuario = Usuario::findOrFail($usuarioId);
        $nota = NotaUsuario::where('usuario_id', $usuario->idusuario)
                          ->where('id', $notaId)
                          ->with('autor')
                          ->firstOrFail();

        // Verificar si el usuario puede ver esta nota
        if (!$nota->puedeVer(Auth::user()->idusuario)) {
            abort(403, 'No tienes permisos para ver esta nota.');
        }

        return view('notas.show', compact('usuario', 'nota'));
    }

    // Mostrar formulario para editar nota
    public function edit($usuarioId, $notaId)
    {
        $usuario = Usuario::findOrFail($usuarioId);
        $nota = NotaUsuario::where('usuario_id', $usuario->idusuario)
                          ->where('id', $notaId)
                          ->firstOrFail();

        // Solo el autor puede editar la nota
        if ($nota->autor_id !== Auth::user()->idusuario) {
            abort(403, 'No tienes permisos para editar esta nota.');
        }

        return view('notas.edit', compact('usuario', 'nota'));
    }

    // Actualizar nota
    public function update(Request $request, $usuarioId, $notaId)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'contenido' => 'required|string|max:5000',
            'tipo' => 'required|in:info,importante,seguimiento,problema,resuelto',
            'es_privada' => 'boolean'
        ]);

        $usuario = Usuario::findOrFail($usuarioId);
        $nota = NotaUsuario::where('usuario_id', $usuario->idusuario)
                          ->where('id', $notaId)
                          ->firstOrFail();

        // Solo el autor puede editar la nota
        if ($nota->autor_id !== Auth::user()->idusuario) {
            abort(403, 'No tienes permisos para editar esta nota.');
        }

        $nota->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'tipo' => $request->tipo,
            'es_privada' => $request->boolean('es_privada', false)
        ]);

        return redirect()
            ->route('notas.index', $usuarioId)
            ->with('success', 'Nota actualizada correctamente');
    }

    // Eliminar nota
    public function destroy($usuarioId, $notaId)
    {
        $usuario = Usuario::findOrFail($usuarioId);
        $nota = NotaUsuario::where('usuario_id', $usuario->idusuario)
                          ->where('id', $notaId)
                          ->firstOrFail();

        // Solo el autor puede eliminar la nota
        if ($nota->autor_id !== Auth::user()->idusuario) {
            abort(403, 'No tienes permisos para eliminar esta nota.');
        }

        $nota->delete();

        return redirect()
            ->route('notas.index', $usuarioId)
            ->with('success', 'Nota eliminada correctamente');
    }
}