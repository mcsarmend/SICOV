<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('/assets/images/login_1.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .recovery-form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            width: 400px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="recovery-form">
                    <h2 class="mb-4">Recuperación de Contraseña</h2>
                    <form id="actualizar">
                        @csrf
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Nombre</label>
                            <select name="id" id="id" class="form-control">
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ encrypt($usuario->id) }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Nueva Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="inputPassword" name = "contrasena"
                                    placeholder="Nueva Contraseña" required>
                                <button type="button" class="btn btn-outline-secondary"
                                    id="showPasswordButton">Mostrar</button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Recuperar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.23/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showPasswordButton = document.getElementById('showPasswordButton');
            const inputPassword = document.getElementById('inputPassword');

            showPasswordButton.addEventListener('click', function() {
                if (inputPassword.type === 'password') {
                    inputPassword.type = 'text';
                    showPasswordButton.textContent = 'Ocultar';
                } else {
                    inputPassword.type = 'password';
                    showPasswordButton.textContent = 'Mostrar';
                }
            });

            generarContrasena()
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

            document.getElementById('inputPassword').value = contrasena;

        }
        $('#actualizar').submit(function(e) {
            e.preventDefault(); // Evitar la recarga de la página

            // Obtener los datos del formulario
            var datosFormulario = $(this).serialize();

            // Realizar la solicitud AJAX con jQuery
            $.ajax({
                url: '/actualizarext', // Ruta al controlador de Laravel
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
    </script>
</body>

</html>
