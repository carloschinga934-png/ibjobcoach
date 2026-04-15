<?php

namespace App\Http\Controllers;

use App\Models\TicketSoporte;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActividadSoporte;  
use Carbon\Carbon; // Add this line
use App\Models\User; // ← AGREGAR ESTA LÍNEA



class TicketsController extends Controller
{
    // Ver todos los tickets de un usuario
    public function index($usuarioId = null)
    {
        $usuario = $usuarioId ? Usuario::findOrFail($usuarioId) : null;
        $usuarioActual = Auth::user();
        
        $query = TicketSoporte::with(['usuario', 'asignado']);
        
        // Si se especifica un usuario, filtrar por él
        if ($usuario) {
            $query->where('usuario_id', $usuario->idusuario);
        }
        
        // Filtros por parámetros GET
        if (request('estado')) {
            $query->where('estado', request('estado'));
        }
        
        if (request('prioridad')) {
            $query->where('prioridad', request('prioridad'));
        }
        
        if (request('categoria')) {
            $query->where('categoria', request('categoria'));
        }
        
        if (request('asignado_a')) {
            $query->where('asignado_a', request('asignado_a'));
        }
        
        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Estadísticas
        $estadisticas = [
            'total' => TicketSoporte::when($usuario, fn($q) => $q->where('usuario_id', $usuario->idusuario))->count(),
            'abiertos' => TicketSoporte::when($usuario, fn($q) => $q->where('usuario_id', $usuario->idusuario))->abiertos()->count(),
            'resueltos' => TicketSoporte::when($usuario, fn($q) => $q->where('usuario_id', $usuario->idusuario))->where('estado', 'resuelto')->count(),
            'vencidos' => TicketSoporte::when($usuario, fn($q) => $q->where('usuario_id', $usuario->idusuario))->vencidos()->count(),
            'validados' => TicketSoporte::when($usuario, fn($q) => $q->where('usuario_id', $usuario->idusuario))->validados()->count(),
            'sin_validar' => TicketSoporte::when($usuario, fn($q) => $q->where('usuario_id', $usuario->idusuario))->sinValidar()->count(),
        ];
        
        // Lista de empleados para filtro
       $empleados = Usuario::whereHas('role', function($q) {
    $q->where('nombre', 'empleado');
})->get();
        
        return view('tickets.index', compact('tickets', 'estadisticas', 'usuario', 'empleados'));
    }

    // Mostrar formulario para crear ticket
   public function create($usuarioId)
{
    $usuario = Usuario::findOrFail($usuarioId);
    
    // Obtener empleados que tienen el rol 'empleado'
    $empleados = Usuario::whereHas('role', function($q) {
        $q->where('nombre', 'empleado');  // Suponiendo que la columna en la tabla roles es 'nombre'
    })->get();
    
    return view('tickets.create', compact('usuario', 'empleados'));
}

