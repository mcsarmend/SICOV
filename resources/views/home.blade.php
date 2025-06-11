@extends('adminlte::page')

@section('title', 'Registro de Asistencia')

@section('content_header')
@stop

@section('content')
    <br>
    <div class="card">
        <div class="card-header ">
            <h1 class="text-black"><i class="fas fa-door-open mr-2"></i>Sistema Integral de Gestión de Asistencias y Comercio</h1>
        </div>
        <div class="card-body" style="width: 100%">
            <div class="row">
                <!-- Columna izquierda -->
                <div class="col-md-6">
                    <div class="info-box bg-gradient-success">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Clientes Registrados</span>
                            <span class="info-box-number">{{ $totalClientes }} / {{ $metaClientes }} </span>
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ ($totalClientes / $metaClientes) * 100 }}%"></div>
                            </div>
                            <span class="progress-description">
                                {{ number_format(($totalClientes / $metaClientes) * 100, 0) }}% de la meta anual
                            </span>
                        </div>
                    </div>

                    <div class="card card-widget widget-user-2">
                        <div class="widget-user-header bg-info">
                            <h3 class="widget-user-username">Asistencias Hoy</h3>
                            <h5 class="widget-user-desc">{{ $asistenciasHoy }} registros</h5>
                        </div>

                    </div>
                </div>

                <!-- Columna derecha -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>Estadísticas Rápidas</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="small-box bg-gradient-indigo">
                                        <div class="inner">
                                            <h3>{{ $clientesActivos }}</h3>
                                            <p>Clientes Activos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                        <a href="{{ route('clientes.index') }}" class="small-box-footer">
                                            Más info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>

                            <div class="alert alert-info mt-3">
                                <h5><i class="icon fas fa-bullhorn"></i> Noticias Recientes</h5>
                                <ul>
                                    <li>Nuevo horario de clases los viernes</li>
                                    <li>Promoción especial para renovaciones</li>
                                    <li>Sistema actualizado el {{ now()->format('d/m/Y') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    @include('fondo')
@stop

@section('css')
    <style>
        .info-box {
            cursor: pointer;
            transition: all 0.3s;
        }

        .info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .small-box {
            transition: all 0.3s;
        }

        .small-box:hover {
            transform: scale(1.03);
        }

        .products-list .product-img {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-title {
            font-weight: 600;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {

            drawTriangles();
            // Mostrar fecha actual
            $('#current-date').text(new Date().toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }));

            // Actualizar cada minuto (opcional)
            setInterval(function() {
                $('#current-date').text(new Date().toLocaleDateString('es-ES', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }));
            }, 60000);
        });
    </script>
@stop
