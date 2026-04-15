@extends('auth.layout.dash_layout')

@section('title', 'Reportes')

@section('body')
<div class="ib-wrapper">
  @include('auth.layout.partials.sidebar')

  <main class="ib-main-panel">
    @include('auth.layout.partials.navbar')

    <section class="ib-content">
      <div class="container-fluid">

        {{-- RESUMEN EN TARJETAS --}}
        <div class="row">
          <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="text-muted mb-1">Usuarios Totales</h6>
                <h3 class="mb-0">{{ $totalUsuarios }}</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="text-muted mb-1">Activos</h6>
                <h3 class="mb-0">{{ $activos }}</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="text-muted mb-1">En Prueba</h6>
                <h3 class="mb-0">{{ $prueba }}</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="text-muted mb-1">Suspendidos</h6>
                <h3 class="mb-0">{{ $suspendidos }}</h3>
              </div>
            </div>
          </div>
        </div>

        {{-- RESUMEN DE CONTENIDO --}}
        <div class="row">
          <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="text-muted mb-1">Ebooks</h6>
                <div class="d-flex justify-content-between align-items-end">
                  <h3 class="mb-0">{{ $ebooksTotal }}</h3>
                  <small class="text-muted">Valor total: S/ {{ number_format($ebooksValorTotal,2) }}</small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="text-muted mb-1">Contenidos</h6>
                <h3 class="mb-0">{{ $contenidosTotal }}</h3>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <h6 class="text-muted mb-1">Empleados</h6>
                <h3 class="mb-0">{{ $empleados }}</h3>
              </div>
            </div>
          </div>
        </div>

        {{-- GRAFICOS --}}
        <div class="row">
          <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
              <div class="card-header">Altas de usuarios por mes</div>
              <div class="card-body">
                <canvas id="chartAltas"></canvas>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
              <div class="card-header">Distribución por estado</div>
              <div class="card-body">
                <canvas id="chartEstados"></canvas>
              </div>
            </div>
          </div>
        </div>

        {{-- ROLES + ACTIVIDAD RECIENTE --}}
        <div class="row">
          <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
              <div class="card-header">Usuarios por rol</div>
              <div class="card-body">
                <canvas id="chartRoles"></canvas>
              </div>
            </div>
          </div>

          <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
              <div class="card-header">Actividad reciente (usuarios)</div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm mb-0">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Creado</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($ultimosUsuarios as $u)
                        <tr>
                          <td>{{ $u->nombre }} {{ $u->apellido }}</td>
                          <td>{{ $u->correo }}</td>
                          <td>{{ $u->role->nombre ?? '-' }}</td>
                          <td>{{ $u->created_at?->format('Y-m-d H:i') }}</td>
                        </tr>
                      @empty
                        <tr><td colspan="4" class="text-center">Sin registros.</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    @include('auth.layout.partials.footer')
  </main>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Datos desde PHP
  const meses  = @json($usuariosPorMes->pluck('mes'));
  const altas  = @json($usuariosPorMes->pluck('total'));

  const estadosLabels = ['activo','inactivo','prueba','suspendido'];
  const estadosData   = [{{ $activos }}, {{ $inactivos }}, {{ $prueba }}, {{ $suspendidos }}];

  const rolesLabels = ['admin','empleado','usuario'];
  const rolesData   = [{{ $admins }}, {{ $empleados }}, {{ $usuarios }}];

  // Altas por mes
  new Chart(document.getElementById('chartAltas'), {
    type: 'line',
    data: { labels: meses, datasets: [{ label: 'Altas', data: altas }] },
    options: { responsive: true, maintainAspectRatio: false }
  });

  // Estados (pie)
  new Chart(document.getElementById('chartEstados'), {
    type: 'pie',
    data: { labels: estadosLabels, datasets: [{ data: estadosData }] },
    options: { responsive: true, maintainAspectRatio: false }
  });

  // Roles (bar)
  new Chart(document.getElementById('chartRoles'), {
    type: 'bar',
    data: { labels: rolesLabels, datasets: [{ label: 'Usuarios', data: rolesData }] },
    options: {
      responsive: true, maintainAspectRatio: false,
      scales: { y: { beginAtZero: true } }
    }
  });
</script>
@endsection
