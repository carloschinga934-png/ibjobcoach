<!-- resources/views/tickets/historial.blade.php -->

@extends('shared.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Historial de Atención de {{ $usuario->nombre }} {{ $usuario->apellido }}</h2>

    <p><strong>Correo:</strong> {{ $usuario->correo }}</p>
    <p><strong>Estado:</strong> {{ ucfirst($usuario->status) }}</p>

    <h4 class="mt-4">Tickets de Soporte</h4>

    <!-- Filtro de tickets si es necesario -->
    <div class="mb-4">
        <form method="GET" action="{{ route('tickets.historial', $usuario->idusuario) }}">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar ticket por asunto..." value="{{ request('buscar') }}">
        </form>
    </div>

    @if($tickets->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Asunto</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->titulo }}</td>
                        <td>{{ ucfirst($ticket->estado) }}</td>
                        <td>{{ ucfirst($ticket->prioridad) }}</td>
                        <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('tickets.show', [$usuario->idusuario, $ticket->id]) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $tickets->links() }}
        </div>
    @else
        <p>No se han registrado tickets para este usuario.</p>
    @endif
</div>
@endsection
