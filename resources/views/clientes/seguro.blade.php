@extends('adminlte::page')

@section('title', 'Seguro')

@section('content_header')

@stop

@section('content')
    <div class="card">

        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title" style ="font-size: 2rem">Seguro</h1>
                </div>
                <div class="card-body">
                    <table id=clientes class="table">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Nombre</th>
                                <th>idSeguro</th>
                                <th>Estado</th>
                                <th>Modificar Seguro</th>
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
    <style>
        .modal-dialog.custom-width {
            max-width: 55%;
            /* Ajusta este valor según tus necesidades */
        }

        #direcciontabla th:first-child,
        #direcciontabla td:first-child {
            min-width: 300px;
            /* Ajusta este valor según tus necesidades */
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            drawTriangles();
            var clientes = @json($clients);
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
                pageLength: 50,
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
                        "data": "id"
                    },
                    {
                        "data": "nombre"
                    },
                    {
                        "data": "idseguro"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            return '<button onclick="modificarSeguro(' + row.id +
                                ')" class="btn btn-primary">Modificar Seguro</button>';
                        }
                    },


                ]
            });
            drawTriangles();
            //     showUsersSections();
        });

        function ver(id) {
            $('#historialpagos').modal('show');
            $.ajax({
                url: 'consultarpagos', // URL a la que se hace la solicitud
                type: 'GET', // Tipo de solicitud (GET, POST, etc.)
                data: {
                    id: id
                },

                dataType: 'json', // Tipo de datos esperados en la respuesta
                success: function(data) {
                    $('#historialpagostabla').DataTable({
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
                        "data": data.productos,
                        "columns": [{
                                "data": "id"
                            },
                            {
                                "data": "fecha_pago"
                            },
                            {
                                "data": "monto"
                            },
                            {
                                "data": "concepto"
                            },
                            {
                                "data": "estatus"
                            },
                            {
                                "data": "mes_correspondiente"
                            },
                            {
                                "data": "metodo_pago"
                            },
                            {
                                "data": "observaciones"
                            },
                        ]
                    });
                }
            });
        }


        function modificarSeguro(clienteId) {
            Swal.fire({
                title: 'Modificar Seguro',
                input: 'text', // Puedes cambiar a 'number' si solo son IDs
                inputLabel: 'Ingrese el nuevo ID del seguro',
                inputPlaceholder: 'Ej: 123',
                showCancelButton: true,
                confirmButtonText: 'Actualizar',
                cancelButtonText: 'Cancelar',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Debes ingresar un valor!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let nuevoSeguro = result.value;

                    $.ajax({
                        url: '/actualizarseguro', // Tu ruta POST en Laravel
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            cliente_id: clienteId,
                            idseguro: nuevoSeguro
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Actualizado',
                                    text: response.message
                                });
                                setTimeout(function() {
                                    window.location.reload();
                                }, 3000);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo actualizar el seguro: ' + error
                            });
                        }
                    });
                }
            });
        }
    </script>
@stop
