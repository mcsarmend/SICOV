@extends('adminlte::page')

@section('title', 'Ingreso Inventario')

@section('content_header')


@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Alta Inventario</h1>

        </div>
        <div class="card-body">
            <form id="altaproducto">
                <h3>Descripción del producto</h3>
                <div class="row">
                    <div class="col">
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                        <br>
                    </div>

                    <div class="col">
                        <label for="name">Precio:</label>
                        <input type="text" name="precio" required minlength="1" maxlength="10" class="form-control"
                            placeholder="">
                        <br>
                    </div>
                </div>
                <h3>Existencias</h3>
                <div class="row">
                    <div class="col">
                        <label for="name">Cantidad:</label>
                        <input type="text" name="existencia" required minlength="1" maxlength="3000"
                            class="form-control" placeholder="">
                        <br>
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <input type="submit" value="Guardar" class="btn btn-success">
                    </div>
                </div>

            </form>

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
        $('#altaproducto').submit(function(e) {
            e.preventDefault(); // Evitar la recarga de la página

            // Obtener los datos del formulario
            var datosFormulario = $(this).serialize();

            // Realizar la solicitud AJAX con jQuery
            $.ajax({
                url: '/altaproducto', // Ruta al controlador de Laravel
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
                    /*  setTimeout(function() {
                         window.location.reload();
                     }, 10000); */

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
    </script>
@stop
