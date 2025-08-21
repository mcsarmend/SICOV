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
                    },{
                        "data": "idcliente"
                    },{
                        "data": "nombre"
                    },
                    {
                        "data": "descripcion"
                    },
                    {
                        "data": "fecha_sesion"
                    },
                    {
                        "data": "id_agenda",
                        "render": function(data, type, row) {
                            return '<button onclick="reagendar(' + row.id +
                                ')" class="btn btn-danger">Reagendar</button>';
                        }
                    },


                ]
            });

            drawTriangles();
            //    showUsersSections();
        });

        function reagendar(id) {
            Swal.fire({
                title: 'Selecciona la nueva fecha',
                html: `<input type="date" id="nuevaFecha" class="swal2-input">`,
                confirmButtonText: 'Guardar',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const fecha = document.getElementById('nuevaFecha').value;
                    if (!fecha) {
                        Swal.showValidationMessage('Debes seleccionar una fecha');
                    }
                    return fecha;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const nuevaFecha = result.value;

                    Swal.fire({
                        title: 'Procesando',
                        html: 'Por favor espera mientras guardamos la información...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $.ajax({
                        url: 'reagendarcliente', // Cambia a la ruta que maneja la actualización
                        type: 'POST',
                        data: {
                            id: id,
                            fecha: nuevaFecha
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: '¡Éxito!',
                                text: response.message,
                                icon: 'success',
                                timer: 3000,
                                timerProgressBar: true,
                                willClose: () => {
                                    window.location.reload();
                                }
                            });
                        },
                        error: function(xhr) {
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.error ?
                                xhr.responseJSON.error :
                                'Ocurrió un error al procesar la solicitud';

                            Swal.fire({
                                title: 'Error',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'Entendido'
                            });
                        }
                    });
                }
            });
        }
    </script>
@stop
