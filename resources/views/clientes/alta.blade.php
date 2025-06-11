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
                                <th>Gimnasio</th>
                                <th>Alberca</th>
                                <th>Observaciones</th>
                                <th>Paquete Alberca</th>
                                <th>Creado por</th>
                                <th>Crear Cliente</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="clienteNuevo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Convertir Preregistro en Cliente</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="clientForm">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="preregistro_id" name="preregistro_id" value="">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre completo*</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono">Teléfono*</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control" name="tipo_acceso" id="tipo_acceso">
                                        <option value="1">Interno</option>
                                        <option value="0">Externo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Servicios*</label>
                                    <div class="form-check">
                                        <input class="form-check-input service-check" type="checkbox" id="gimnasio"
                                            name="servicios[]" value="gimnasio">
                                        <label class="form-check-label" for="gimnasio">Gimnasio</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input service-check" type="checkbox" id="alberca"
                                            name="servicios[]" value="alberca">
                                        <label class="form-check-label" for="alberca">Alberca</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Gimnasio -->
                        <div id="gimnasioSection" style="display: none;">
                            <div class="card mt-3">
                                <div class="card-header bg-info">
                                    <h4 class="card-title">Datos Adicionales </h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="observaciones">Observaciones</label>
                                        <input type="text" class="form-control" id="observaciones" name="observaciones">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Alberca -->
                        <!-- Sección Alberca -->
                        <div id="albercaSection" style="display: none;">
                            <div class="card mt-3">
                                <div class="card-header bg-info">
                                    <h4 class="card-title">Paquetes de Alberca (Por semana)</h4>
                                </div>
                                <div class="card-body">
                                    <div id="soloAlbercaPackages" style="display: none;">
                                        <div class="form-group">
                                            <label for="soloAlbercaSelect">Paquete Solo Alberca</label>
                                            <select class="form-control" id="soloAlbercaSelect" name="paquete_alberca">

                                                <option value="1_clases_638">4 clases ($638)</option>
                                                <option value="2_clases_951">8 clases ($951)</option>
                                                <option value="3_clases_1270">12 clases ($1,270)</option>
                                                <option value="4_clases_1501">16 clases ($1,501)</option>
                                                <option value="5_clases_1749">20 clases ($638)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="comboPackages" style="display: none;">
                                        <div class="form-group">
                                            <label for="comboSelect">Paquete Combo (Gimnasio + Alberca)</label>
                                            <select class="form-control" id="comboSelect" name="paquete_alberca">

                                                <option value="1_clase_1050">1 clase ($1,050)</option>
                                                <option value="2_clases_1350">2 clases ($1,350)</option>
                                                <option value="3_clases_1350">3 clases ($1,350)</option>
                                                <option value="4_clases_1650">4 clases ($1,650)</option>
                                                <option value="5_clases_1950">5 clases ($1,950)</option>
                                                <option value="6_clases_2250">6 clases ($2,250)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Selección de horarios -->
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <h5>Horarios Disponibles para Alberca*</h5>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input horario-option" type="radio"
                                                                name="horario_alberca" id="horario15" value="15-16">
                                                            <label class="form-check-label" for="horario15">15:00 -
                                                                16:00</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input horario-option" type="radio"
                                                                name="horario_alberca" id="horario16" value="16-17">
                                                            <label class="form-check-label" for="horario16">16:00 -
                                                                17:00</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input horario-option" type="radio"
                                                                name="horario_alberca" id="horario17" value="17-18">
                                                            <label class="form-check-label" for="horario17">17:00 -
                                                                18:00</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input horario-option" type="radio"
                                                                name="horario_alberca" id="horario18" value="18-19">
                                                            <label class="form-check-label" for="horario18">18:00 -
                                                                19:00</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input horario-option" type="radio"
                                                                name="horario_alberca" id="horario19" value="19-20">
                                                            <label class="form-check-label" for="horario19">19:00 -
                                                                20:00</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                            </div>
                        </div>
                    </form>
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
            var clientes = @json($preregistration);

            // Función para manejar el envío del formulario
            $('#clientForm').submit(function(e) {
                e.preventDefault();

                // Mostrar confirmación antes de enviar
                Swal.fire({
                    title: '¿Confirmar envío?',
                    text: "¿Estás seguro de que deseas guardar este cliente?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        enviarFormulario();
                    }
                });
            });

            function enviarFormulario() {
                // Mostrar loader mientras se procesa
                Swal.fire({
                    title: 'Procesando',
                    html: 'Por favor espera mientras guardamos la información...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Obtener datos del formulario
                let datos = $('#clientForm').serialize();

                $.ajax({
                    url: 'crearcliente',
                    type: 'POST',
                    data: datos,
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

            // Inicializar DataTable
            $('#clientes').DataTable({
                data: clientes,
                columns: [{
                        data: 'nombre'
                    },
                    {
                        data: 'telefono'
                    },
                    {
                        data: 'gimnasio'
                    },
                    {
                        data: 'alberca'
                    },
                    {
                        data: 'observaciones'
                    },
                    {
                        data: 'paquete_alberca'
                    },
                    {
                        data: 'creado_por'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return '<button onclick="crearCliente(' + data +
                                ')" class="btn btn-info">Crear Cliente</button>';
                        }
                    }
                ],
                language: {
                    url: "{{ asset('js/datatables/lang/Spanish.json') }}"
                },
                responsive: true,
                dom: 'Blfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print'],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'Todos']
                ]
            });

            // Manejar cambio en checkboxes de servicios
            $('.service-check').change(function() {
                updateSections();
            });

            // Función para crear cliente



        });


        function updateSections() {
            var gimnasioChecked = $('#gimnasio').is(':checked');
            var albercaChecked = $('#alberca').is(':checked');

            // Mostrar/ocultar secciones
            $('#gimnasioSection').toggle(gimnasioChecked || albercaChecked);
            $('#albercaSection').toggle(albercaChecked);

            // Mostrar paquetes adecuados
            if (gimnasioChecked && albercaChecked) {
                $('#soloAlbercaPackages').hide();
                $('#comboPackages').show();
            } else if (albercaChecked) {
                $('#soloAlbercaPackages').show();
                $('#comboPackages').hide();
            }

            // Actualizar campos requeridos
            $('#observaciones').prop('required', gimnasioChecked || albercaChecked);
            $('input[name="horario_alberca"]').prop('required', albercaChecked);
        }

        function crearCliente(id) {
            // Resetear el formulario primero
            $('#clientForm')[0].reset();
            $('#gimnasioSection, #albercaSection').hide();
            $('#soloAlbercaPackages, #comboPackages').hide();
            $('#preregistro_id').val(id);

            // Mostrar el modal
            $('#clienteNuevo').modal('show');

            // Mostrar loader en los campos principales
            $('#nombre, #telefono').val('Cargando...');
            $('#gimnasio, #alberca').prop('disabled', true);

            $.ajax({
                url: '/infopreregistro',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        const cliente = response.data;

                        // Llenar campos básicos
                        $('#preregistro_id').val(cliente.id);
                        $('#nombre').val(cliente.nombre || '');
                        $('#telefono').val(cliente.telefono || '');

                        // Llenar checkboxes de servicios
                        if (cliente.gimnasio) {
                            $('#gimnasio').prop('checked', true);
                        }
                        if (cliente.alberca) {
                            $('#alberca').prop('checked', true);
                        }

                        // Actualizar secciones visibles
                        updateSections();

                        // Llenar observaciones
                        $('#observaciones').val(cliente.observaciones || '');

                        // Seleccionar paquete de alberca si existe
                        if (cliente.paquete_alberca && cliente.paquete_alberca !== 'Sin paquete') {
                            // Determinar qué select mostrar
                            const soloAlbercaValues = [
                                '1_clases_638',
                                '2_clases_951',
                                '3_clases_1270',
                                '4_clases_1501',
                                '5_clases_1749'
                            ];

                            const comboValues = [
                                '1_clase_1050',
                                '2_clases_1350',
                                '3_clases_1350',
                                '4_clases_1650',
                                '5_clases_1950',
                                '6_clases_2250'
                            ];

                            if (soloAlbercaValues.includes(cliente.paquete_alberca)) {
                                $('#soloAlbercaSelect').val(cliente.paquete_alberca);
                                $('#soloAlbercaPackages').show();
                                $('#comboPackages').hide();
                            } else if (comboValues.includes(cliente.paquete_alberca)) {
                                $('#comboSelect').val(cliente.paquete_alberca);
                                $('#comboPackages').show();
                                $('#soloAlbercaPackages').hide();
                            }
                        }

                        // Seleccionar horario si existe
                        if (cliente.horario_alberca && cliente.horario_alberca !== 'Sin horario') {
                            $(`input[name="horario_alberca"][value="${cliente.horario_alberca}"]`)
                                .prop(
                                    'checked', true);
                        }

                        // Habilitar campos
                        $('#gimnasio, #alberca').prop('disabled', false);
                    } else {
                        alert('Error: ' + response.message);
                        $('#clienteNuevo').modal('hide');
                    }
                },
                error: function(xhr) {
                    alert('Error al cargar los datos del cliente');
                    $('#clienteNuevo').modal('hide');
                }
            });
        }
    </script>

@stop
