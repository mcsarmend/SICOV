@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')

@stop

@section('content')
    <div class="card">

        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title" style ="font-size: 2rem">ALTA DE CLIENTES</h1>
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
                                            <h5>Horarios</h5>
                                            <div class="form-group">
                                                <select class="form-control" id="horario_alberca" name="horario_alberca"
                                                    required>
                                                    <option value="">Seleccione un horario</option>
                                                    <option value="1">06:00 - 07:00</option>
                                                    <option value="2">07:00 - 08:00</option>
                                                    <option value="3">08:00 - 09:00</option>
                                                    <option value="4">15:00 - 16:00</option>
                                                    <option value="5">16:00 - 17:00</option>
                                                    <option value="6">17:00 - 18:00</option>
                                                    <option value="7">18:00 - 19:00</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fecha inicio -->
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="fecha">Fecha de inicio:</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" id="fecha"
                                                        name="fecha">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Días de agenda -->
                                    <div class="form-group">
                                        <label class="d-block">Seleccione días:</label>
                                        <div class="d-flex flex-wrap">
                                            <div class="pr-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="lunes"
                                                        name="dias[]" value="1">
                                                    <label class="form-check-label" for="lunes">Lunes</label>
                                                </div>
                                            </div>
                                            <div class="pr-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="martes"
                                                        name="dias[]" value="2">
                                                    <label class="form-check-label" for="martes">Martes</label>
                                                </div>
                                            </div>
                                            <div class="pr-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="miercoles"
                                                        name="dias[]" value="3">
                                                    <label class="form-check-label" for="miercoles">Miércoles</label>
                                                </div>
                                            </div>
                                            <div class="pr-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="jueves"
                                                        name="dias[]" value="4">
                                                    <label class="form-check-label" for="jueves">Jueves</label>
                                                </div>
                                            </div>
                                            <div class="pr-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="viernes"
                                                        name="dias[]" value="5">
                                                    <label class="form-check-label" for="viernes">Viernes</label>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="sabado"
                                                        name="dias[]" value="6">
                                                    <label class="form-check-label" for="sabado">Sábado</label>
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js">
    </script>
    <script>
        $(document).ready(function() {
            $('head').append('<style>.error-border { border: 2px solid #dc3545 !important; }</style>');
            $('#fecha').datepicker({
                format: 'dd/mm/yyyy',
                language: 'es',
                autoclose: true,
                todayHighlight: true
            });
            drawTriangles();
            var clientes = @json($preregistration);

            // Función para validar la selección de días

            // Función para validar horarios vs días seleccionados









            // Función para manejar el envío del formulario
            $('#clientForm').submit(function(e) {
                e.preventDefault();

                if ($('#alberca').is(':checked')) {
                    const esValidoDias = validarDias();
                    const esValidoHorario = validarHorarioVsDias();

                    if (!esValidoDias) {
                        mostrarErrorDias(true);
                        $('input[name="dias[]"]').addClass('error-border');

                        $('html, body').animate({
                            scrollTop: $('#errorDias').offset().top - 100
                        }, 500);

                        Swal.fire({
                            title: 'Error de validación',
                            text: 'El número de días seleccionados debe coincidir con el número de clases del paquete',
                            icon: 'error',
                            confirmButtonText: 'Entendido'
                        });
                        return;
                    }

                    if (!esValidoHorario) {
                        mostrarErrorHorario(true);

                        $('html, body').animate({
                            scrollTop: $('#errorHorario').offset().top - 100
                        }, 500);

                        Swal.fire({
                            title: 'Error de validación',
                            text: 'Los sábados solo están disponibles los horarios de 6:00 a 9:00',
                            icon: 'error',
                            confirmButtonText: 'Entendido'
                        });
                        return;
                    }
                }

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
                Swal.fire({
                    title: 'Procesando',
                    html: 'Por favor espera mientras guardamos la información...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

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

                        });

                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);

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

            // Validar cuando cambia la selección de días
            $(document).on('change', 'input[name="dias[]"]', function() {
                ejecutarValidacionesCompletas();
            });

            // Validar cuando cambia el horario
            $(document).on('change', '#horario_alberca', function() {
                ejecutarValidacionesCompletas();
            });

            // Validar cuando cambia el paquete seleccionado
            $(document).on('change', '#soloAlbercaSelect, #comboSelect', function() {
                ejecutarValidacionesCompletas();
            });

            // Vincular eventos cuando el modal se muestra
            $('#clienteNuevo').on('shown.bs.modal', function() {
                // Ejecutar validaciones después de que el modal esté completamente visible
                setTimeout(function() {
                    ejecutarValidacionesCompletas();
                }, 300);
            });

            // Limpiar cuando el modal se cierra
            $('#clienteNuevo').on('hidden.bs.modal', function() {
                $('#errorDias, #errorHorario, #infoPaquete').remove();
                $('input[name="dias[]"]').removeClass('error-border');
                $('#horario_alberca').removeClass('error-border');
                $('#horario_alberca').find('option').prop('disabled', false);
            });

            $('#alberca').change(function() {
                if ($(this).is(':checked')) {
                    $('#horario_alberca').prop('required', true);
                } else {
                    $('#horario_alberca').prop('required', false);
                }
            });

        });
        // Mostrar información del paquete al usuario
        function actualizarInfoPaquete() {
            const paqueteSelect = $('#soloAlbercaSelect').is(':visible') ?
                $('#soloAlbercaSelect') : $('#comboSelect');

            const paqueteValue = paqueteSelect.val();

            if (paqueteValue) {
                const numeroClases = parseInt(paqueteValue.split('_')[0]);

                if ($('#infoPaquete').length === 0) {
                    $('.form-group:has(input[name="dias[]"])').after(
                        '<div id="infoPaquete" class="text-info mt-2" style="font-size: 14px; font-weight: bold;"></div>'
                    );
                }

                $('#infoPaquete').text(
                    `Paquete seleccionado: ${numeroClases} clase(s) - Seleccione ${numeroClases} día(s)`);
            } else {
                $('#infoPaquete').remove();
            }
        }

        // Función para ejecutar todas las validaciones
        function ejecutarValidacionesCompletas() {
            const esValidoDias = validarDias();
            const esValidoHorario = validarHorarioVsDias();

            mostrarErrorDias(!esValidoDias);
            mostrarErrorHorario(!esValidoHorario);
            actualizarOpcionesHorario();
            actualizarInfoPaquete();

            if (!esValidoDias) {
                $('input[name="dias[]"]').addClass('error-border');
            } else {
                $('input[name="dias[]"]').removeClass('error-border');
            }
        }

        // Función para actualizar opciones de horario según días seleccionados
        function actualizarOpcionesHorario() {
            const sabadoSeleccionado = $('#sabado').is(':checked');
            const selectHorario = $('#horario_alberca');
            const horarioActual = selectHorario.val();

            if (sabadoSeleccionado) {
                selectHorario.find('option').each(function() {
                    const valor = $(this).val();
                    const horariosPermitidos = ['06-07', '07-08', '08-09'];

                    if (valor && !horariosPermitidos.includes(valor)) {
                        $(this).prop('disabled', true);
                        if (valor === horarioActual) {
                            selectHorario.val('');
                        }
                    } else if (valor) {
                        $(this).prop('disabled', false);
                    }
                });
            } else {
                selectHorario.find('option').prop('disabled', false);
            }
        }
        // Función para mostrar/ocultar mensaje de error de horario
        function mostrarErrorHorario(mostrar) {
            if (mostrar) {
                if ($('#errorHorario').length === 0) {
                    $('#horario_alberca').closest('.form-group').append(
                        '<div id="errorHorario" class="text-danger mt-2" style="font-size: 14px;">' +
                        'Los sábados solo están disponibles los horarios de 6:00 a 9:00' +
                        '</div>'
                    );
                    $('#horario_alberca').addClass('error-border');
                }
            } else {
                $('#errorHorario').remove();
                $('#horario_alberca').removeClass('error-border');
            }
        }
        // Función para mostrar/ocultar mensaje de error
        function mostrarErrorDias(mostrar) {
            if (mostrar) {
                if ($('#errorDias').length === 0) {
                    $('.form-group:has(input[name="dias[]"])').after(
                        '<div id="errorDias" class="text-danger mt-2" style="font-size: 14px;">' +
                        'El número de días seleccionados debe coincidir con el número de clases del paquete' +
                        '</div>'
                    );
                }
            } else {
                $('#errorDias').remove();
            }
        }

        function validarHorarioVsDias() {
            const sabadoSeleccionado = $('#sabado').is(':checked');
            const horarioSeleccionado = $('#horario_alberca').val();

            if (sabadoSeleccionado && horarioSeleccionado) {
                const horariosPermitidosSabado = ['06-07', '07-08', '08-09'];
                if (!horariosPermitidosSabado.includes(horarioSeleccionado)) {
                    return false;
                }
            }

            return true;
        }

        function validarDias() {
            const paqueteSelect = $('#soloAlbercaSelect').is(':visible') ?
                $('#soloAlbercaSelect') : $('#comboSelect');

            const paqueteValue = paqueteSelect.val();

            if (!paqueteValue) return true;

            const numeroClases = parseInt(paqueteValue.split('_')[0]);
            const diasSeleccionados = $('input[name="dias[]"]:checked').length;

            return diasSeleccionados === numeroClases;
        }

        function updateSections() {
            var gimnasioChecked = $('#gimnasio').is(':checked');
            var albercaChecked = $('#alberca').is(':checked');

            $('#gimnasioSection').toggle(gimnasioChecked || albercaChecked);
            $('#albercaSection').toggle(albercaChecked);

            if (gimnasioChecked && albercaChecked) {
                // Mostrar combo
                $('#soloAlbercaPackages').hide();
                $('#soloAlbercaSelect').prop('disabled', true);

                $('#comboPackages').show();
                $('#comboSelect').prop('disabled', false);
            } else if (albercaChecked) {
                // Mostrar solo-alberca
                $('#comboPackages').hide();
                $('#comboSelect').prop('disabled', true);

                $('#soloAlbercaPackages').show();
                $('#soloAlbercaSelect').prop('disabled', false);
            } else {
                // Ninguno
                $('#soloAlbercaPackages, #comboPackages').hide();
                $('#soloAlbercaSelect, #comboSelect').prop('disabled', true);
            }

            $('#observaciones').prop('required', gimnasioChecked || albercaChecked);
            $('#horario_alberca').prop('required', albercaChecked);

            setTimeout(function() {
                ejecutarValidacionesCompletas();
            }, 50);
        }


        function crearCliente(id) {
            $('#clientForm')[0].reset();
            $('#gimnasioSection, #albercaSection').hide();
            $('#soloAlbercaPackages, #comboPackages').hide();
            $('#preregistro_id').val(id);

            $('#errorDias, #errorHorario, #infoPaquete').remove();
            $('input[name="dias[]"]').removeClass('error-border');
            $('#horario_alberca').removeClass('error-border');
            $('#horario_alberca').find('option').prop('disabled', false);

            $('#clienteNuevo').modal('show');

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

                        $('#preregistro_id').val(cliente.id);
                        $('#nombre').val(cliente.nombre || '');
                        $('#telefono').val(cliente.telefono || '');

                        if (cliente.gimnasio) {
                            $('#gimnasio').prop('checked', true);
                        }
                        if (cliente.alberca) {
                            $('#alberca').prop('checked', true);
                        }

                        updateSections();

                        $('#observaciones').val(cliente.observaciones || '');

                        if (cliente.paquete_alberca && cliente.paquete_alberca !== 'Sin paquete') {
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

                                $('#comboPackages').hide();
                                $('#comboSelect').prop('disabled', true);

                                $('#soloAlbercaPackages').show();
                                $('#soloAlbercaSelect').prop('disabled', false);

                            } else if (comboValues.includes(cliente.paquete_alberca)) {
                                $('#comboSelect').val(cliente.paquete_alberca);
                                $('#comboPackages').show();
                                $('#soloAlbercaPackages').hide();

                                // Ninguno
                                $('#soloAlbercaPackages, #comboPackages').hide();
                                $('#soloAlbercaSelect, #comboSelect').prop('disabled', true);
                            }
                        }

                        if (cliente.horario_alberca && cliente.horario_alberca !== 'Sin horario') {
                            $('#horario_alberca').val(cliente.horario_alberca);
                        }

                        // Seleccionar días si existen en los datos
                        if (cliente.dias_seleccionados) {
                            cliente.dias_seleccionados.forEach(dia => {
                                $(`input[name="dias[]"][value="${dia}"]`).prop('checked', true);
                            });
                        }

                        $('#gimnasio, #alberca').prop('disabled', false);

                        // EJECUTAR VALIDACIONES DESPUÉS DE CARGAR TODOS LOS DATOS
                        setTimeout(function() {
                            ejecutarValidacionesCompletas();
                        }, 200);

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

        // Función global para ejecutar validaciones (accesible desde fuera)
        function ejecutarValidacionesCompletas() {
            const esValidoDias = validarDias();
            const esValidoHorario = validarHorarioVsDias();

            mostrarErrorDias(!esValidoDias);
            mostrarErrorHorario(!esValidoHorario);
            actualizarOpcionesHorario();
            actualizarInfoPaquete();

            if (!esValidoDias) {
                $('input[name="dias[]"]').addClass('error-border');
            } else {
                $('input[name="dias[]"]').removeClass('error-border');
            }
        }
    </script>

@stop
