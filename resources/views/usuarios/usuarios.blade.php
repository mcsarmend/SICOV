@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')

@stop

@section('content')
    {{--  CREAR USUARIO --}}
    <div class="card">
        <div class="card-header">
            <h1>Cuentas de Usuarios</h1>
            <br><br>
            <h4 class="card-title" style ="font-size: 2rem">Crear usuario</h4>
        </div>
        <div class="card-body">
            <form id="crearusuario">
                @csrf
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="usuario">Nombre usuario:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="usuario" name="usuario" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="telefono">Telefono:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" id="telefono" name="telefono" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tipo">Rol:</label>
                        </div>
                        <div class="col-md-8">
                            <select id="tipo" name="tipo" class="form-control" required>
                                <option value="1">Administrador</option>
                                <option value="2">Facturas</option>
                                <option value="3">Instructor</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="contrasena">Contraseña generada:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="contrasena" name="contrasena" readonly class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="sucursal">Sucursal:</label>
                        </div>
                        <div class="col-md-8">
                            <select name="sucursal" id="sucursal" class="form-control">
                                @foreach ($idssucursales as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>




                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="email">Email:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" value="Crear" class="btn btn-success">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <br>
    {{-- EDITAR USUARIO --}}
    <div class="card">
        <div class="card-header">
            <h1 class="card-title" style ="font-size: 2rem">Editar usuario</h1>
        </div>
        <div class="card-body">
            <form id="actualizarusuario">
                @csrf
                <div class="container">

                    <div class="row">
                        <div class="col">
                            <label for="usuario">Usuario:</label>
                        </div>
                        <div class="col">
                            <select name="id" id="id_actualizar" class="form-control">
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ encrypt($usuario->id) }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="contrasena">Nueva contraseña:</label>
                        </div>
                        <div class="col">
                            <input type="text" id="contrasenaactualizar" name="contrasena" class="form-control">
                            <br><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="tipo">Tipo:</label>
                        </div>
                        <div class="col">
                            <select id="tipo_actualizar" name="tipo" class="form-control" required>
                                <option value="1">Super Administrador</option>
                                <option value="2">Administrador</option>
                                <option value="3">Ejecutivo</option>
                            </select><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Actualizar" class="btn btn-primary">
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
    <br>
    {{-- ELIMINAR USUARIO --}}
    <div class="card">
        <div class="card-header">
            <h1 class="card-title" style ="font-size: 2rem">Eliminar usuario</h1>
        </div>
        <div class="card-body">
            <form id="eliminarusuario">
                @csrf
                <div class="container">

                    <div class="row">
                        <div class="col">
                            <label for="usuario">Usuario:</label>
                        </div>
                        <div class="col">
                            <select name="id" id="id" class="form-control">
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ encrypt($usuario->id) }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Eliminar" class="btn btn-danger">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('fondo')
@stop

@section('css')
    <style>

    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            generarContrasena();
            drawTriangles();

            $('#crearusuario').submit(function(e) {
                e.preventDefault(); // Evitar la recarga de la página

                // Obtener los datos del formulario
                var datosFormulario = $(this).serialize();

                // Realizar la solicitud AJAX con jQuery
                $.ajax({
                    url: '/crearusuario', // Ruta al controlador de Laravel
                    type: 'POST',
                    data: datosFormulario, // Enviar los datos del formulario
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
                        generarContrasena();
                    },
                    error: function(xhr) {
                        Swal.fire(
                            '¡Gracias por esperar!',
                            "Existe un error: " + xhr,
                            'error'
                        )
                    }
                });
            });
            $('#actualizarusuario').submit(function(e) {
                e.preventDefault(); // Evitar la recarga de la página

                // Obtener los datos del formulario
                var datosFormulario = $(this).serialize();

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Se actualizará la información del usuario!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, actualizar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '/actualizarusuario', // Ruta al controlador de Laravel
                            type: 'POST',
                            data: datosFormulario, // Enviar los datos del formulario
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire(
                                    '¡Gracias por esperar!',
                                    response.message,
                                    'success'
                                );
                            },
                            error: function(error) {
                                Swal.fire(
                                    '¡Gracias por esperar!',
                                    "Existe un error: " + error.responseJSON
                                    .message,
                                    'error'
                                )
                            }
                        });
                    } else {

                    }
                })

            });
            $('#eliminarusuario').submit(function(e) {
                e.preventDefault(); // Evitar la recarga de la página

                // Obtener los datos del formulario
                var datosFormulario = $(this).serialize();

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Esta accion no puede ser revertida!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, elminar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '/eliminarusuario', // Ruta al controlador de Laravel
                            type: 'POST',
                            data: datosFormulario, // Enviar los datos del formulario
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
                            error: function(error) {
                                Swal.fire(
                                    '¡Gracias por esperar!',
                                    "Existe un error: " + error.responseJSON
                                    .message,
                                    'error'
                                )
                            }
                        });
                    } else {

                    }
                })




                // Realizar la solicitud AJAX con jQuery

            });

            $('#id_actualizar').on('change', function() {
                var selectedUserId = $(this).val();

                // Realizar una solicitud AJAX para obtener el tipo del usuario
                $.ajax({
                    type: 'GET',
                    url: '/obtener-tipo', // Ruta de Laravel que manejará la consulta
                    data: {
                        id: selectedUserId
                    },
                    success: function(data) {
                        // Actualizar el campo "tipo" en el formulario con el valor obtenido
                        $('#tipo_actualizar').val(data.tipo);
                    },
                    error: function() {
                        console.log('Error al obtener el tipo del usuario');
                    }
                });
            });


            // Poner sin seleccionar a ACTUALIZAR
            select = document.getElementById("id_actualizar");
            nuevaOpcion = document.createElement("option");
            nuevaOpcion.value = "0";
            nuevaOpcion.text = "Sin seleccionar";
            select.insertBefore(nuevaOpcion, select.firstChild);
            select.value = 0;

            select2 = document.getElementById("tipo_actualizar");
            nuevaOpcion2 = document.createElement("option");
            nuevaOpcion2.value = "0";
            nuevaOpcion2.text = "Sin seleccionar";
            select2.insertBefore(nuevaOpcion2, select2.firstChild);
            select2.value = 0;

            // Poner sin seleccionar en eliminar
            select3 = document.getElementById("id");
            nuevaOpcion3 = document.createElement("option");
            nuevaOpcion3.value = "0";
            nuevaOpcion3.text = "Sin seleccionar";
            select3.insertBefore(nuevaOpcion3, select.firstChild);
            select3.value = 0;

        });

        function generarContrasena() {
            var caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
            var contrasena = '';
            var contrasena2 = '';

            for (var i = 0; i < 8; i++) {
                var index = Math.floor(Math.random() * caracteres.length);
                contrasena += caracteres.charAt(index);
            }

            for (var j = 0; j < 8; j++) { // Cambia 'i' a 'j' aquí
                var index = Math.floor(Math.random() * caracteres.length);
                contrasena2 += caracteres.charAt(index);
            }

            document.getElementById('contrasena').value = contrasena;
            document.getElementById('contrasenaactualizar').value =
                contrasena2; // Cambia el nombre de la variable aquí también
        }
    </script>
@stop
