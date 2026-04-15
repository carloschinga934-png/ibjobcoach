<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Foro;
use App\Models\ForoRespuesta;

class UsuarioController extends Controller
{

    public function actualizarDatos(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo,' . Auth::user()->idusuario . ',idusuario',
        ]);

        $usuario = Auth::user();
        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->save();
        Auth::login($usuario); // mantiene la sesión activa con el nuevo correo

        return back()->with('success', 'Datos actualizados correctamente.');
    }


    public function actualizarPassword(Request $request)
    {
        $request->validate(
            [
                'password_actual' => 'required',
                'nueva_password' => ['required', 'min:8', 'confirmed'],  // reglas
                'nueva_password_confirmation' => ['required'],
            ],
            [
                'nueva_password.required' => 'La nueva contraseña es obligatoria.', // mensajes
                'nueva_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
                'nueva_password.confirmed' => 'La nueva contraseña y su confirmación no coinciden.',
                'nueva_password_confirmation.required' => 'Debes repetir la nueva contraseña.',
            ]
        );


        //Verificar si la contraseña es incorrecta
        if (!Hash::check($request->password_actual, Auth::user()->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
        }

        $usuario = Auth::user();
        $usuario->password = Hash::make($request->nueva_password);
        $usuario->save();
        Auth::login($usuario);
        return back()->with('success', 'Contraseña cambiada correctamente.');
    }


    // Dashboard usuario
    public function dashboard()
    {
        $usuario = Auth::user();
        $enPrueba = $usuario->status === 'prueba' && $usuario->fin_prueba && now()->lt($usuario->fin_prueba);
        $activo = $usuario->status === 'activo';

        return view('auth.usuario.dashboard', compact('usuario', 'enPrueba', 'activo'));
    }
    public function perfil()
    {
        $usuario = Auth::user();

        // Opcional: definir si está en prueba o activo
        $enPrueba = $usuario->status === 'prueba' && $usuario->fin_prueba && now()->lt($usuario->fin_prueba);
        $activo = $usuario->status === 'activo';

        return view('auth.usuario.perfil', compact('usuario', 'enPrueba', 'activo'));
    }
    public function configuracion()
    {
        $usuario = Auth::user();

        // Opcional: definir si está en prueba o activo
        $enPrueba = $usuario->status === 'prueba' && $usuario->fin_prueba && now()->lt($usuario->fin_prueba);
        $activo = $usuario->status === 'activo';

        return view('auth.usuario.configuracion', compact('usuario', 'enPrueba', 'activo'));
    }
    public function configPerfil()
    {
        $usuario = Auth::user();

        // Opcional: definir si está en prueba o activo
        $enPrueba = $usuario->status === 'prueba' && $usuario->fin_prueba && now()->lt($usuario->fin_prueba);
        $activo = $usuario->status === 'activo';

        return view('auth.usuario.', compact('usuario', 'enPrueba', 'activo'));
    }


    // Ver todos los usuarios con búsqueda
    public function index(Request $request)
    {
        $query = Usuario::query();

        // Filtro por nombre (busca en nombre y apellido)
        if ($request->filled('nombre')) {
            $nombre = $request->nombre;
            $query->where(function($q) use ($nombre) {
                $q->where('nombre', 'LIKE', "%{$nombre}%")
                  ->orWhere('apellido', 'LIKE', "%{$nombre}%")
                  ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ["%{$nombre}%"]);
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('status', $request->estado);
        }

        // Filtro por progreso (basado en fin_prueba y status)
        if ($request->filled('progreso')) {
            switch ($request->progreso) {
                case 'activo':
                    $query->where('status', 'activo');
                    break;
                case 'prueba_vigente':
                    $query->where('status', 'prueba')
                          ->where('fin_prueba', '>', now());
                    break;
                case 'prueba_vencida':
                    $query->where('status', 'prueba')
                          ->where('fin_prueba', '<=', now());
                    break;
                case 'inactivo':
                    $query->where('status', 'inactivo');
                    break;
            }
        }

        // Filtro por correo
        if ($request->filled('correo')) {
            $query->where('correo', 'LIKE', "%{$request->correo}%");
        }

        // Ordenar por nombre por defecto
        $usuarios = $query->orderBy('nombre', 'asc')->paginate(15);

        // Mantener los filtros en la paginación
        $usuarios->appends($request->all());

        // Contar estadísticas
        $estadisticas = [
            'total' => Usuario::count(),
            'activos' => Usuario::where('status', 'activo')->count(),
            'prueba' => Usuario::where('status', 'prueba')->count(),
            'inactivos' => Usuario::where('status', 'inactivo')->count(),
        ];

        return view('usuarios.index', compact('usuarios', 'estadisticas'));
    }

    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }
}