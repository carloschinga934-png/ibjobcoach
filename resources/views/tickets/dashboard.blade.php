@extends('shared.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Dashboard de Tickets</h2>

    <!-- Estadísticas personales -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5>Tickets Asignados</h5>
                    <h3>{{ $estadisticasPersonales['asignados'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Resueltos Hoy</h5>
                    <h3>{{ $estadisticasPersonales['resueltos_hoy'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5>Vencidos</h5>
                    <h3>{{ $estadisticasPersonales['vencidos'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5>Total Tickets</h5>
                    <h3>{{ $estadisticasPersonales['total'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Primera fila de gráficos -->
    <div class="row mb-4">
        <!-- Gráfico de Barras para Tickets Personales -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Mis Estadísticas</h4>
                    <canvas id="ticketsBarChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Dona para Estados de Mis Tickets -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Estados de Mis Tickets</h4>
                    <canvas id="misTicketsStateChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Segunda fila de gráficos -->
    <div class="row mb-4">
        <!-- Gráfico de Líneas para Tendencia Semanal -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4>Tendencia de Tickets - Últimos 7 días</h4>
                    <canvas id="tendenciaChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Tarta para Todos los Estados -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4>Estados Generales</h4>
                    <canvas id="ticketStateChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tercera fila de gráficos -->
    <div class="row mb-4">
        <!-- Gráfico de Barras Horizontales para Prioridades -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Tickets por Prioridad</h4>
                    <canvas id="prioridadChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Área para Resolución Mensual -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Resolución Mensual</h4>
                    <canvas id="resolucionMensualChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets asignados -->
    <div class="row">
        <div class="col-md-6">
            <h4>Mis Tickets Asignados</h4>
            <div class="card">
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($ticketsAsignados as $ticket)
                        <div class="border-bottom pb-2 mb-2">
                            <h6>{{ $ticket->titulo }}</h6>
                            <span class="badge bg-{{ $ticket->color_prioridad }}">{{ $ticket->prioridad }}</span>
                            <span class="badge bg-{{ $ticket->color_estado }}">{{ $ticket->estado }}</span>
                            <p class="small mb-1">Cliente: {{ $ticket->usuario->nombre }}</p>
                            <small class="text-muted">Creado: {{ $ticket->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p>No tienes tickets asignados</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h4>Tickets Sin Asignar</h4>
            <div class="card">
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($ticketsSinAsignar as $ticket)
                        <div class="border-bottom pb-2 mb-2">
                            <h6>{{ $ticket->titulo }}</h6>
                            <span class="badge bg-{{ $ticket->color_prioridad }}">{{ $ticket->prioridad }}</span>
                            <p class="small mb-1">Cliente: {{ $ticket->usuario->nombre }}</p>
                            <small class="text-muted">Creado: {{ $ticket->created_at->diffForHumans() }}</small>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-outline-primary" onclick="asignarTicket({{ $ticket->id }})">
                                    <i class="fas fa-hand-paper"></i> Tomar
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p>No hay tickets sin asignar</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Configuración global de Chart.js
    Chart.defaults.font.family = 'Arial, sans-serif';
    Chart.defaults.responsive = true;
    Chart.defaults.maintainAspectRatio = false;

    // 1. Gráfico de Barras - Estadísticas Personales
    var ticketsBarChartData = {
        labels: ['Asignados', 'Resueltos Hoy', 'Vencidos'],
        datasets: [{
            label: 'Tickets',
            data: [
                {{ $estadisticasPersonales['asignados'] }},
                {{ $estadisticasPersonales['resueltos_hoy'] }},
                {{ $estadisticasPersonales['vencidos'] }}
            ],
            backgroundColor: [
                'rgba(0, 123, 255, 0.8)',
                'rgba(40, 167, 69, 0.8)',
                'rgba(220, 53, 69, 0.8)'
            ],
            borderColor: [
                'rgba(0, 123, 255, 1)',
                'rgba(40, 167, 69, 1)',
                'rgba(220, 53, 69, 1)'
            ],
            borderWidth: 2
        }]
    };

    var ctxBarChart = document.getElementById('ticketsBarChart').getContext('2d');
    var ticketsBarChart = new Chart(ctxBarChart, {
        type: 'bar',
        data: ticketsBarChartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // 2. Gráfico de Dona - Estados de Mis Tickets
    var misTicketsStateData = {
        labels: ['Abiertos', 'En Progreso', 'Esperando', 'Resueltos'],
        datasets: [{
            data: [
                {{ $estadisticasPersonales['mis_abiertos'] ?? 0 }},
                {{ $estadisticasPersonales['mis_progreso'] ?? 0 }},
                {{ $estadisticasPersonales['mis_esperando'] ?? 0 }},
                {{ $estadisticasPersonales['mis_resueltos'] ?? 0 }}
            ],
            backgroundColor: [
                'rgba(220, 53, 69, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(23, 162, 184, 0.8)',
                'rgba(40, 167, 69, 0.8)'
            ],
            borderWidth: 2
        }]
    };

    var ctxMisTickets = document.getElementById('misTicketsStateChart').getContext('2d');
    var misTicketsStateChart = new Chart(ctxMisTickets, {
        type: 'doughnut',
        data: misTicketsStateData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // 3. Gráfico de Líneas - Tendencia Semanal
    var tendenciaData = {
        labels: {!! json_encode($tendenciaSemanal['labels'] ?? ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom']) !!},
        datasets: [{
            label: 'Tickets Creados',
            data: {!! json_encode($tendenciaSemanal['creados'] ?? [2, 5, 3, 8, 6, 4, 3]) !!},
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            fill: true,
            tension: 0.4
        }, {
            label: 'Tickets Resueltos',
            data: {!! json_encode($tendenciaSemanal['resueltos'] ?? [1, 4, 2, 6, 7, 3, 5]) !!},
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            fill: true,
            tension: 0.4
        }]
    };

    var ctxTendencia = document.getElementById('tendenciaChart').getContext('2d');
    var tendenciaChart = new Chart(ctxTendencia, {
        type: 'line',
        data: tendenciaData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    // 4. Gráfico de Tarta - Estados Generales
    var ticketStateChartData = {
        labels: ['Abiertos', 'En Progreso', 'Esperando', 'Resueltos', 'Cerrados'],
        datasets: [{
            data: [
                {{ $estadisticas['abiertos'] ?? 0 }},
                {{ $estadisticas['en_progreso'] ?? 0 }},
                {{ $estadisticas['esperando'] ?? 0 }},
                {{ $estadisticas['resueltos'] ?? 0 }},
                {{ $estadisticas['cerrados'] ?? 0 }}
            ],
            backgroundColor: [
                'rgba(220, 53, 69, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(23, 162, 184, 0.8)',
                'rgba(40, 167, 69, 0.8)',
                'rgba(108, 117, 125, 0.8)'
            ]
        }]
    };

    var ctxPieChart = document.getElementById('ticketStateChart').getContext('2d');
    var ticketStateChart = new Chart(ctxPieChart, {
        type: 'pie',
        data: ticketStateChartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12
                    }
                }
            }
        }
    });

    // 5. Gráfico de Barras Horizontales - Prioridades
    var prioridadData = {
        labels: ['Alta', 'Media', 'Baja', 'Crítica'],
        datasets: [{
            label: 'Tickets por Prioridad',
            data: [
                {{ $estadisticasPrioridad['alta'] ?? 0 }},
                {{ $estadisticasPrioridad['media'] ?? 0 }},
                {{ $estadisticasPrioridad['baja'] ?? 0 }},
                {{ $estadisticasPrioridad['critica'] ?? 0 }}
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)'
            ]
        }]
    };

    var ctxPrioridad = document.getElementById('prioridadChart').getContext('2d');
    var prioridadChart = new Chart(ctxPrioridad, {
        type: 'horizontalBar',
        data: prioridadData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // 6. Gráfico de Área - Resolución Mensual
    var resolucionMensualData = {
        labels: {!! json_encode($resolucionMensual['labels'] ?? ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun']) !!},
        datasets: [{
            label: 'Tickets Resueltos',
            data: {!! json_encode($resolucionMensual['data'] ?? [12, 19, 15, 25, 22, 18]) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.3)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    };

    var ctxResolucion = document.getElementById('resolucionMensualChart').getContext('2d');
    var resolucionMensualChart = new Chart(ctxResolucion, {
        type: 'line',
        data: resolucionMensualData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Función para asignar ticket
    function asignarTicket(ticketId) {
        if (confirm('¿Estás seguro de que quieres tomar este ticket?')) {
            // Aquí implementarías la lógica AJAX para asignar el ticket
            fetch(`/tickets/${ticketId}/asignar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al asignar el ticket');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al asignar el ticket');
            });
        }
    }

    // Actualizar gráficos cada 30 segundos
    setInterval(function() {
        // Aquí puedes implementar la actualización automática de datos
        // location.reload(); // Para una actualización simple
    }, 30000);
</script>
@endpush

@push('styles')
<style>
    .card {
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border: none;
        border-radius: 10px;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    canvas {
        max-height: 400px;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .text-muted {
        color: #6c757d !important;
    }
</style>
@endpush