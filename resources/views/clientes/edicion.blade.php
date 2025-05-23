@extends('adminlte::page')

@section('title', 'Edición Cliente')

@section('content_header')

@stop

@section('content')
    <div class="card">

        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title" style ="font-size: 2rem">Editar cliente</h1>
                </div>
                <div class="card-body">
                    @if ($type == 4)
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
                                    <label for="sucursal">Sucursal:</label>
                                </div>
                                <div class="col">
                                    <select name="id_sucursal" id="id_sucursal" class="form-control">
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{ encrypt($sucursal->id) }}">{{ $sucursal->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col">
                                    <label for="telefono">Telefono:</label>
                                </div>
                                <div class="col">
                                    <input type="text" id="telefono" name="telefono" class="form-control">
                                    <br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">

                                    <div class="form-group">
                                        <label for="direccion">Dirección:</label>
                                        <input type="text" id="direccion" name="direccion" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-info mt-2" id="buscar-maps">Buscar en
                                                Maps</button>
                                        </div>
                                    </div>
                                    <br>

                                </div>
                                <div class="col">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="latitud">Latitud:</label>
                                            <input type="text" id="latitud" name="latitud" class="form-control"
                                                readonly>
                                        </div>
                                    </div>

                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="longitud">Longitud:</label>
                                        <input type="text" id="longitud" name="longitud" class="form-control" readonly>
                                    </div>

                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkSegundaDireccion">
                                    <label class="form-check-label" for="checkSegundaDireccion">
                                        ¿Agregar segunda dirección?
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">

                                    <div id="segundaDireccion" style="display: none;">
                                        <div class="form-group">
                                            <label for="direccion2">Segunda Dirección:</label>
                                            <input type="text" id="direccion2" name="direccion2" class="form-control">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-info mt-2" id="buscar-maps2">Buscar en
                                                    Maps</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col" id="segundalatitud" style="display: none;">

                                    <div class="form-group">
                                        <label for="latitud2">Latitud 2:</label>
                                        <input type="text" id="latitud2" name="latitud2" class="form-control" readonly>
                                    </div>

                                </div>
                                <div class="col" id="segundalongitud" style="display: none;">
                                    <div class="form-group">
                                        <label for="longitud2">Longitud:</label>
                                        <input type="text" id="longitud2" name="longitud2" class="form-control"
                                            readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="submit" value="Actualizar" class="btn btn-primary">
                                </div>
                            </div>


                        </form>
                    @else
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

                            <div class="row">
                                <div class="col">
                                    <label for="price">Precio:</label>
                                </div>
                                <div class="col">
                                    <select name="id_price" id="id_price" class="form-control">
                                        @foreach ($prices as $price)
                                            <option value="{{ encrypt($price->id) }}">{{ $price->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <label for="sucursal">Sucursal:</label>
                                </div>
                                <div class="col">
                                    <select name="id_sucursal" id="id_sucursal" class="form-control">
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{ encrypt($sucursal->id) }}">{{ $sucursal->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col">
                                    <label for="telefono">Telefono:</label>
                                </div>
                                <div class="col">
                                    <input type="text" id="telefono" name="telefono" class="form-control">
                                    <br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">

                                    <div class="form-group">
                                        <label for="direccion">Dirección:</label>
                                        <input type="text" id="direccion" name="direccion" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-info mt-2" id="buscar-maps">Buscar en
                                                Maps</button>
                                        </div>
                                    </div>
                                    <br>

                                </div>
                                <div class="col">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="latitud">Latitud:</label>
                                            <input type="text" id="latitud" name="latitud" class="form-control"
                                                readonly>
                                        </div>
                                    </div>

                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="longitud">Longitud:</label>
                                        <input type="text" id="longitud" name="longitud" class="form-control"
                                            readonly>
                                    </div>

                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkSegundaDireccion">
                                    <label class="form-check-label" for="checkSegundaDireccion">
                                        ¿Agregar segunda dirección?
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">

                                    <div id="segundaDireccion" style="display: none;">
                                        <div class="form-group">
                                            <label for="direccion2">Segunda Dirección:</label>
                                            <input type="text" id="direccion2" name="direccion2"
                                                class="form-control">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-info mt-2" id="buscar-maps2">Buscar
                                                    en
                                                    Maps</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col" id="segundalatitud" style="display: none;">

                                    <div class="form-group">
                                        <label for="latitud2">Latitud 2:</label>
                                        <input type="text" id="latitud2" name="latitud2" class="form-control"
                                            readonly>
                                    </div>

                                </div>
                                <div class="col" id="segundalongitud" style="display: none;">
                                    <div class="form-group">
                                        <label for="longitud2">Longitud:</label>
                                        <input type="text" id="longitud2" name="longitud2" class="form-control"
                                            readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="submit" value="Actualizar" class="btn btn-primary">
                                </div>
                            </div>


                        </form>
                    @endif

                </div>
            </div>
        </div>

    </div>
    @include('fondo')
@stop

@section('css')

@stop

@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBl0IgYJqu-RST8MQ_iIPjHWWcazxsO0KA&libraries=places">
    </script>
    <script>
        document.getElementById('checkSegundaDireccion').addEventListener('change', function() {
            var segundaDireccion = document.getElementById('segundaDireccion');
            segundaDireccion.style.display = this.checked ? 'block' : 'none';
            var segundalatitude = document.getElementById('segundalatitud');
            segundalatitud.style.display = this.checked ? 'block' : 'none'

            var segundalongitud = document.getElementById('segundalongitud');
            segundalongitud.style.display = this.checked ? 'block' : 'none'
        });
        $(document).ready(function() {
            drawTriangles();
            showUsersSections();
            initAutocomplete('direccion');
            initAutocomplete('direccion2');

            $('#buscar-maps').on('click', function() {
                Swal.fire({
                    title: 'Buscar en Google Maps',
                    html: '<div id="map" style="height: 400px;"></div>',
                    width: '800px',
                    didOpen: () => {
                        initMap('direccion');
                    },
                    preConfirm: () => {
                        var center = map.getCenter();
                        var lat = center.lat();
                        var lng = center.lng();
                        $('#latitud').val(lat);
                        $('#longitud').val(lng);
                        return direccion;
                    }
                });
            });
            $('#buscar-maps2').on('click', function() {
                Swal.fire({
                    title: 'Buscar en Google Maps',
                    html: '<div id="map" style="height: 400px;"></div>',
                    width: '800px',
                    didOpen: () => {
                        initMap('direccion2');
                    },
                    preConfirm: () => {
                        var center = map.getCenter();
                        var lat = center.lat();
                        var lng = center.lng();
                        $('#latitud2').val(lat);
                        $('#longitud2').val(lng);
                        return direccion;
                    }
                });
            });
        });


        $('#editar').submit(function(e) {
            e.preventDefault(); // Evitar la recarga de la página

            // Obtener los datos del formulario
            var datosFormulario = $(this).serialize();

            // Realizar la solicitud AJAX con jQuery
            $.ajax({
                url: '/editarcliente', // Ruta al controlador de Laravel
                type: 'POST',
                // data: datosFormulario, // Enviar los datos del formulario
                data: datosFormulario,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire(
                        '¡Gracias por esperar!',
                        response.message,
                        'success'
                    );
                    setTimeout(function() {
                        window.location.reload();
                    }, 3000);

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

        function initAutocomplete(direction) {
            const input = document.getElementById(direction);
            const options = {
                types: ['address'],
                componentRestrictions: {
                    country: 'mx'
                }
            };

            const autocomplete = new google.maps.places.Autocomplete(input, options);
            autocomplete.setFields(['address_components', 'formatted_address', 'geometry']);
            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                if (!place.formatted_address || !place.geometry) return;

                const direccion = place.formatted_address;
                input.value = direccion;

                if (place.geometry) {
                    const lat = place.geometry.location.lat();
                    const lng = place.geometry.location.lng();
                    globallat = lat;
                    globallng = lng;
                }
            });
        }

        function initMap(direction) {


            direccion = $(direction).val();

            if (direccion == '') {
                Swal.fire({
                    title: "¡No haz indicado una direccion!",
                    icon: "info"
                });
                return;
            }
            const ubicacion = {
                lat: globallat,
                lng: globallng
            };

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: ubicacion
            });

            marker = new google.maps.Marker({
                position: ubicacion,
                map: map,
                draggable: true,
                title: 'Ubicación'
            });




            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                const latLng = event.latLng;

            });
        }
    </script>
@stop
