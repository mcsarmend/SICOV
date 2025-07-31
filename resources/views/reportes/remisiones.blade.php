@extends('adminlte::page')

@section('title', 'Reportes Ventas')

@section('content_header')

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Reportes de Remisiones</h1>
        </div>
        <div class="card-body">
            <form id="reporte">
                <div class="row">
                    <div class="col">
                        <label for="date-start"></label>
                        <input type="date" name= "dateStart" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="date-end"></label>
                        <input type="date" name= "dateEnd" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for=""></label>
                        <button type="submit" class="btn btn-primary form-control">Generar Reporte</button>
                    </div>


                </div>
                <br>


            </form>

            <table id="remisiones" class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Nota</th>
                        <th>Forma de pago</th>
                        <th>Almacen</th>
                        <th>Vendedor</th>
                        <th>Productos</th>
                        <th>Total</th>
                        <th>Estatus</th>
                        <th>Imprimir</th>
                        <th>Cancelar</th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>


    <div class="modal fade" id="productos" tabindex="-1" role="dialog" aria-labelledby="productosCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-width " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productosLongTitle">Detalle de productos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="productostabla" class="table">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Cantidad</th>
                                <th>Nombre</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
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

@stop

@section('js')
    <script>
        $(document).ready(function() {
            drawTriangles();
            showUsersSections();
        });

        $('#reporte').submit(function(e) {
            e.preventDefault(); // Evitar la recarga de la página

            // Obtener los datos del formulario
            var datosFormulario = $(this).serialize();

            // Realizar la solicitud AJAX con jQuery
            $.ajax({
                url: '/generarreporteremisiones', // Ruta al controlador de Laravel
                type: 'GET',
                // data: datosFormulario, // Enviar los datos del formulario
                data: datosFormulario,

                success: function(response) {
                    Swal.fire(
                        '¡Gracias por esperar!',
                        response.message,
                        'success'
                    );

                    $('#remisiones').DataTable({
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
                        "data": response.remisiones,
                        "columns": [{
                                "data": "id"
                            },
                            {
                                "data": "fecha"
                            },
                            {
                                "data": "cliente"
                            },
                            {
                                "data": "nota"
                            },
                            {
                                "data": "forma_pago"
                            },
                            {
                                "data": "almacen"
                            },
                            {
                                "data": "vendedor"
                            },
                            {
                                "data": "productos",
                                "render": function(data, type, row) {
                                    return '<button onclick="ver(' + row.id +
                                        ')" class="btn btn-primary">Ver</button>';
                                }
                            },
                            {
                                "data": "total"
                            },
                            {
                                "data": "estatus"
                            },
                            {
                                "data": "imprimir",
                                "render": function(data, type, row) {
                                    return '<button onclick="imprimir(' + JSON
                                        .stringify(row).replace(/"/g,
                                            "'") +
                                        ')" class="btn btn-primary">Imprimir</button>';
                                }
                            },
                            {
                                "data": "cancelar",
                                "render": function(data, type, row) {

                                    if (row.estatus == "cancelada") {
                                        return '-';
                                    } else {

                                        return '<button onclick="cancelar_remision(' +
                                            row.id +
                                            ')" class="btn btn-danger">Cancelar</button>';
                                    }

                                }
                            },


                        ]
                    });
                },
                error: function(response) {
                    Swal.fire(
                        '¡Gracias por esperar!',
                        "Existe un error: " + response.message,
                        'error'
                    )
                }
            });
        });

        function ver(id) {
            $('#productos').modal('show');


            $.ajax({
                url: 'verproductosremision', // URL a la que se hace la solicitud
                type: 'GET', // Tipo de solicitud (GET, POST, etc.)
                data: {
                    id: id
                },

                dataType: 'json', // Tipo de datos esperados en la respuesta
                success: function(data) {
                    $('#productostabla').DataTable({
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
                                "data": "Codigo"
                            },
                            {
                                "data": "Cantidad"
                            },
                            {
                                "data": "Nombre"
                            },
                            {
                                "data": "Precio Unitario"
                            },
                            {
                                "data": "Subtotal"
                            },
                        ]
                    });
                }
            });
        }
    </script>
@stop
