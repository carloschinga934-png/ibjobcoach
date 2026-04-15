<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Articulo;
use App\Models\Ebook;
use Illuminate\Support\Str;
use App\Models\Contenido;
use App\Models\CategoriaContenido;
use Illuminate\Support\Facades\Storage;
use App\Models\Foro;
use App\Models\ForoRespuesta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NuevaRespuestaForo;
class AdminController extends Controller
{
    public function dashboard()
    {
        $usuarios = Usuario::with('role')->paginate(10);
        $roles = Role::all();
        $articulos = Articulo::with('categoria')->paginate(10);

        $cardsAdmin = [
            [
                'title' => 'Gestionar Usuarios',
                'icon' => 'people',
                'color' => 'ib-red',
                'url' => route('admin.usuarios'),
            ],
            [
                'title' => 'Gestionar Roles',
                'icon' => 'security',
                'color' => 'ib-dark',
                'url' => route('admin.roles'),
            ],
            [
                'title' => 'Gestionar Artículos',
                'icon' => 'article',
                'color' => 'ib-red',
                'url' => route('admin.articulos'),
            ],
            [
                'title' => 'Reportes',
                'icon' => 'assessment',
                'color' => 'ib-dark',
                'url' => route('admin.reportes'),
            ],
        ];

        return view('auth.admin.dashboard', compact('cardsAdmin', 'usuarios', 'roles', 'articulos'));
    }