    // Guardar nuevo ticket
    public function store(Request $request, $usuarioId)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string|max:5000',
            'prioridad' => 'required|in:baja,normal,alta,urgente',
            'categoria' => 'required|in:tecnico,comercial,facturacion,general',
            'asignado_a' => 'nullable|exists:usuarios,idusuario',
            'fecha_limite' => 'nullable|date|after:today'
        ]);

        $usuario = Usuario::findOrFail($usuarioId);

        TicketSoporte::create([
            'usuario_id' => $usuario->idusuario,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'prioridad' => $request->prioridad,
            'categoria' => $request->categoria,
            'asignado_a' => $request->asignado_a,
            'fecha_limite' => $request->fecha_limite,
            'estado' => $request->asignado_a ? 'en_progreso' : 'abierto'
        ]);

        return redirect()
            ->route('tickets.index', $usuarioId)
            ->with('success', 'Ticket creado correctamente');
    }

    // Ver detalle de un ticket
    public function show($usuarioId, $ticketId)
{
    $usuario = Usuario::findOrFail($usuarioId);
    $ticket = TicketSoporte::where('usuario_id', $usuario->idusuario)
                           ->where('id', $ticketId)  // Usa 'id' para hacer referencia al ticket
                           ->with(['usuario', 'asignado'])
                           ->firstOrFail();

    $actividades = $ticket->actividades;  // Usa la relación correctamente

    return view('tickets.show', compact('usuario', 'ticket', 'actividades'));
}

    // Mostrar formulario para editar ticket
    public function edit($usuarioId, $ticketId)
    {
        $usuario = Usuario::findOrFail($usuarioId);
        $ticket = TicketSoporte::where('usuario_id', $usuario->idusuario)
                              ->where('id', $ticketId)
                              ->firstOrFail();

        // Lista de empleados que pueden ser asignados
       $empleados = Usuario::whereHas('role', function($q) {
    $q->where('nombre', 'empleado');
})->get();


        return view('tickets.edit', compact('usuario', 'ticket', 'empleados'));
    }

    // Actualizar ticket
    public function update(Request $request, $usuarioId, $ticketId)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string|max:5000',
            'prioridad' => 'required|in:baja,normal,alta,urgente',
            'categoria' => 'required|in:tecnico,comercial,facturacion,general',
            'estado' => 'required|in:abierto,en_progreso,esperando_cliente,resuelto,cerrado',
            'asignado_a' => 'nullable|exists:usuarios,idusuario',
            'fecha_limite' => 'nullable|date',
            'solucion' => 'nullable|string|max:5000'
        ]);

        $usuario = Usuario::findOrFail($usuarioId);
        $ticket = TicketSoporte::where('usuario_id', $usuario->idusuario)
                              ->where('id', $ticketId)
                              ->firstOrFail();

        $datos = $request->only([
            'titulo', 'descripcion', 'prioridad', 'categoria', 
            'estado', 'asignado_a', 'fecha_limite', 'solucion'
        ]);

        // Si se marca como resuelto, agregar fecha de resolución
        if ($request->estado === 'resuelto' && $ticket->estado !== 'resuelto') {
            $datos['fecha_resolucion'] = now();
        }

        $ticket->update($datos);

        return redirect()
            ->route('tickets.index', $usuarioId)
            ->with('success', 'Ticket actualizado correctamente');
    }

    // Eliminar ticket
    public function destroy($usuarioId, $ticketId)
    {
        $usuario = Usuario::findOrFail($usuarioId);
        $ticket = TicketSoporte::where('usuario_id', $usuario->idusuario)
                              ->where('id', $ticketId)
                              ->firstOrFail();

        $ticket->delete();

        return redirect()
            ->route('tickets.index', $usuarioId)
            ->with('success', 'Ticket eliminado correctamente');
    }

    // Dashboard general de tickets
    public function dashboard()
    {
        $usuarioActual = Auth::user();
        
        // Tickets asignados al usuario actual
        $ticketsAsignados = TicketSoporte::asignadoA($usuarioActual->idusuario)
                                       ->with('usuario')
                                       ->abiertos()
                                       ->orderBy('prioridad', 'desc')
                                       ->orderBy('created_at', 'asc')
                                       ->get();

        // Tickets sin asignar (solo para administradores/empleados)
        $ticketsSinAsignar = TicketSoporte::whereNull('asignado_a')
                                        ->with('usuario')
                                        ->orderBy('prioridad', 'desc')
                                        ->orderBy('created_at', 'asc')
                                        ->get();

        // Estadísticas del empleado
        $estadisticasPersonales = [
            'asignados' => TicketSoporte::asignadoA($usuarioActual->idusuario)->abiertos()->count(),
            'resueltos_hoy' => TicketSoporte::asignadoA($usuarioActual->idusuario)
                                          ->where('estado', 'resuelto')
                                          ->whereDate('fecha_resolucion', today())
                                          ->count(),
            'vencidos' => TicketSoporte::asignadoA($usuarioActual->idusuario)->vencidos()->count(),
        ];

        return view('tickets.dashboard', compact(
            'ticketsAsignados', 
            'ticketsSinAsignar', 
            'estadisticasPersonales'
        ));
    }

    // Asignar ticket
    public function asignar(Request $request, $ticketId)
    {
        $request->validate([
            'asignado_a' => 'required|exists:usuarios,idusuario'
        ]);

        $ticket = TicketSoporte::findOrFail($ticketId);
        
        $ticket->update([
            'asignado_a' => $request->asignado_a,
            'estado' => 'en_progreso'
        ]);

        return back()->with('success', 'Ticket asignado correctamente');
    }

    // Resolver ticket rápido
