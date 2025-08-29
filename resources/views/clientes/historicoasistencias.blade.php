@extends('adminlte::page')

@section('title', 'Historico Asistencias')

@section('content_header')

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Historico de Asistencias</h1>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">

                    <form id="reporteasistencias">
                        @csrf
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

                    <table id=asistencias class="table">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Nombre</th>
                                <th>Fecha de Asistencia</th>
                                <th>Hora de Entrada</th>
                                <th>Hora de Salida</th>
                                <th>Tipo</th>
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


            $('#reporteasistencias').submit(function(e) {
                e.preventDefault(); // Evitar la recarga de la página

                // Obtener los datos del formulario
                var datosFormulario = $(this).serialize();

                // Realizar la solicitud AJAX con jQuery
                $.ajax({
                    url: '/reportehistoricoasistencias', // Ruta al controlador de Laravel
                    type: 'POST',
                    // data: datosFormulario, // Enviar los datos del formulario
                    data: datosFormulario,

                    success: function(response) {
                        Swal.fire(
                            '¡Gracias por esperar!',
                            response.message,
                            'success'
                        );

                        $('#asistencias').DataTable({
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
                            "data": response.asistencias,
                            "columns": [{
                                    "data": "id"
                                },
                                {
                                    "data": "nombre"
                                },
                                {
                                    "data": "fecha_asistencia"
                                },
                                {
                                    "data": "check_in"
                                },
                                {
                                    "data": "check_out"
                                },
                                {
                                    "data": "type"
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



            drawTriangles();
            //    showUsersSections();
        });

 </script>
@stop
