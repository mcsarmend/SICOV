@extends('adminlte::page')

@section('title', 'Alta de Cliente')

@section('content_header')
    <h1 class="m-0 text-dark">Alta de Cliente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title" style="font-size: 1.5rem">Datos del Cliente</h3>
        </div>
        <div class="card-body">
            <form id="clientForm">
                @csrf
                <div class="row">
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
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Servicios*</label>
                            <div class="form-check">
                                <input class="form-check-input service-check" type="checkbox" id="gimnasio" name="servicios[]" value="gimnasio">
                                <label class="form-check-label" for="gimnasio">Gimnasio</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input service-check" type="checkbox" id="alberca" name="servicios[]" value="alberca">
                                <label class="form-check-label" for="alberca">Alberca</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección Gimnasio -->
                <div id="gimnasioSection" style="display: none;">
                    <div class="card mt-3">
                        <div class="card-header bg-info">
                            <h4 class="card-title">Datos de Gimnasio</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nombreGimnasio">Nombre para membresía*</label>
                                <input type="text" class="form-control" id="nombreGimnasio" name="nombre_gimnasio">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección Alberca -->
                <div id="albercaSection" style="display: none;">
                    <div class="card mt-3">
                        <div class="card-header bg-info">
                            <h4 class="card-title">Paquetes de Alberca</h4>
                        </div>
                        <div class="card-body">
                            <div id="soloAlbercaPackages" class="row">
                                <div class="col-md-4">
                                    <div class="card package-option">
                                        <div class="card-body">
                                            <input type="radio" name="paquete_alberca" id="pkg4" value="4_clases_638" class="form-check-input">
                                            <label for="pkg4" class="form-check-label">4 clases ($638)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card package-option">
                                        <div class="card-body">
                                            <input type="radio" name="paquete_alberca" id="pkg8" value="8_clases_951" class="form-check-input">
                                            <label for="pkg8" class="form-check-label">8 clases ($951)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card package-option">
                                        <div class="card-body">
                                            <input type="radio" name="paquete_alberca" id="pkg12" value="12_clases_1270" class="form-check-input">
                                            <label for="pkg12" class="form-check-label">12 clases ($1,270)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="card package-option">
                                        <div class="card-body">
                                            <input type="radio" name="paquete_alberca" id="pkg16" value="16_clases_1501" class="form-check-input">
                                            <label for="pkg16" class="form-check-label">16 clases ($1,501)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="card package-option">
                                        <div class="card-body">
                                            <input type="radio" name="paquete_alberca" id="pkg20" value="20_clases_638" class="form-check-input">
                                            <label for="pkg20" class="form-check-label">20 clases ($638)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="comboPackages" class="row" style="display: none;">
                                <div class="col-md-4">
                                    <div class="card package-option">
                                        <div class="card-body">
                                            <input type="radio" name="paquete_alberca" id="combo1" value="1_clase_1050" class="form-check-input">
                                            <label for="combo1" class="form-check-label">1 clase ($1,050)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card package-option">
                                        <div class="card-body">
                                            <input type="radio" name="paquete_alberca" id="combo2" value="2_clases_1350" class="form-check-input">
                                            <label for="combo2" class="form-check-label">2 clases ($1,350)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card package-option">
                                        <div class="card-body">
                                            <input type="radio" name="paquete_alberca" id="combo3" value="3_clases_1350" class="form-check-input">
                                            <label for="combo3" class="form-check-label">3 clases ($1,350)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="card package-option">
                                        <div class="card-body">
                                            <input type="radio" name="paquete_alberca" id="combo4" value="4_clases_1650" class="form-check-input">
                                            <label for="combo4" class="form-check-label">4 clases ($1,650)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="card package-option">
                                        <div class="card-body">
                                            <input type="radio" name="paquete_alberca" id="combo5" value="5_clases_1950" class="form-check-input">
                                            <label for="combo5" class="form-check-label">5 clases ($1,950)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="card package-option">
                                        <div class="card-body">
                                            <input type="radio" name="paquete_alberca" id="combo6" value="6_clases_2250" class="form-check-input">
                                            <label for="combo6" class="form-check-label">6 clases ($2,250)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Selección de horarios -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5>Horarios Disponibles para Alberca*</h5>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input horario-option" type="radio" name="horario_alberca" id="horario15" value="15-16" required>
                                                    <label class="form-check-label" for="horario15">15:00 - 16:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input horario-option" type="radio" name="horario_alberca" id="horario16" value="16-17">
                                                    <label class="form-check-label" for="horario16">16:00 - 17:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input horario-option" type="radio" name="horario_alberca" id="horario18" value="18-19">
                                                    <label class="form-check-label" for="horario18">18:00 - 19:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input horario-option" type="radio" name="horario_alberca" id="horario19" value="19-20">
                                                    <label class="form-check-label" for="horario19">19:00 - 20:00</label>
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
@stop

