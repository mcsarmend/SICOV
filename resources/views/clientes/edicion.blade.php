@extends('adminlte::page')

@section('title', 'Edición Cliente')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title" style="font-size: 2rem">Editar cliente</h1>
                </div>
                <div class="card-body">
                    <form id="editar">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="usuario">Cliente:</label>
                            </div>
                            <div class="col">
                                <select name="id" id="id_actualizar" class="form-control">
                                    @foreach ($clients as $client)
                                        <option value="{{ encrypt($client->id) }}">{{ $client->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="nombre">Nuevo nombre:</label>
                            </div>
                            <div class="col">
                                <input type="text" id="nombre" name="nombre" class="form-control">
                                <br>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="telefono">Nuevo Teléfono:</label>
                            </div>
                            <div class="col">
                                <input type="text" id="telefono" name="telefono" class="form-control">
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="telefono">Tipo Cliente:</label>
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
                                                <option value="4_clases_638">4 clases ($638)</option>
                                                <option value="8_clases_951">8 clases ($951)</option>
                                                <option value="12_clases_1270">12 clases ($1,270)</option>
                                                <option value="16_clases_1501">16 clases ($1,501)</option>
                                                <option value="20_clases_638">20 clases ($638)</option>
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

                        <div class="row">
                            <div class="col">
                                <input type="submit" value="Actualizar" class="btn btn-primary">
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
@stop

@section('js')
    <script>
        $(document).ready(function() {
            drawTriangles();
            // Manejar cambio en checkboxes de servicios
            $('.service-check').change(function() {
                updateSections();
            });

            $('#editar').submit(function(e) {
                e.preventDefault();

                var datosFormulario = $(this).serialize();

                $.ajax({
                    url: '/editarcliente',
                    type: 'POST',
                    data: datosFormulario,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire(
                            '¡Éxito!',
                            response.message,
                            'success'
                        );
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    },
                    error: function(response) {
                        Swal.fire(
                            'Error',
                            "Existe un error: " + response.responseJSON.message,
                            'error'
                        );
                    }
                });
            });
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
    </script>
@stop
