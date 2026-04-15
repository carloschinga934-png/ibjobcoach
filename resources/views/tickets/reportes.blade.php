@extends('shared.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Reportes Rápidos de Tickets</h2>

    <!-- Reporte de Tickets Pendientes -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Tickets Pendientes</h5>
            <p>Total de tickets pendientes: <strong>{{ $pendientes }}</strong></p>
        </div>
    </div>

    <!-- Reporte de Tickets por Prioridad -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Tickets por Prioridad</h5>
            <p>Baja: <strong>{{ $prioridadBaja }}</strong></p>
            <p>Normal: <strong>{{ $prioridadNormal }}</strong></p>
            <p>Alta: <strong>{{ $prioridadAlta }}</strong></p>
            <p>Urgente: <strong>{{ $prioridadUrgente }}</strong></p>
        </div>
    </div>

    <!-- Reporte de Tickets Resueltos -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Tickets Resueltos</h5>
            <p>Total de tickets resueltos: <strong>{{ $resueltos }}</strong></p>
        </div>
    </div>

    <!-- Reporte de Tickets Vencidos -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Tickets Vencidos</h5>
            <p>Total de tickets vencidos: <strong>{{ $vencidos }}</strong></p>
        </div>
    </div>

    <!-- Reporte de Tickets por Categoría -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Tickets por Categoría</h5>
            <p>Técnico: <strong>{{ $categoriaTecnico }}</strong></p>
            <p>Comercial: <strong>{{ $categoriaComercial }}</strong></p>
            <p>Facturación: <strong>{{ $categoriaFacturacion }}</strong></p>
            <p>General: <strong>{{ $categoriaGeneral }}</strong></p>
        </div>
    </div>
</div>
@endsection
