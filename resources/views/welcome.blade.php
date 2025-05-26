<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Integral Compra-Venta</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (íconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #646263, #B20024);
            color: white;
            padding: 100px 0;
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #646263;
            margin-bottom: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #646263, #B20024);
            border: none;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/images/logo.png" alt="Logo" style="height: 40px;">
                <!-- Opcional: <span class="ms-2">Sistema Integral</span> -->
            </a>
            <a class="navbar-brand" href="#">Sistema Integral Compra-Venta</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary ms-2" href="#" data-bs-toggle="modal"
                            data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Transforma tu negocio</h1>
            <p class="lead">La solución perfecta para optimizar tus procesos.</p>
            <button class="btn btn-light btn-lg me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="fas fa-user"></i> Acceder
            </button>
        </div>
    </section>

    <!-- Features -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Nuestras características</h2>
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                    <h3>Analítica Avanzada</h3>
                    <p>Métricas en tiempo real para tomar mejores decisiones.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="feature-icon"><i class="fas fa-robot"></i></div>
                    <h3>Automatización</h3>
                    <p>Ahorra tiempo con procesos automatizados.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Seguridad</h3>
                    <p>Tus datos protegidos con cifrado de última generación.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal de Bootstrap -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Iniciar Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Mensaje de error general -->
                    <div id="loginError" class="alert alert-danger d-none">
                        Credenciales incorrectas. Por favor, inténtalo de nuevo.
                    </div>

                    <form id="loginForm" action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" placeholder="Email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="Contraseña" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

<!-- jQuery 3.x (última versión estable) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- jQuery 3.x (con integridad SRI - más seguro) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    @if ($errors->has('email') || $errors->has('password'))
        $(document).ready(function() {
            $('#loginModal').modal('show');
        });
    @endif

    // Opcional: Manejar respuesta AJAX si usas fetch/axios
    document.getElementById('loginForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(this)
            });

            if (!response.ok) {
                const errors = await response.json();
                if (response.status === 422) {
                    document.getElementById('loginError').classList.remove('d-none');
                }
            } else {
                window.location.reload(); // Redirigir si es exitoso
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    $('#loginForm').submit(function(event) {
        event.preventDefault(); // Evita el comportamiento por defecto del formulario
        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize(),
            success: function(data) {
                // Redirigir si es exitoso
                window.location.href = "/dashboard";
            },
            error: function(xhr) {
                // Mostrar los errores
                var errors = xhr.responseJSON.errors;
                var errorMessages = '<div class="alert alert-danger"><ul>';
                errorMessages += '</ul> Los datos de acceso son incorrectos</div>';
                $('#error-messages').html(errorMessages);
            }
        });
    });
</script>

</html>