    // Listar todos los usuarios
    public function usuarios(Request $request)
    {
        $query = Usuario::with('role');

        // Búsqueda por nombre
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->buscar . '%')
                ->orWhere('apellido', 'like', '%' . $request->buscar . '%');
            });
        }

        // Filtro por rol
        if ($request->filled('rol')) {
            $query->whereHas('role', function($q) use ($request) {
                $q->where('nombre', $request->rol);
            });
        }

        $usuarios = $query->paginate(10);
        $roles = Role::all();

        return view('auth.admin.usuarios.usuarios', compact('usuarios', 'roles'));
    }
    public function eliminarUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado correctamente.');
    }



    // Formulario para editar usuario
    public function editUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles = Role::all();
        return view('auth.admin.usuarios.edit_usuario', compact('usuario', 'roles'));
    }

    // Actualizar usuario y rol
    public function updateUsuario(Request $request, $id)
    {
        $actor = Auth::user();               // <- el usuario autenticado
        $usuario = Usuario::findOrFail($id); // <- el usuario que vas a editar

        // Solo ADMIN puede cambiar roles (revisa al actor, NO al usuario editado)
        if (!$actor || optional($actor->role)->nombre !== 'admin') {
            return back()->with('error', 'No tienes permiso para cambiar el rol.');
        }

        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo'   => 'required|email|max:255|unique:usuarios,correo,'.$usuario->idusuario.',idusuario',
            'pais'     => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'cargo'    => 'nullable|string|max:100',
            'role_id'  => 'required|exists:roles,id',
            'status'   => 'required|in:prueba,activo,inactivo,suspendido',
            'fin_prueba'=> 'nullable|date',
        ]);

        $usuario->nombre   = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->correo   = $request->correo;
        $usuario->pais     = $request->pais;
        $usuario->telefono = $request->telefono;
        $usuario->cargo    = $request->cargo;
        $usuario->role_id  = $request->role_id; // <- aquí sí podrás asignar
        $usuario->status   = $request->status;

        if ($usuario->status === 'prueba') {
            $usuario->fin_prueba = $request->fin_prueba ?? now()->addDays(2);
        } else {
            $usuario->fin_prueba = null;
        }

        $usuario->save();

        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    public function tablaArticulos()
    {
        // Obtiene todos los artículos y los pagina de 9 en 9
        $articulos = Articulo::orderBy('idarticulo')->paginate(9);
        return view('auth.admin.tables.tecnicas', compact('articulos'));
    }

    // Listar empleados
    public function empleados()
    {
        // Solo roles de empleado (ajusta 'empleado' por el nombre de tu rol)
        $empleados = Usuario::with('role')->whereHas('role', function($q){
            $q->where('nombre', 'empleado');
        })->paginate(10);

        return view('auth.admin.empleados.empleados', compact('empleados'));
    }

    // Formulario de creación (puedes ponerlo como modal o blade aparte)
    public function crearEmpleado()
    {
        $roles = Role::where('nombre', 'empleado')->get();
        return view('auth.admin.empleados.crear', compact('roles'));
    }

    // Guardar empleado
    public function guardarEmpleado(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $empleado = new Usuario();
        $empleado->nombre = $request->nombre;
        $empleado->apellido = $request->apellido;
        $empleado->correo = $request->correo;
        $empleado->password = bcrypt($request->password);
        $empleado->role_id = $request->role_id;
        $empleado->status = 'activo';
        $empleado->save();

        return redirect()->route('admin.empleados')->with('success', 'Empleado registrado correctamente.');
    }

    // Editar
    public function editarEmpleado($id)
    {
        $empleado = Usuario::findOrFail($id);
        $roles = Role::where('nombre', 'empleado')->get();
        return view('auth.admin.empleados.editar', compact('empleado', 'roles'));
    }

    // Actualizar
    public function actualizarEmpleado(Request $request, $id)
    {
        $empleado = Usuario::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:usuarios,correo,'.$empleado->idusuario.',idusuario',
            'role_id' => 'required|exists:roles,id',
        ]);

        $empleado->nombre = $request->nombre;
        $empleado->apellido = $request->apellido;
        $empleado->correo = $request->correo;
        $empleado->role_id = $request->role_id;
        $empleado->save();

        return redirect()->route('admin.empleados')->with('success', 'Empleado actualizado correctamente.');
    }

    // Eliminar
    public function eliminarEmpleado($id)
    {
        $empleado = Usuario::findOrFail($id);
        $empleado->delete();
        return redirect()->route('admin.empleados')->with('success', 'Empleado eliminado correctamente.');
    }

    //contenidos
    public function contenidos()
    {
        $contenidos = Contenido::orderBy('fechapublicacion', 'desc')->paginate(10);
        return view('auth.admin.contenidos.contenidos', compact('contenidos'));
    }


    // Mostrar formulario para crear contenido
    public function crearContenido()
    {
        // Si tienes categorías, pásalas aquí, si no, solo muestra el formulario.
        $categorias = CategoriaContenido::all(); // Opcional
        return view('auth.admin.contenidos.create', compact('categorias'));
    }

    // Guardar contenido
    public function guardarContenido(Request $request)
    {
        $request->validate([
            'nombre'            => 'required|string|max:255',
            'descripcion'       => 'nullable|string',
            'idcategoria'       => 'required|exists:categoriacontenido,idcategoria',
            'fechapublicacion'  => 'required|date',
            'archivo'           => 'required|file|mimes:pdf|max:5120',
        ]);

        $contenido = new Contenido();
        $contenido->nombre           = $request->nombre;
        $contenido->descripcion      = $request->descripcion;
        $contenido->idcategoria      = $request->idcategoria;
        $contenido->fechapublicacion = $request->fechapublicacion;

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('contenidos', 'public');
            $contenido->url = $path; // guarda la ruta en 'url'
        }

        $contenido->save();

        return redirect()->route('admin.contenidos')->with('success', 'Contenido registrado correctamente.');
    }



    // Mostrar formulario para editar
    public function editarContenido($id)
    {
        $contenido = Contenido::findOrFail($id);
        $categorias = CategoriaContenido::all();
        return view('auth.admin.contenidos.editar', compact('contenido', 'categorias'));
    }

    // Actualizar contenido
    public function actualizarContenido(Request $request, $id)
    {
        $contenido = Contenido::findOrFail($id);

        $request->validate([
            'nombre'            => 'required|string|max:255',
            'descripcion'       => 'nullable|string',
            'idcategoria'       => 'required|exists:categoriacontenido,idcategoria',
            'fechapublicacion'  => 'required|date',
            'archivo'           => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $contenido->nombre           = $request->nombre;
        $contenido->descripcion      = $request->descripcion;
        $contenido->idcategoria      = $request->idcategoria;
        $contenido->fechapublicacion = $request->fechapublicacion;

        if ($request->hasFile('archivo')) {
            // borra el anterior si existe
            if (!empty($contenido->url) && Storage::disk('public')->exists($contenido->url)) {
                Storage::disk('public')->delete($contenido->url);
            }
            $path = $request->file('archivo')->store('contenidos', 'public');
            $contenido->url = $path;
        }

        $contenido->save();

        return redirect()->route('admin.contenidos')->with('success', 'Contenido actualizado correctamente.');
}



    // Eliminar contenido
    public function eliminarContenido($id)
    {
        $contenido = Contenido::findOrFail($id);

        // Borra el PDF solo si hay path válido
        if (!empty($contenido->url) && Storage::disk('public')->exists($contenido->url)) {
            Storage::disk('public')->delete($contenido->url);
        }

        $contenido->delete();

        return redirect()->route('admin.contenidos')->with('success', 'Contenido eliminado correctamente.');
    }

    // Listar ebooks
    public function ebooks()
    {
        $ebooks = Ebook::orderBy('fecha', 'desc')->paginate(10);
        return view('auth.admin.ebooks.ebooks', compact('ebooks'));
    }

    // Mostrar formulario para crear ebook
    public function crearEbook()
    {
        return view('auth.admin.ebooks.create');
    }

    // Guardar nuevo ebook
    public function guardarEbook(Request $request)
    {
        $request->validate([
            'titulo'  => 'required|string|max:255',
            'fecha'   => 'required|date',
            'autor'   => 'required|string|max:255',
            'precio'  => 'required|numeric|min:0',
            'archivo' => 'required|file|mimes:pdf|max:5120',
        ]);

        $ebook = new Ebook();
        $ebook->titulo = $request->titulo;
        $ebook->fecha  = $request->fecha;
        $ebook->autor  = $request->autor;
        $ebook->precio = $request->precio;

        if ($request->hasFile('archivo')) {
            // Guarda en storage/app/private/ebooks/...
            $path = $request->file('archivo')->store('ebooks', 'private');
            $ebook->archivo = $path; // ej: "ebooks/mi-libro.pdf"
        }

        $ebook->save();

        return redirect()->route('admin.ebooks')->with('success', 'Ebook registrado correctamente.');
    }
    // Mostrar formulario para editar ebook
    public function editarEbook($id)
    {
        $ebook = Ebook::findOrFail($id);
        return view('auth.admin.ebooks.editar', compact('ebook'));
    }

    // Actualizar ebook
    public function actualizarEbook(Request $request, $id)
    {
        $ebook = Ebook::findOrFail($id);

        $request->validate([
            'titulo'  => 'required|string|max:255',
            'fecha'   => 'required|date',
            'autor'   => 'required|string|max:255',
            'precio'  => 'required|numeric|min:0',
            'archivo' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $ebook->titulo = $request->titulo;
        $ebook->fecha  = $request->fecha;
        $ebook->autor  = $request->autor;
        $ebook->precio = $request->precio;

        if ($request->hasFile('archivo')) {
            // (Opcional) Borra el anterior si existe
            if ($ebook->archivo && Storage::disk('private')->exists($ebook->archivo)) {
                Storage::disk('private')->delete($ebook->archivo);
            }
            $path = $request->file('archivo')->store('ebooks', 'private');
            $ebook->archivo = $path;
        }

        $ebook->save();

        return redirect()->route('admin.ebooks')->with('success', 'Ebook actualizado correctamente.');
    }

    // Eliminar ebook
    public function eliminarEbook($id)
    {
        $ebook = Ebook::findOrFail($id);

        if ($ebook->archivo && Storage::disk('private')->exists($ebook->archivo)) {
            Storage::disk('private')->delete($ebook->archivo);
        }

        $ebook->delete();

        return redirect()->route('admin.ebooks')->with('success', 'Ebook eliminado correctamente.');
    }

    public function verEbook($id)
    {
        $ebook = Ebook::findOrFail($id);

        if (!Storage::disk('private')->exists($ebook->archivo)) {
            abort(404);
        }

        return response()->file(
            Storage::disk('private')->path($ebook->archivo),
            ['Content-Type' => 'application/pdf']
        );
    }

    public function descargarEbook($id)
    {
        $ebook = Ebook::findOrFail($id);

        if (!Storage::disk('private')->exists($ebook->archivo)) {
            abort(404);
        }

        $nombre = Str::slug($ebook->titulo) . '.pdf';

        return response()->download(
            Storage::disk('private')->path($ebook->archivo),
            $nombre,
            ['Content-Type' => 'application/pdf']
        );
    }


    // Reportes
    public function reportes()
    {
        // Totales por estado
        $totalUsuarios = Usuario::count();
        $activos       = Usuario::where('status','activo')->count();
        $inactivos     = Usuario::where('status','inactivo')->count();
        $prueba        = Usuario::where('status','prueba')->count();
        $suspendidos   = Usuario::where('status','suspendido')->count();

        // Totales por rol
        $admins    = Usuario::whereHas('role', fn($q)=>$q->where('nombre','admin'))->count();
        $empleados = Usuario::whereHas('role', fn($q)=>$q->where('nombre','empleado'))->count();
        $usuarios  = Usuario::whereHas('role', fn($q)=>$q->where('nombre','usuario'))->count();

        // Altas de usuarios por mes (últimos 6 meses)
        $desde = now()->subMonths(5)->startOfMonth();
        $usuariosPorMes = Usuario::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as total')
            ->where('created_at', '>=', $desde)
            ->groupBy('mes')->orderBy('mes')->get();

        // Ebooks / Contenidos
        $ebooksTotal      = class_exists(Ebook::class) ? Ebook::count() : 0;
        $ebooksValorTotal = class_exists(Ebook::class) ? Ebook::sum('precio') : 0;
        $contenidosTotal  = class_exists(Contenido::class) ? Contenido::count() : 0;

        // Actividad reciente (últimos usuarios creados)
        $ultimosUsuarios = Usuario::with('role')->orderByDesc('created_at')->take(8)->get();

        /** --------------------------
         *   MÉTRICAS DE FORO
         *  -------------------------- */

        // Totales de hilos y respuestas
        $forosTotal      = Foro::count();
        $respuestasTotal = ForoRespuesta::count();

        // Abiertos / cerrados (si añadiste el campo 'closed')
        $forosCerrados = Foro::where('closed', true)->count();
        $forosAbiertos = Foro::where('closed', false)->count();

        // Hilos por mes (últimos 6) usando el campo 'fecha' del hilo
        $forosPorMes = Foro::selectRaw('DATE_FORMAT(fecha, "%Y-%m") as mes, COUNT(*) as total')
            ->where('fecha', '>=', $desde)
            ->groupBy('mes')->orderBy('mes')->get();

        // Respuestas por mes (últimos 6)
        $respuestasPorMes = ForoRespuesta::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as total')
            ->where('created_at', '>=', $desde)
            ->groupBy('mes')->orderBy('mes')->get();

        // Top 5 hilos por vistas
        $topHilos = Foro::orderByDesc('vistas')
            ->take(5)
            ->get(['idforo','titulo','vistas','num_respuestas']);

        // Autores más activos (por cantidad de hilos)
        $topAutores = Foro::select('autor', DB::raw('COUNT(*) as hilos'), DB::raw('SUM(vistas) as total_vistas'))
            ->groupBy('autor')
            ->orderByDesc('hilos')
            ->take(5)
            ->get();

        // Respuestas por empleado (top 5) con nombre (si guardas usuario_id en respuestas)
        $respuestasPorEmpleado = ForoRespuesta::select(
                'foro_respuestas.usuario_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('MAX(usuarios.nombre) as nombre'),
                DB::raw('MAX(usuarios.apellido) as apellido')
            )
            ->leftJoin('usuarios', 'usuarios.idusuario', '=', 'foro_respuestas.usuario_id')
            ->whereNotNull('foro_respuestas.usuario_id')
            ->groupBy('foro_respuestas.usuario_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Promedio de minutos hasta la primera respuesta
        $firstReplies = ForoRespuesta::select('foro_id', DB::raw('MIN(created_at) as first_reply_at'))
            ->groupBy('foro_id');

        $promedioMinPrimeraRespuesta = Foro::joinSub($firstReplies, 'fr', function ($join) {
                $join->on('fr.foro_id', '=', 'foro.idforo');
            })
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, foro.fecha, fr.first_reply_at)) as avg_min'))
            ->value('avg_min');

        // Hilos sin respuesta
        $hilosSinRespuesta = Foro::where('num_respuestas', 0)->count();

        return view('auth.admin.reportes.reportes', compact(
            // Usuarios / roles
            'totalUsuarios','activos','inactivos','prueba','suspendidos',
            'admins','empleados','usuarios','usuariosPorMes',
            // Ebooks / contenidos
            'ebooksTotal','ebooksValorTotal','contenidosTotal','ultimosUsuarios',
            // Foro
            'forosTotal','respuestasTotal','forosCerrados','forosAbiertos',
            'forosPorMes','respuestasPorMes','topHilos','topAutores',
            'respuestasPorEmpleado','promedioMinPrimeraRespuesta','hilosSinRespuesta'
        ));
    }
    // LISTADO (GET /admin/foro)
    public function foroIndex(Request $request)
    {
        $q = Foro::query();

        if ($request->filled('q')) {
            $q->where(function($w) use ($request){
                $w->where('titulo','like','%'.$request->q.'%')
                ->orWhere('autor','like','%'.$request->q.'%');
            });
        }
        if ($request->filled('estado')) {
            $q->where('estado', $request->estado);
        }
        if ($request->boolean('pinned', null) !== null) {
            $q->where('pinned', (bool)$request->pinned);
        }
        if ($request->boolean('closed', null) !== null) {
            $q->where('closed', (bool)$request->closed);
        }

        $foros = $q->orderByDesc('pinned')
                ->orderByDesc(DB::raw('COALESCE(last_activity_at, fecha)'))
                ->paginate(10)
                ->withQueryString();

        return view('auth.admin.foro.foro', compact('foros')); // <-- aquí
    }


    public function foroShow($id)
    {
        $foro = Foro::findOrFail($id);
        // respuestas paginadas (asc para leer conversación)
        $respuestas = ForoRespuesta::where('foro_id', $foro->idforo)
                    ->orderBy('created_at', 'asc')
                    ->paginate(10);

        return view('auth.admin.foro.show', compact('foro','respuestas'));
    }

    public function foroResponder(Request $request, $idforo)
    {
        // 1) Validación
        $request->validate([
            'nombre'  => 'required|string|max:150',
            'mensaje' => 'required|string|max:5000',
        ]);

        // 2) Cargar hilo
        $foro = Foro::findOrFail($idforo);

        // 3) Si está cerrado, no permitir responder
        if ($foro->closed) {
            return back()->with('error', 'El tema está cerrado. No puedes responder.');
        }

        // 4) Usuario autenticado
        /** @var \App\Models\Usuario|null $actor */
        $actor = Auth::user();
        if (!$actor) {
            abort(403);
        }

        $rolActor = optional($actor->role)->nombre; // admin | empleado | usuario
        $esAdmin  = $rolActor === 'admin';

        // 5) Guardar respuesta y actualizar métricas de forma atómica
        DB::transaction(function () use ($request, $foro, $actor, $esAdmin) {
            ForoRespuesta::create([
                'foro_id'    => $foro->idforo,
                'usuario_id' => $actor->idusuario ?? null,
                'nombre'     => $request->nombre,
                'es_admin'   => $esAdmin,
                'mensaje'    => $request->mensaje,
            ]);

            $foro->increment('num_respuestas');
            $foro->last_activity_at = now();
            $foro->save();
        });

        // $foro->refresh(); // opcional

        // 6) Notificar a ADMINS si respondió empleado/usuario
        if (in_array($rolActor, ['empleado', 'usuario'])) {
            $admins = Usuario::whereHas('role', fn($q) => $q->where('nombre', 'admin'))->get();

            if ($admins->isNotEmpty()) {
                // Log para depurar
                logger()->info('[Foro] Admins a notificar', [
                    'ids' => $admins->pluck('idusuario')->all(),
                    'foro_id' => $foro->idforo,
                ]);

                // Enviar notificación a cada admin (canal: database)
                $admins->each->notify(new \App\Notifications\NuevaRespuestaForo(
                    $foro,
                    $request->nombre,
                    $request->mensaje
                ));
            }
        }

        $rolActor = optional(Auth::user()->role)->nombre; // admin | empleado | usuario
            if ($rolActor === 'admin') {
                return redirect()
                    ->route('admin.foro.show', $foro->idforo)
                    ->with('success', 'Respuesta publicada.');
            }

        // para usuario (y empleado, si lo usas desde allí) redirige al show de usuario
        return redirect()
                ->route('usuario.foro.show', $foro->idforo)
                ->with('success', 'Respuesta publicada.');
    }



    public function marcarNotificacion(Request $request)
    {
        /** @var \App\Models\Usuario|null $user */
        $user = Auth::user(); 
        if (!$user) {
            abort(403);
        }

        $id = $request->input('id');

        if ($id) {
            // Marcar una notificación específica como leída
            $user->notifications()->whereKey($id)->update(['read_at' => now()]);
        } else {
            // Marcar todas las no leídas
            $user->unreadNotifications()->update(['read_at' => now()]);
            // (Alternativa) $user->unreadNotifications->markAsRead();
        }

        return $request->wantsJson()
            ? response()->json(['ok' => true])
            : back();

    }




    public function foroTogglePin($id)
    {
        $foro = Foro::findOrFail($id);
        $foro->pinned = !$foro->pinned;
        $foro->save();

        return back()->with('success', $foro->pinned ? 'Hilo fijado.' : 'Hilo desfijado.');
    }

    public function foroToggleClose($id)
    {
        $foro = Foro::findOrFail($id);
        $foro->closed = !$foro->closed;
        $foro->save();

        return back()->with('success', $foro->closed ? 'Hilo cerrado.' : 'Hilo reabierto.');
    }

    public function foroDestroy($id)
    {
        $foro = Foro::findOrFail($id);
        $foro->delete(); // si usas SoftDeletes; si no, ->forceDelete()

        return redirect()->route('admin.foro.index')->with('success', 'Hilo eliminado.');
    }

    public function foroRespuestaDestroy($idforo, $idres)
    {
        $r = ForoRespuesta::where('idrespuestaforo', $idres)
            ->where('foro_id', $idforo)
            ->firstOrFail();

        $r->delete();

        // Recalcular conteo
        Foro::where('idforo', $idforo)->decrement('num_respuestas');

        return back()->with('success', 'Respuesta eliminada.');
    }


}
