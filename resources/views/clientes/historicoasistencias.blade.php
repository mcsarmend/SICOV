@extends('adminlte::page')

@section('title', 'Historico Asistencias')

@section('content_header')

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Baja Cliente</h1>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title" style ="font-size: 2rem">Eliminar cliente</h1>
                </div>
                <div class="card-body">
                    <table id=clientes class="table">
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
            clientes = @json($clients);
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


            drawTriangles();
            //    showUsersSections();
        });

        function eliminar(id) {
            // Mostrar loader mientras se procesa
            Swal.fire({
                title: 'Procesando',
                html: 'Por favor espera mientras guardamos la información...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            data = {
                id: id
            }
            $.ajax({
                url: 'eliminarcliente',
                type: 'POST',
                data: data,
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


       </script>
@stop
