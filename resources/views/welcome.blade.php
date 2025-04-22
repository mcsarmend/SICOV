<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Bienvenido a Helix</title>
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
    <style>
        .bg-image-1 {
            position: relative;
            background-image: url('assets/images/paralaxbus.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .bg-image {
            position: relative;
            background-image: url('assets/images/paralaxservicios.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .bg-image-1::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.4);
            /* Ajusta el valor alpha (0.4) para cambiar la opacidad */
        }

        .bg-image::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.4);
            /* Ajusta el valor alpha (0.4) para cambiar la opacidad */
        }

        .content {
            position: relative;
            padding: 20px;
            color: #fff;
            z-index: 1;
            /* Asegura que el contenido esté por encima de la superposición */
        }

        .overlay {
            font-size: 8px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px;
            text-align: center;
        }

        .custom-img {
            padding: 3px;
            width: 200px;
            border-radius: 25px;

        }

        .step-item {
            position: relative;
            display: inline-block;
            text-align: center;
        }

        .step-item .icon {
            position: relative;
            display: block;
            width: 40px;
            height: 40px;
            margin: 0 auto;
        }

        .step-item .line {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 2px;
            height: 100%;
            background: #000;
            transform: translateX(-50%);
        }

        .step-item h3 {
            margin-top: 10px;
        }

        .step-item:first-child .line {
            display: none;
        }

        .step-item:last-child .line {
            display: none;
        }

        .navbar-highlight {
            background-color: transparent;
            color: #2764AE;
            text-decoration: underline;
        }

        .carousel-item {
            position: relative;
        }

        .carousel-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(132, 162, 202, 0.5);
            padding: 20px;
            color: ##fff;
        }

        .carousel-caption h1 {
            font-size: 3rem;
        }

        .carousel-caption h5 {
            font-size: 1.5rem;
        }

        .container slide-in.slide-in {
            opacity: 0;
            transform: translateX(-100px);
            transition: opacity 0.5s, transform 0.5s;
        }

        .container slide-in.slide-in.show {
            opacity: 1;
            transform: translateX(0);
        }

        .btn-primary {
            background: #2764AE;
            color: #fff;
            border: 2px solid #2764AE;
        }
    </style>
</head>