@section('css')
    <style>
        .package-option {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .package-option:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .package-option.selected {
            background-color: #e2f0fd;
            border: 2px solid #0d6efd;
        }
        .form-check-label.selected {
            background-color: #e2f0fd;
            border-radius: 4px;
            padding: 8px;
        }
        .card-header {
            color: white;
            font-weight: bold;
        }
        .form-check-label {
            display: block;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .form-check-label:hover {
            background-color: #f8f9fa;
        }
        #albercaSection .card-header {
            background-color: #17a2b8 !important;
        }
        #gimnasioSection .card-header {
            background-color: #6c757d !important;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Manejar selección de servicios
            $('.service-check').change(function() {
                updateSections();
            });

            // Manejar selección de paquetes
            $('.package-option').click(function() {
                $(this).find('input[type="radio"]').prop('checked', true);
                $('.package-option').removeClass('selected');
                $(this).addClass('selected');
            });

            // Resaltar horario seleccionado
            $('.horario-option').change(function() {
                $('.form-check-label').removeClass('selected');
                if ($(this).is(':checked')) {
                    $(this).next('.form-check-label').addClass('selected');
                }
            });

            function updateSections() {
                var gimnasioChecked = $('#gimnasio').is(':checked');
                var albercaChecked = $('#alberca').is(':checked');

                // Mostrar/ocultar secciones
                $('#gimnasioSection').toggle(gimnasioChecked);
                $('#albercaSection').toggle(albercaChecked);

                // Mostrar paquetes adecuados
                if (gimnasioChecked && albercaChecked) {
                    $('#soloAlbercaPackages').hide();
                    $('#comboPackages').show();
                } else if (albercaChecked) {
                    $('#soloAlbercaPackages').show();
                    $('#comboPackages').hide();
                }

                // Validar campos requeridos
                $('#nombreGimnasio').prop('required', gimnasioChecked && !albercaChecked);
                $('input[name="paquete_alberca"]').prop('required', albercaChecked);
                $('input[name="horario_alberca"]').prop('required', albercaChecked);
            }

            // Manejar envío del formulario
            $('#clientForm').submit(function(e) {
                e.preventDefault();

                // Validar campos requeridos
                if ($('#alberca').is(':checked')) {
                    if (!$('input[name="paquete_alberca"]:checked').val()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Por favor selecciona un paquete para la alberca'
                        });
                        return;
                    }
                    if (!$('input[name="horario_alberca"]:checked').val()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Por favor selecciona un horario para la alberca'
                        });
                        return;
                    }
                }

                Swal.fire({
                    title: '¿Guardar cliente?',
                    text: "¿Estás seguro de que deseas guardar este cliente?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostrar loader
                        Swal.fire({
                            title: 'Procesando',
                            html: 'Guardando información del cliente...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Enviar datos al servidor
                        $.ajax({
                            url: '/',
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'Cliente registrado correctamente',
                                    confirmButtonText: 'Aceptar'
                                }).then(() => {

                                });
                            },
                            error: function(xhr) {
                                let errorMessage = 'Error al guardar el cliente';
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    errorMessage = '';
                                    $.each(xhr.responseJSON.errors, function(key, value) {
                                        errorMessage += value + '\n';
                                    });
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: errorMessage
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop
