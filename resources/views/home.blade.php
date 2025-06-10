@extends('adminlte::page')

@section('title', 'Registro de Asistencia')

@section('content_header')
@stop

@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h1>Registro de Asistencia</h1>
        </div>
        <div class="card-body" style="width: 100%">
            <!-- Fecha actual -->
            <div class="text-center mb-4">
                <h2 id="current-date" style="font-size: 2rem; font-weight: bold;"></h2>
            </div>

            <!-- Formulario de registro -->

            <div class="col-md-6">
                <label for="clienteInput">Buscar Cliente:</label>
                <input type="text" id="clienteInput" class="form-control" placeholder="Escriba el nombre del cliente...">
                <input type="hidden" id="clienteId" name="idcliente">
            </div>




            <br><br><br>

            <!-- Tabla de asistencias -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Número de Cliente</th>
                            <th>Hora de Registro</th>
                            <th>Tiempo Transcurrido</th>
                            <th>Clases Restantes</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->client->name }}</td>
                                <td>{{ $attendance->client->client_number }}</td>
                                <td>{{ $attendance->created_at->format('H:i:s') }}</td>
                                <td>
                                    <span class="time-counter" data-time="{{ $attendance->created_at }}">
                                        {{ now()->diffInMinutes($attendance->created_at) }} minutos
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $package = $attendance->client->current_package;
                                        $classes_taken = $attendance->client->attendancesThisMonth()->count();

                                        if (str_contains($package, '_clases_')) {
                                            $total_classes = explode('_', $package)[0];
                                            $remaining = $total_classes - $classes_taken;
                                            echo $remaining >= 0 ? $remaining : '0';
                                        } else {
                                            echo 'N/A';
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        $minutes_elapsed = now()->diffInMinutes($attendance->created_at);
                                        $status_class = '';

                                        if ($minutes_elapsed < 105) {
                                            $status_class = 'bg-success';
                                        } elseif ($minutes_elapsed >= 105 && $minutes_elapsed < 115) {
                                            $status_class = 'bg-warning';
                                        } else {
                                            $status_class = 'bg-danger';
                                        }
                                    @endphp
                                    <span class="badge {{ $status_class }} text-white">
                                        @if ($minutes_elapsed < 105)
                                            Activo
                                        @elseif($minutes_elapsed >= 105 && $minutes_elapsed < 115)
                                            Por expirar
                                        @else
                                            Expirado
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('fondo')
@stop

@section('css')
    <style>
        #current-date {
            color: #2c3e50;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-selection {
            height: 38px !important;
            padding-top: 5px !important;
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5em 0.75em;
        }

        .table th {
            background-color: #343a40;
            color: white;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mostrar fecha actual
            drawTriangles();
            updateCurrentDate();


            updateTimeCounters();
            setInterval(updateTimeCounters, 60000); // Actualizar cada minuto

            // Lista de clientes (nombre + id) generada por Blade
            var clientes = [
                @foreach ($clients as $client)
                    {
                        label: "{{ $client->nombre }} - {{ $client->status == 1 ? 'Activo' : 'Inactivo' }}",
                        value: "{{ $client->nombre }}",
                        id: "{{ $client->id }}"
                    },
                @endforeach
            ];

            // Autocompletar con jQuery UI
            $("#clienteInput").autocomplete({
                source: clientes,
                select: function(event, ui) {
                    // Cuando el usuario selecciona una opción
                    $("#clienteInput").val(ui.item.value); // Mostrar nombre
                    $("#clienteId").val(ui.item.id); // Guardar ID oculto
                    return false;
                }
            });
        });

        function updateCurrentDate() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            $('#current-date').text(now.toLocaleDateString('es-MX', options));
        }

        // Actualizar contadores de tiempo cada minuto
        function updateTimeCounters() {
            $('.time-counter').each(function() {
                const registerTime = new Date($(this).data('time'));
                const now = new Date();
                const diffMs = now - registerTime;
                const diffMins = Math.round(diffMs / 60000);

                $(this).text(diffMins + ' minutos');

                // Actualizar el estado del semáforo
                const row = $(this).closest('tr');
                const statusBadge = row.find('.badge');

                statusBadge.removeClass('bg-success bg-warning bg-danger');

                if (diffMins < 105) {
                    statusBadge.addClass('bg-success').text('Activo');
                } else if (diffMins >= 105 && diffMins < 115) {
                    statusBadge.addClass('bg-warning').text('Por expirar');
                } else {
                    statusBadge.addClass('bg-danger').text('Expirado');
                }
            });
        }
    </script>
@stop