<body>
    <div style="width:99%">

        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container slide-in">
                <a class="navbar-brand" href="#">
                    <img width="410" height="150"
                        src="https://fcontigo.com/wp-content/uploads/2022/12/logo-fcontigo-1.png"
                        class="attachment-full size-full wp-image-335" alt=""
                        srcset="https://fcontigo.com/wp-content/uploads/2022/12/logo-fcontigo-1.png 410w, https://fcontigo.com/wp-content/uploads/2022/12/logo-fcontigo-1-300x110.png 300w"
                        sizes="(max-width: 410px) 100vw, 410px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('servicios') }}">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bi') }}">Business Intelligence</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contacto') }}">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('formulario') }}">Formulario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://begb.com.mx/" target="_blank"
                                rel="noopener noreferrer">Nom 035</a>
                        </li> --}}
                    </ul>
                </div>
                @guest
                    {{-- <div class="row">

                        <a>Bienvenido a Helix</a>
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    </div> --}}
                    <div class="container custom-div">
                        <div class="row">
                          <div class="col">
                            <h2>Bienvenido a Helix</h2>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <a href="{{ route('login') }}" class="btn btn-primary">Iniciar sesión</a>
                          </div>
                        </div>
                      </div>

                @endguest
            </div>
        </nav>

        <br><br>
        {{-- BANNER --}}
        <div id="carouselExampleIndicators" class="carousel slide w-80 p-10 m-5 " data-bs-ride="carousel"
            style="padding: 3px">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/banner_1.png" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/banner_2.jpg" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/banner_3.jpg" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/banner_4.jpg" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/banner_5.jpg" class="d-block w-100" alt="Banner 1">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        <br><br><br>

        <div class="colorlib-narrow-content">
            <h1>¿Por qué el crédito Contigo es tu mejor opción?</h1>
            <p>Apoyamos a los hombres y mujeres mexicanos que requieren del respaldo y la confianza para iniciar,
                desarrollar y hacer realidad sus sueños.</p>
            <p>
                En Contigo, no sólo otorgamos un crédito, también te acompañamos de manera cálida y cercana para que
                logres tus objetivos mejorando así tu calidad de vida, la de tu familia y tu comunidad a través del
                fortalecimiento de tu negocio.
            </p>
            <h4>Cuentas con nosotros para guiarte en todo momento.</h4>
        </div>

        <br><br>

        <div class="colorlib-narrow-content">
            <h1>¿Cómo obtener un crédito en Contigo?</h1>
            <p>
                En Contigo tenemos un crédito de acuerdo a tus necesidades, sigue los pasos que a continuación te
                presentamos para que elijas correctamente uno de nuestros productos y servicios.
            </p>
        </div>
        <br><br>

        <div class="container-1">
            <div class="row feature-section">
                <!-- Primera columna -->
                <div class="col-md-4 feature">
                    <i class="fas fa-icono-1 fa-3x"></i>
                    <h3>Identifica</h3>
                    <p>El tipo de crédito que requieres.</p>
                </div>

                <!-- Segunda columna -->
                <div class="col-md-4 feature">
                    <i class="fas fa-icono-2 fa-3x"></i>
                    <h3>Solicitalo en tu sucursal</h3>
                    <p>Ubica tu sucursal mas cercana.</p>
                </div>

                <!-- Tercera columna -->
                <div class="col-md-4 feature">
                    <i class="fas fa-icono-3 fa-3x"></i>
                    <h3>Cambia su vida</h3>
                    <p>Tu trabajo y esfuerzo diario, en conjunto con nuestros créditos mejorarán la calidad de vida para
                        ti y tu familia..</p>
                </div>
            </div>
        </div>
        <br><br>

        <footer class="elementor elementor-25 elementor-location-footer">
            <br><br>
            <div class="container">
                <div class="row footer-row">
                    <!-- Primera fila -->
                    <div class="col-md-3 footer-col">
                        <img width="300" height="101"
                            src="https://fcontigo.com/wp-content/uploads/2022/12/logo-contigo-300x101.png"
                            class="attachment-medium size-medium wp-image-33" alt="" loading="lazy"
                            srcset="https://fcontigo.com/wp-content/uploads/2022/12/logo-contigo-300x101.png 300w, https://fcontigo.com/wp-content/uploads/2022/12/logo-contigo.png 665w"
                            sizes="(max-width: 300px) 100vw, 300px">
                        <p>Carretera México Toluca No. 2430,
                            Colonia Lomas de Bezares,
                            C.P. 11910, Alcaldía Miguel Hidalgo,
                            Ciudad de México.</p>
                    </div>
                    <div class="col-md-3 footer-col">
                        <h4>Nosotros</h4>
                        <p>¿Quienes somos?</p>
                        <p>Consulta el suplemento CTIGOCB20</p>
                        <p>Suplemento CTIGOCB17</p>
                    </div>
                    <div class="col-md-3 footer-col">
                        <h4>Servicios y Productos</h4>
                        <p>Solicita tu credito</p>
                        <p>Simulador de crédito</p>
                    </div>
                    <div class="col-md-3 footer-col">
                        <h4>Canales de pago</h4>
                        <p>Canales de pago.</p>
                        <p>Canales de cobro.</p>
                    </div>

                    <!-- Segunda fila con imágenes -->
                    <div class="col-md-3 footer-col">
                        <img width="280" height="200"
                            src="https://fcontigo.com/wp-content/uploads/2022/12/inst-great_2021.png"
                            class="attachment-medium size-medium wp-image-52 footer-img" alt=""
                            loading="lazy">
                    </div>
                    <div class="col-md-3 footer-col">
                        <img width="280" height="200"
                            src="https://fcontigo.com/wp-content/uploads/2022/12/inst-esr.png"
                            class="attachment-medium size-medium wp-image-52 footer-img"alt="" loading="lazy">
                    </div>
                    <div class="col-md-3 footer-col">
                        <img width="280" height="200"
                            src="https://fcontigo.com/wp-content/uploads/2022/12/inst-cnbv.png" c
                            class="attachment-medium size-medium wp-image-52 footer-img"alt="" loading="lazy">
                    </div>
                    <div class="col-md-3 footer-col">
                        <img width="280" height="200"
                            src="https://fcontigo.com/wp-content/uploads/2022/12/inst-condusef.png"
                            class="attachment-medium size-medium wp-image-52 footer-img" alt=""
                            loading="lazy">
                    </div>
                    <br>
                    <!-- Tercera fila -->
                    <div class="col-md-12 footer-col">
                        <p>En cumplimiento del artículo 87-J de la Ley General de Organizaciones y Actividades
                            Auxiliares de Crédito, CEGE CAPITAL S.A.P.I. de C.V., SOFOM E.N.R manifiesta que para su
                            constitución y operación con carácter de sociedad financiera de objeto múltiple, entidad no
                            regulada no requiere de autorización de la Secretaría de Hacienda y Crédito Público, y está
                            sujeta a la supervisión de la Comisión Nacional Bancaria y de Valores únicamente en materia
                            de prevención y detección de operaciones con recursos de procedencia ilícita y
                            financiamiento al terrorismo.</p>
                    </div>
                    <br>
                    <!-- Cuarta fila -->
                    <div class="col-md-12 footer-col">
                        <p>©2023 Contigo. Todos los derechos reservados.</p>
                    </div>
                </div>
            </div>
        </footer>



    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <style>
        .custom-div {
            text-align: center;
        }

        body {
            background-color: #f8f9fa;
            /* Color de fondo para dar contraste */
        }

        footer {
            background-color: #22363C;
            background-image: url("https://fcontigo.com/wp-content/uploads/2022/12/liston.png");
            /* Imagen PNG como fondo */
            color: #fff;
            padding: 20px 0;
        }

        .container-footer {
            background-color: rgba(34, 54, 60);
            /* Color de fondo para el contenido del pie de página */
            padding: 20px;
            border-radius: 10px;
            /* Bordes redondeados para el contenido del pie de página */
        }


        .feature-section {
            padding: 50px 0;
            /* Espaciado interno para la sección */
            text-align: center;
            /* Centrar el texto */
        }

        .feature {
            margin-bottom: 30px;
            /* Espaciado inferior entre las características */
        }

        .container-1 {
            background: linear-gradient(to bottom, #0183CE, #0056b3);
            /* Fondo con gradiente azul */
            color: #fff;
            /* Color del texto en blanco para contrastar con el fondo */
        }

        .elementor-10 .elementor-element.elementor-element-f6b2e6e {
            transition: background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 89.3s;
            margin-top: 0px;
            margin-bottom: 0px;
            padding: 0% 5% 0% 5%;
        }

        .elementor-element {
            --widgets-spacing: 38px 20px;
        }

        .colorlib-narrow-content,
        .colorlib-narrow-content div {
            max-width: 800px;
            /* Ancho máximo del contenido */
            margin: 0 auto;
            /* Centrar el contenido horizontalmente */
            text-align: center;
            /* Centrar el texto */
        }

        h1,
        h2 {
            color: #0183CE;
            /* Color azul para los títulos */
        }
    </style>
    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                var windowBottom = $(this).scrollTop() + $(this).innerHeight();
                $(".container slide-in").each(function() {
                    var objectBottom = $(this).offset().top + $(this).outerHeight();

                    if (objectBottom < windowBottom) {
                        if (!$(this).hasClass("show")) {
                            $(this).addClass("show");
                        }
                    } else {
                        if ($(this).hasClass("show")) {
                            $(this).removeClass("show");
                        }
                    }
                });
            }).scroll();
        });
    </script>



</body>

</html>
