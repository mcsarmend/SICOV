@extends('adminlte::page')

@section('title', 'Registro de Pagos')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Registro de Pagos</h1>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title" style="font-size: 2rem">Formulario</h1>
                </div>
                <div class="card-body">
                    <h2>Tablas de Precios</h2>
                    <div class="container">
                        <div class="row">
                            <!-- Primera columna -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h3 class="card-title">Gimnasio</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Internos</th>
                                                    <th>Externos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Inscripción</td>
                                                    <td>$256</td>
                                                    <td>$319</td>
                                                </tr>
                                                <tr>
                                                    <td>Reinscripción</td>
                                                    <td>$220</td>
                                                    <td>$275</td>
                                                </tr>
                                                <tr>
                                                    <td>Mensualidad</td>
                                                    <td>$385</td>
                                                    <td>$440</td>
                                                </tr>
                                                <tr>
                                                    <td>Recargos</td>
                                                    <td>$38</td>
                                                    <td>$44</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h3 class="card-title">Gimnasio + Alberca</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                                <tr>

                                                    <th>Paquete</th>
                                                    <th>Costo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1 clase por semana</td>
                                                    <td>$1050</td>
                                                </tr>
                                                <tr>
                                                    <td>2 clase por semana</td>
                                                    <td>$1350</td>
                                                </tr>
                                                <tr>
                                                    <td>3 clase por semana</td>
                                                    <td>$1650</td>
                                                </tr>
                                                <tr>
                                                    <td>4 clase por semana</td>
                                                    <td>$1950</td>
                                                </tr>
                                                <tr>
                                                    <td>5 clase por semana</td>
                                                    <td>$2250</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Segunda columna -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-success text-white">
                                        <h3 class="card-title">Solo Alberca</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Internos</th>
                                                    <th>Externos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Inscripción</td>
                                                    <td>$583</td>
                                                    <td>$726</td>
                                                </tr>
                                                <tr>
                                                    <td>Reinscripcion</td>
                                                    <td>$528</td>
                                                    <td>$660</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header bg-warning text-dark">
                                        <h3 class="card-title">Sólo Alberca</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Paquete</th>
                                                    <th>Costo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1 clase por semana</td>
                                                    <td>$638</td>
                                                </tr>
                                                <tr>
                                                    <td>2 clase por semana</td>
                                                    <td>$951</td>
                                                </tr>
                                                <tr>
                                                    <td>3 clase por semana</td>
                                                    <td>$1270</td>
                                                </tr>
                                                <tr>
                                                    <td>4 clase por semana</td>
                                                    <td>$1507</td>
                                                </tr>
                                                <tr>
                                                    <td>5 clase por semana</td>
                                                    <td>$1749</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <form id="formPago">
                        @csrf
                        <!-- Buscador de Clientes -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="buscarCliente">Buscar Cliente:</label>
                                <select class="form-control select2" id="buscarCliente" name="idcliente" required>
                                    <option value="">Seleccione un cliente</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" data-tipo="{{ $client->tipo }}"
                                            data-gimnasio="{{ $client->gimnasio }}" data-alberca="{{ $client->alberca }}"
                                            data-paquete="{{ $client->paquete_alberca ?? '' }}">
                                            {{ $client->nombre }} -
                                            {{ $client->status == 1 ? 'Activo' : 'Inactivo' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Tipo de Acceso:</label>
                                <input type="text" id="tipoAcceso" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Información de Servicios -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Gimnasio:</label>
                                <input type="text" id="gimnasioStatus" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Alberca:</label>
                                <input type="text" id="albercaStatus" class="form-control" readonly>
                            </div>
                            <div class="col-md-4" id="paqueteAlbercaContainer" style="display: none;">
                                <label>Paquete Alberca:</label>
                                <input type="text" id="paqueteAlberca" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Información del Pago -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="monto">Monto:</label>
                                <input type="number" step="0.01" class="form-control" id="monto" name="monto"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label for="concepto">Concepto:</label>
                                <select class="form-control" id="concepto" name="concepto" required>
                                    <option value="">Seleccione...</option>
                                    <option value="inscripcion">Inscripción</option>
                                    <option value="reinscripcion">Reinscripción</option>
                                    <option value="mensualidad">Mensualidad</option>
                                    <option value="recargos">Recargos</option>
                                    <option value="condonacion">Condonación</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="fecha_pago">Fecha de Pago:</label>
                                <input type="date" class="form-control" id="fecha_pago" name="fecha_pago"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <!-- Método de Pago y Observaciones -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="metodo_pago">Método de Pago:</label>
                                <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                                    <option value="">Seleccione...</option>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="terminal">Terminal</option>
                                    <option value="transferencia">Transferencia</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="mes_correspondiente">Mes correspondiente:</label>
                                <select class="form-control" id="mes_correspondiente" name="mes_correspondiente"
                                    required>
                                    <option value="enero">Enero</option>
                                    <option value="febrero">Febrero</option>
                                    <option value="marzo">Marzo</option>
                                    <option value="abril">Abril</option>
                                    <option value="mayo">Mayo</option>
                                    <option value="junio">Junio</option>
                                    <option value="julio">Julio</option>
                                    <option value="agosto">Agosto</option>
                                    <option value="septiembre">Septiembre</option>
                                    <option value="octubre">Octubre</option>
                                    <option value="noviembre">Noviembre</option>
                                    <option value="diciembre">Diciembre</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="observaciones">Observaciones:</label>
                                <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Registrar Pago</button>
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
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding-top: 5px;
        }
    </style>
@stop

@section('js')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            drawTriangles();

            // Inicializar Select2 para el buscador de clientes
            $('#buscarCliente').select2({
                placeholder: "Buscar cliente...",
                allowClear: true
            });

            // Actualizar campos cuando seleccionan un cliente
            $('#buscarCliente').change(function() {
                var selectedOption = $(this).find(':selected');
                var tipo = selectedOption.data('tipo');
                var gimnasio = selectedOption.data('gimnasio');
                var alberca = selectedOption.data('alberca');
                var paquete = selectedOption.data('paquete');

                $('#tipoAcceso').val(tipo == 1 ? 'Interno' : 'Externo');
                $('#gimnasioStatus').val(gimnasio == 1 ? 'Activo' : 'Inactivo');
                $('#albercaStatus').val(alberca == 1 ? 'Activo' : 'Inactivo');

                // Mostrar u ocultar paquete de alberca
                if (alberca == 1) {
                    $('#paqueteAlbercaContainer').show();
                    $('#paqueteAlberca').val(paquete);
                } else {
                    $('#paqueteAlbercaContainer').hide();
                    $('#paqueteAlberca').val('');
                }
            });

            // Manejar el envío del formulario
            $('#formPago').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '/registrarpago',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire('Éxito', 'Pago registrado correctamente', 'success');
                        $('#formPago')[0].reset();
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Ocurrió un error al registrar el pago', 'error');
                    }
                });
            });
        });
    </script>
@stop
