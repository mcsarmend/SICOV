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
                                <th>Numero</th>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Gimnasio</th>
                                <th>Alberca</th>
                                <th>Observaciones</th>
                                <th>Paquete Alberca</th>
                                <th>Horario Alberca</th>
                                <th>Fecha de Creacion</th>
                                <th>Estado</th>
                                <th>Historial de pagos</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>




    <div class="modal fade" id="historialpagos" tabindex="-1" role="dialog" aria-labelledby="historialpagosCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-width " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historialpagosLongTitle">Detalle de Historial de Pagos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="historialpagostabla" class="table">
                        <thead>
                            <tr>
                                <th># de pago</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Concepto</th>
                                <th>Estado</th>
                                <th>Mes correspondiente</th>
                                <th>Metodo de Pago</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

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
                        "data": "telefono"
                    },
                    {
                        "data": "gimnasio"
                    },
                    {
                        "data": "alberca"
                    },
                    {
                        "data": "observaciones"
                    },
                    {
                        "data": "paquete_alberca"
                    },
                    {
                        "data": "horario_alberca"
                    },
                    {
                        "data": "fecha_creacion"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            return '<button onclick="ver(' + row.id +
                                ')" class="btn btn-primary">Ver</button>';
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
                        "columns": [
                            {
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
    </script>
@stop
