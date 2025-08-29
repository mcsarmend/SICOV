@extends('adminlte::page')

@section('title', 'Registro de Asistencia GIMNASIO')

@section('content_header')
@stop

@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h1>Registro de Asistencia/Salida GIMNASIO</h1>
        </div>
        <div class="card-body" style="width: 100%">
            <!-- Fecha actual -->
            <div class="text-center mb-4">
                <h2 id="current-date" style="font-size: 2rem; font-weight: bold;"></h2>
            </div>


            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="clienteInput">Buscar Cliente:</label>
                        <div class="input-group">
                            <input type="text" id="clienteInput" class="form-control"
                                placeholder="Escriba el nombre del cliente...">
                            <input type="hidden" id="clienteId" name="idcliente">
                            <input type="hidden" id="clienteNombre" name="nombrecliente">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="invisible">.</label>
                        <button class="btn btn-secondary btn-block" id="actualizarTabla">Actualizar Tabla</button>
                    </div>
                </div>
            </div>

            <br><br><br>

            <!-- Tabla de asistencias -->

            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-bordered table-striped table-sm" id = "atendanceTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Número de Cliente</th>
                            <th>Hora de Registro</th>
                            <th>Clases Restantes</th>
                            <th>Tiempo Transcurrido</th>
                            <th>Salida</th>

                        </tr>
                    </thead>
                    <tbody>


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

        .registrar-salida-btn {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }

        .bg-success-light {
            background-color: rgba(40, 167, 69, 0.2) !important;
        }

        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.2) !important;
        }

        .bg-danger-light {
            background-color: rgba(220, 53, 69, 0.2) !important;
        }

        /* Estilo para la tabla */
        #attendanceTable tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.05) !important;
        }

        /* Estilos para hacer la tabla más compacta */
        #atendanceTable {
            font-size: 1rem;
            /* Reduce el tamaño de fuente */
        }

        #atendanceTable th,
        #atendanceTable td {
            padding: 0.5rem;
            /* Reduce el padding de las celdas */
        }

        #atendanceTable thead th {
            font-size: 0.9rem;
            /* Tamaño de fuente para encabezados */
        }

        /* Ajusta el tamaño de los botones */
        .registrar-salida-btn {
            font-size: 0.75rem;
            padding: 0.2rem 0.4rem;
        }

        /* Reduce el tamaño de los badges */
        .badge {
            font-size: 0.75rem;
            padding: 0.3em 0.6em;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.js">
    </script>


    <script>
        $(document).ready(function() {
            // Mostrar fecha actual
            drawTriangles();

            var attendance = @json($attendances);


            $('#atendanceTable').DataTable({
                data: attendance,
                "language": {
                    "url": "{{ asset('js/datatables/lang/Spanish.json') }}"
                },

                destroy: true,
                processing: true,
                sort: true,
                paging: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ],
                pageLength: 50,
                dom: '<"top"f>rt<"bottom"lip><"clear">', // Diseño más compacto
                responsive: true,
                columns: [{
                        data: 'nombre',
                        title: 'Nombre',
                        width: '10%'
                    },
                    {
                        data: null,
                        render: (data) => `#${data.id || 'N/A'}`,
                        title: 'Número de Cliente',
                        width: '10%'
                    },
                    {
                        data: 'check_in',
                        render: function(data) {
                            const date = new Date(data);
                            return date.toLocaleTimeString();
                        },
                        title: 'Hora de Registro',
                        width: '10%'
                    },
                    {
                        data: 'classes_remaining',
                        title: 'Clases Restantes',
                        width: '10%'
                    },
                    {
                        data: 'check_in',
                        render: function(data, type, row) {
                            return formatTimeElapsed(data, row.check_out);
                        },
                        title: 'Tiempo Transcurrido',
                        width: '10%'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            if (!row.check_out) {
                                return `<button class="btn btn-sm btn-warning registrar-salida-btn registrar-salida-btn"
                    data-attendance-id="${row.id}"
                    data-client-name="${row.nombre}">
                    Registrar Salida</button>`;
                            } else {
                                return `<span class="badge badge-success">Salida: ${new Date(row.check_out).toLocaleTimeString()}</span>`;
                            }
                        },
                        title: 'Salida',
                        width: '10%'
                    }
                ],
                createdRow: function(row, data, dataIndex) {

                    var tipo = parseInt(@json($tipo));

                    if (data.check_out) return; // No aplicar estilos si ya tiene salida

                    const checkIn = new Date(data.check_in);
                    const now = new Date();
                    diffMinutes = Math.floor((now - checkIn) / 1000 / 60);


                    if (diffMinutes < 105) {
                        $(row).addClass('bg-success-light');
                    } else if (diffMinutes >= 105 && diffMinutes < 115) {
                        $(row).addClass('bg-warning-light');
                    } else {
                        $(row).addClass('bg-danger-light');
                    }



                }
            });


            function actualizarTabla() {
                $.ajax({
                    url: '/actualizarasistencias', // Ruta donde devuelves los datos (AJAX JSON)
                    method: 'POST',
                    data: {
                        // Gimnasio
                        type: 2
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        const table = $('#atendanceTable').DataTable();
                        table.clear().rows.add(response).draw();
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo actualizar la tabla'
                        });
                    }
                });
            }

            $('#actualizarTabla').on('click', function() {
                actualizarTabla();
            });
        });

        function formatTimeElapsed(checkIn, checkOut = null) {
            const checkInDate = new Date(checkIn);
            const endDate = checkOut ? new Date(checkOut) : new Date();
            const diffMs = endDate - checkInDate;

            const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
            const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));

            return `${diffHours}h ${diffMinutes}m`;
        }

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

        $("#clienteInput").autocomplete({
            source: clientes,
            select: function(event, ui) {
                $("#clienteInput").val(ui.item.value); // nombre
                $("#clienteId").val(ui.item.id); // id
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<div>" + item.id + " - " + item.value + "</div>")
                .appendTo(ul);
        };

        // Detectar cuando el usuario escribe un número (ID)
        $("#clienteInput").on("change", function() {
            let valor = $(this).val().trim();

            // Verificar si es número
            if ($.isNumeric(valor)) {
                // Buscar en la lista de clientes
                let cliente = clientes.find(c => c.id == valor);

                if (cliente) {
                    registrarAsistencia(cliente.id, cliente.value);
                } else {
                    Swal.fire({
                        title: "No encontrado",
                        text: "No existe un cliente con ese ID",
                        icon: "error"
                    });
                }
            }
        });

        // Registrar salida desde los botones de la tabla
        $(document).on('click', '.registrar-salida-btn', function() {
            client_id = $(this).data('attendance-id');
            const clientName = $(this).data('client-name');

            Swal.fire({
                title: '¿Confirmar salida?',
                html: `¿Deseas registrar la salida de <strong>${clientName}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, registrar salida',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    registrarSalida(client_id);
                }
            });
        });


        function registrarSalida(client_id) {
            // Enviar la solicitud AJAX
            $.ajax({
                url: '/registrarsalida',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    client_id: client_id,
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Salida registrada correctamente',
                        }).then(() => {
                            location.reload(); // Recargar la página para ver los cambios
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Error al registrar salida',
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Error en el servidor',
                    });
                }
            });
        }



        function registrarAsistencia(clienteId, clienteNombre) {




            // Mostrar confirmación con SweetAlert
            Swal.fire({
                title: '¿Confirmar registro?',
                html: `¿Deseas registrar la asistencia de <strong>${clienteNombre}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, registrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar la solicitud AJAX si se confirma
                    $.ajax({
                        url: '/registrarasistencia',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            client_id: clienteId,
                            type: 2
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'Asistencia registrada correctamente',
                                }).then(() => {
                                    location
                                        .reload(); // Recargar la página para ver los cambios
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message ||
                                        'Error al registrar asistencia',
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message ||
                                    'Error en el servidor',
                            });
                        }
                    });
                }
            });
        }
    </script>
@stop
