@extends('adminlte::page')

@section('title', 'Reporte de Corte de Caja')

@section('content_header')

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Reporte de Corte de Caja</h1>
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

            <table id="entradas" class="table table-striped">
                <thead>
                    <tr>
                        <th>Total General</th>
                        <th>Total Efectivo a Entregar</th>
                        <th>Formas de pago</th>
                        <th>Otras Ventas</th>
                        <th>Vendedor</th>
                        <th>Fecha</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>


    <!-- Modal (debe estar en tu HTML) -->
    <div class="modal fade" id="formasPagoModal" tabindex="-1" role="dialog" aria-labelledby="formasPagoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formasPagoModalLabel">Detalle de Formas de Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- El contenido se insertará aquí dinámicamente -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para movimientos de caja -->
    <div class="modal fade" id="movimientosCajaModal" tabindex="-1" role="dialog"
        aria-labelledby="movimientosCajaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="movimientosCajaModalLabel">Movimientos de Caja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- El contenido se insertará aquí dinámicamente -->
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
                url: '/generarreportecortecaja', // Ruta al controlador de Laravel
                type: 'GET',
                // data: datosFormulario, // Enviar los datos del formulario
                data: datosFormulario,

                success: function(response) {
                    Swal.fire(
                        '¡Gracias por esperar!',
                        response.message,
                        'success'
                    );

                    $('#entradas').DataTable({
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
                        "data": response.cortecaja,
                        "columns": [{
                                "data": "total_general"
                            },
                            {
                                "data": "total_efectivo_entregar"
                            },
                            {
                                "data": "formas_pago",
                                "render": function(data, type, row) {
                                    // Convertir el objeto a string JSON y escapar comillas
                                    const jsonData = JSON.stringify(data)
                                        .replace(/"/g, '&quot;')
                                        .replace(/'/g, "\\'");

                                    return `<button onclick="verformapago('${jsonData}')" class="btn btn-primary btn-sm">Ver</button>`;
                                }
                            },
                            {
                                "data": "inputs_adicionales",
                                "render": function(data, type, row) {
                                    // Convertir el objeto a string JSON y escapar comillas
                                    const jsonData = JSON.stringify(data)
                                        .replace(/"/g, '&quot;')
                                        .replace(/'/g, "\\'");

                                    return `<button onclick="verMovimientosCaja('${jsonData}')" class="btn btn-primary btn-sm">Ver</button>`;
                                }
                            },
                            {
                                "data": "vendedor"
                            },
                            {
                                "data": "fecha"
                            },

                            {
                                "data": "observaciones"
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


        function parseNestedJson(nestedJsonString) {
            try {
                // Paso 1: Eliminar comillas exteriores sobrantes
                const cleanJsonString = nestedJsonString.trim().replace(/^"+|"+$/g, '');

                // Paso 2: Convertir a objeto JavaScript
                const parsedData = JSON.parse(cleanJsonString);

                return parsedData;
            } catch (error) {
                console.error('Error al parsear JSON anidado:', error);
                return null;
            }
        }


        function verformapago(data) {

            jsonObject = parseNestedJson(data);
            // Obtener referencia al modal (asumiendo que ya existe en tu HTML)
            const modal = $('#formasPagoModal');

            // Limpiar contenido previo
            modal.find('.modal-body').empty();

            // Construir el contenido HTML
            let html = '<div class="table-responsive">';

            // Procesar cada forma de pago
            jsonObject.forEach(pago => {
                html += `
      <h5 class="mt-3">Forma de Pago: <strong>${pago.forma_pago}</strong></h5>
      <table class="table table-bordered table-striped">
        <thead class="thead-light">
          <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>`;

                // Agregar cada remisión
                pago.remisiones.forEach(remision => {
                    html += `
        <tr>
          <td>${remision.id}</td>
          <td>${remision.fecha}</td>
          <td>${remision.cliente}</td>
          <td>${remision.vendedor}</td>
          <td class="text-right">$${remision.total.toFixed(2)}</td>
        </tr>`;
                });

                // Agregar total
                html += `
        <tr class="table-info">
          <td colspan="4" class="text-right"><strong>Total ${pago.forma_pago}:</strong></td>
          <td class="text-right"><strong>$${pago.total.toFixed(2)}</strong></td>
        </tr>
      </tbody>
      </table>`;
            });

            html += '</div>';

            // Insertar HTML en el modal
            modal.find('.modal-body').html(html);

            // Mostrar el modal
            modal.modal('show');
        }

        function verMovimientosCaja(data) {
            // Parsear el JSON si viene como string
            const jsonObject = typeof data === 'string' ? parseNestedJson(data) : data;

            // Obtener referencia al modal (asumiendo que ya existe en tu HTML)
            const modal = $('#movimientosCajaModal');

            // Limpiar contenido previo
            modal.find('.modal-body').empty();

            val = todosArraysVacios(jsonObject);
            if (val) {
                modal.find('.modal-body').html('<p>No hay movimientos de caja para mostrar.</p>');
                modal.modal('show');
                return;
            }

            // Construir el contenido HTML
            let html = `
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                        <tr>
                            <th>Tipo de Movimiento</th>
                            <th class="text-right">Monto</th>
                            <th>Descripción</th>
                        </tr>
                        </thead>
                    <tbody>`;

            // Procesar cada tipo de movimiento
            Object.entries(jsonObject).forEach(([tipo, datos]) => {
                // Verificar si hay datos para este tipo (array no vacío)
                if (datos.length > 0) {
                    const [monto, descripcion] = datos;

                    // Formatear el nombre del movimiento para mostrarlo más legible
                    const nombreMovimiento = tipo.split('-').map(word =>
                        word.charAt(0).toUpperCase() + word.slice(1)
                    ).join(' ');

                    html += `
                <tr>
                    <td>${nombreMovimiento}</td>
                    <td class="text-right">$${monto.toFixed(2)}</td>
                    <td>${descripcion}</td>
                </tr>`;
                }
            });

            html += `

                        </tbody>
                    </table>
                </div>`;

            // Insertar HTML en el modal
            modal.find('.modal-body').html(html);

            // Mostrar el modal
            modal.modal('show');
        }


        function todosArraysVacios(jsonData) {
            return jsonData && typeof jsonData === 'object' && !Array.isArray(jsonData) ?
                Object.values(jsonData).every(item => Array.isArray(item) && item.length === 0) :
                false;
        }
    </script>
@stop
