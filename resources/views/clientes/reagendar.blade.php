@extends('adminlte::page')

@section('title', 'Reagendar')

@section('content_header')

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Reagendar</h1>
        </div>
        <div class="card-body">
            <div class="card">

                <div class="card-body">
                    <table id=clientes class="table">
                        <thead>
                            <tr>
                                <th>Numero Agenda</th>
                                <th>Numero Cliente</th>
                                <th>Nombre</th>
                                <th>Horario</th>
                                <th>Fecha Sesiones</th>
                                <th>Estatus</th>
                                <th>Reagendada</th>
                                <th>Reagendar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    @include('fondo')
@stop

@section('css')

@stop

@section('js')
    <script>
        $(document).ready(function() {
            clientes = @json($clientes);

            $('#clientes').DataTable({
                destroy: true,
                scrollX: true,
                scrollCollapse: true,
                "language": {
                    "url": "{{ asset('js/datatables/lang/Spanish.json') }}"
                },
                "buttons": [
                    'copy', 'excel', 'pdf', 'print'
                ],
                dom: 'Blfrtip',
                destroy: true,
                processing: true,
                sort: true,
                paging: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ], // Personalizar el menú de longitud de visualización

                // Configurar las opciones de exportación
                // Para PDF
                pdf: {
                    orientation: 'landscape', // Orientación del PDF (landscape o portrait)
                    pageSize: 'A4', // Tamaño del papel del PDF
                    exportOptions: {
                        columns: ':visible' // Exportar solo las columnas visibles
                    }
                },
                // Para Excel
                excel: {
                    exportOptions: {
                        columns: ':visible' // Exportar solo las columnas visibles
                    }
                },
                "data": clientes,
                "columns": [{
                        "data": "id_agenda"
                    }, {
                        "data": "idcliente"
                    }, {
                        "data": "nombre"
                    },
                    {
                        "data": "descripcion"
                    },
                    {
                        "data": "fecha_sesion"
                    },
                    {
                        "data": "estatus"
                    },
                    {
                        "data": "reagendada",
                    },
                    {
                        "data": "id_agenda",
                        "render": function(data, type, row) {
                            if (row.reagendada === 'Sí' || row.estatus === 'REGISTRADA') {
                                return '<button class="btn btn-secondary" disabled>Reagendar</button>';
                            } else {
                                return '<button onclick="reagendar(' + row.id_agenda +
                                    ')" class="btn btn-warning">Reagendar</button>';
                            }
                        }
                    },


                ]
            });

            drawTriangles();
            //    showUsersSections();
        });

        function reagendar(id_agenda) {
            Swal.fire({
                title: 'Reagendar Cliente',
                html: `
            <input type="date" id="fecha_sesion" class="swal2-input" required>

            <select class="swal2-input" id="horario_alberca" name="horario_alberca" required>
                <option value="">Seleccione un horario</option>
                <option value="1">06:00 - 07:00</option>
                <option value="2">07:00 - 08:00</option>
                <option value="3">08:00 - 09:00</option>
                <option value="4">15:00 - 16:00</option>
                <option value="5">16:00 - 17:00</option>
                <option value="6">17:00 - 18:00</option>
                <option value="7">18:00 - 19:00</option>
            </select>
        `,
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    let fecha = document.getElementById('fecha_sesion').value;
                    let horario = document.getElementById('horario_alberca').value;

                    if (!fecha || !horario) {
                        Swal.showValidationMessage('Debes seleccionar fecha y horario');
                        return false;
                    }

                    return {
                        fecha,
                        horario
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let fecha = result.value.fecha;
                    let horario = result.value.horario;

                    // Aquí ya tienes id_agenda, fecha y horario 👇
                    console.log("Cliente:", id_agenda, "Fecha:", fecha, "Horario:", horario);

                    // Ejemplo de petición AJAX
                    $.ajax({
                        url: '/accionreagendar',
                        method: 'POST',
                        data: {
                            id_agenda: id_agenda,
                            fecha_sesion: fecha,
                            horario_alberca: horario,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('¡Reagendado!', 'La cita fue actualizada.', 'success');

                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'No se pudo reagendar.', 'error');
                        }
                    });
                }
            });
        }
    </script>
@stop
