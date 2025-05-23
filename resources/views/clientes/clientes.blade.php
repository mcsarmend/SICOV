@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')

@stop

@section('content')
    <div class="card">

        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title" style ="font-size: 2rem">Clientes</h1>
                </div>
                <div class="card-body">
                    <table id=clientes class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Sucursal</th>
                                <th>Precio</th>
                                <th>Direcciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="direccion" tabindex="-1" role="dialog" aria-labelledby="direccionCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-width " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="direccionLongTitle">Detalle de direccion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="direcciontabla" class="table">
                        <thead>
                            <tr>
                                <th>Direccion</th>
                                <th>Latitud</th>
                                <th>Longitud</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

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
                        "data": "nombre"
                    },
                    {
                        "data": "telefono"
                    },
                    {
                        "data": "sucursal"
                    },
                    {
                        "data": "precio"
                    },
                    {
                        "data": "direccion1",
                        "render": function(data, type, row) {
                            return '<button onclick="ver(' + row.id +
                                ')" class="btn btn-info">Ver</button>';
                        }
                    },

                ]
            });
            drawTriangles();
       //     showUsersSections();
        });

        function ver(id) {
            $('#direccion').modal('show');


            $.ajax({
                url: 'verdireccioncliente', // URL a la que se hace la solicitud
                type: 'GET', // Tipo de solicitud (GET, POST, etc.)
                data: {
                    id: id
                },

                dataType: 'json', // Tipo de datos esperados en la respuesta
                success: function(data) {
                    $('#direcciontabla').DataTable({
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
                        "data": data.direccion,
                        "columns": [{
                                "data": "direccion",
                                "width": "300px"
                            },
                            {
                                "data": "latitud"
                            },
                            {
                                "data": "longitud"
                            }
                        ]
                    });
                }
            });
        }
    </script>
@stop