public function resolver(Request $request, $usuarioId, $ticketId)
    {
        // Validar la solución proporcionada
        $request->validate([
            'solucion' => 'required|string|max:5000',
        ]);

        // Buscar el ticket por su ID y usuarioId
        $ticket = TicketSoporte::where('usuario_id', $usuarioId)
                               ->where('id', $ticketId)
                               ->firstOrFail();

        // Verificar si el usuario tiene permisos para resolver este ticket
        if (!$ticket->puedeResolver(Auth::user()->idusuario)) {
            abort(403, 'No tienes permisos para resolver este ticket');
        }

        // Marcar el ticket como resuelto
        $ticket->marcarComoResuelto($request->solucion);

        // Registrar actividad de resolución
        ActividadSoporte::create([
            'ticket_id' => $ticket->id,
            'usuario_id' => Auth::user()->idusuario,
            'actividad' => 'Ticket resuelto: ' . $request->solucion,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('tickets.index', $usuarioId)
                         ->with('success', 'Ticket marcado como resuelto');
    }

    // Validar atención del ticket
public function validar(Request $request, $ticketId)
{
    // Validar los campos que realmente envía tu formulario
    $data = $request->validate([
        'observaciones_validacion' => 'nullable|string|max:5000',
    ]);

    // Buscar el ticket
    $ticket = TicketSoporte::findOrFail($ticketId);

    // Verificar permisos si es necesario
    if (!$ticket->puedeValidar(auth()->user()->idusuario)) {
        abort(403, 'No tienes permisos para validar este ticket');
    }

    // Actualizar el ticket como validado
    $ticket->update([
        'estado' => 'cerrado',   // Usar 'cerrado' en lugar de 'validado'
        'validado' => true,      // campo boolean para marcar como validado
        'pendiente_validacion' => false,
        'validado_por' => auth()->user()->idusuario,
        'fecha_validacion' => now(),
        'observaciones_validacion' => $data['observaciones_validacion']
    ]);

    // Registrar actividad
    ActividadSoporte::create([
        'ticket_id' => $ticket->id,
        'usuario_id' => auth()->user()->idusuario,
        'actividad' => 'Ticket validado' . ($data['observaciones_validacion'] ? ': ' . $data['observaciones_validacion'] : '')
    ]);

    return back()->with('success', 'Ticket validado correctamente');
}
    // Rechazar validación (volver a en_progreso)
   public function rechazarValidacion(Request $request, $ticketId)
{
    $request->validate([
        'motivo_rechazo' => 'required|string|max:1000'
    ]);

    $ticket = TicketSoporte::where('id', $ticketId)
                          ->where('estado', 'resuelto')
                          ->firstOrFail();

    $ticket->update([
        'estado' => 'en_progreso',
        'solucion' => $ticket->solucion . "\n\n--- VALIDACIÓN RECHAZADA ---\n" . $request->motivo_rechazo,
        'fecha_resolucion' => null
    ]);

    return back()->with('warning', 'Ticket devuelto para corrección');
}

    // Dashboard de validación para supervisores
    public function dashboardValidacion()
    {
        $ticketsPorValidar = TicketSoporte::sinValidar()
                                        ->with(['usuario', 'asignado'])
                                        ->orderBy('fecha_resolucion', 'asc')
                                        ->get();

        $estadisticasValidacion = [
            'pendientes_validacion' => TicketSoporte::sinValidar()->count(),
            'validados_hoy' => TicketSoporte::validados()
                                          ->whereDate('fecha_validacion', today())
                                          ->count(),
            'tiempo_promedio_resolucion' => TicketSoporte::where('estado', 'resuelto')
                                                        ->whereNotNull('tiempo_resolucion')
                                                        ->avg('tiempo_resolucion'),
        ];

        return view('tickets.validacion', compact('ticketsPorValidar', 'estadisticasValidacion'));
    }
    public function historial($usuarioId)
    {
        // Obtener el usuario con el ID proporcionado
        $usuario = Usuario::findOrFail($usuarioId);

        // Consultar todos los tickets asociados a este usuario
        $tickets = TicketSoporte::where('usuario_id', $usuario->idusuario)
            ->orderBy('created_at', 'desc')  // Ordenar por fecha de creación
            ->paginate(15);  // Paginación de 15 tickets

        // Pasar los tickets y el usuario a la vista
        return view('tickets.historial', compact('usuario', 'tickets'));
    }
    public function kanban()
    {
        // Obtener los tickets en las distintas categorías
        $pendientes = TicketSoporte::where('estado', 'abierto')->orderBy('created_at')->get();
        
        $porAtenderHoy = TicketSoporte::where('fecha_limite', Carbon::today())
                                      ->where('estado', '!=', 'resuelto')
                                      ->orderBy('created_at')->get();
        
        $resueltos = TicketSoporte::where('estado', 'resuelto')->orderBy('updated_at')->get();
        
        $activos = TicketSoporte::whereIn('estado', ['en_progreso', 'esperando_cliente'])
                                ->orderBy('created_at')->get();

        return view('tickets.kanban', compact('pendientes', 'porAtenderHoy', 'resueltos', 'activos'));
    }
    public function reportes($usuarioId)
{
    // Reporte de tickets pendientes del usuario específico
    $pendientes = TicketSoporte::where('estado', 'abierto')
                              ->where('usuario_id', $usuarioId)
                              ->count();

    // Reporte de tickets por prioridad del usuario
    $prioridadBaja = TicketSoporte::where('prioridad', 'baja')
                                  ->where('usuario_id', $usuarioId)
                                  ->count();
    $prioridadNormal = TicketSoporte::where('prioridad', 'normal')
                                    ->where('usuario_id', $usuarioId)
                                    ->count();
    $prioridadAlta = TicketSoporte::where('prioridad', 'alta')
                                  ->where('usuario_id', $usuarioId)
                                  ->count();
    $prioridadUrgente = TicketSoporte::where('prioridad', 'urgente')
                                     ->where('usuario_id', $usuarioId)
                                     ->count();

    // Reporte de tickets resueltos del usuario
    $resueltos = TicketSoporte::where('estado', 'resuelto')
                              ->where('usuario_id', $usuarioId)
                              ->count();

    // Reporte de tickets vencidos del usuario
    $vencidos = TicketSoporte::where('fecha_limite', '<', Carbon::now())
                             ->where('estado', '!=', 'resuelto')
                             ->where('usuario_id', $usuarioId)
                             ->count();

    // Reporte de tickets por categoría del usuario
    $categoriaTecnico = TicketSoporte::where('categoria', 'tecnico')
                                     ->where('usuario_id', $usuarioId)
                                     ->count();
    $categoriaComercial = TicketSoporte::where('categoria', 'comercial')
                                       ->where('usuario_id', $usuarioId)
                                       ->count();
    $categoriaFacturacion = TicketSoporte::where('categoria', 'facturacion')
                                         ->where('usuario_id', $usuarioId)
                                         ->count();
    $categoriaGeneral = TicketSoporte::where('categoria', 'general')
                                     ->where('usuario_id', $usuarioId)
                                     ->count();

    // Obtener información del usuario (opcional)
    $usuario = Usuario::findOrFail($usuarioId); // ← User por Usuario
        
        return view('tickets.reportes', compact(
            'pendientes', 
            'prioridadBaja', 
            'prioridadNormal', 
            'prioridadAlta', 
            'prioridadUrgente',
            'resueltos',
            'vencidos',
            'categoriaTecnico',
            'categoriaComercial',
            'categoriaFacturacion',
            'categoriaGeneral',
            'usuario'
        ));
}
}