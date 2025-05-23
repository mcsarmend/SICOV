<style>
    .content-header {
        z-index: 10;
        position: relative;

    }

    /*     h1 {

        background: -webkit-radial-gradient(center, ellipse cover, #ffffff, #aabbcc) !important;

        background: radial-gradient(ellipse at center, #ffffff, #aabbcc) !important;
    } */

    .content-wrapper {
        position: relative;
        overflow: hidden;
        padding: 20px;
        background-color: #f4f4f4;
        /* Fondo gris claro por defecto */
    }

    .card {
        z-index: 1;
        background-color: #FFF;
    }

    canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .dropdown-item.active,
    .dropdown-item:active {
        background-color: #a0101e !important;
    }
</style>

<script>
    function drawTriangles() {
        const contentWrapper = document.querySelector(".content-wrapper");
        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");

        contentWrapper.appendChild(canvas);

        canvas.width = contentWrapper.clientWidth;
        canvas.height = contentWrapper.clientHeight;

        const colors = ["#a0101e", "#b54856", "#cc808e", "#e4b8c5"];

        function drawRandomTriangle() {
            const sideLength = Math.random() * 50 + 10;
            const x = Math.random() * (canvas.width - sideLength);
            const y = Math.random() * (canvas.height - sideLength);
            const color = colors[Math.floor(Math.random() * colors.length)];

            ctx.beginPath();
            ctx.moveTo(x, y);
            ctx.lineTo(x + sideLength, y);
            ctx.lineTo(x + sideLength / 2, y + sideLength * Math.sqrt(3) / 2);
            ctx.closePath();

            ctx.fillStyle = color;
            ctx.fill();
        }

        function drawRandomTriangles(numTriangles) {
            for (let i = 0; i < numTriangles; i++) {
                drawRandomTriangle();
            }
        }

        window.addEventListener('resize', function() {
            canvas.width = contentWrapper.clientWidth;
            canvas.height = contentWrapper.clientHeight;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            drawRandomTriangles(50);
        });

        drawRandomTriangles(100);
    }

    // function showUsersSections() {

    //     var type = @json($type);
    //     switch (type) {

    //         // VENDEDOR
    //         case 4:

    //             // Cambiar nombre
    //             $('small').each(function() {
    //                 if ($(this).text().includes('Administrador')) {
    //                     $(this).text('Vendedor');
    //                 }
    //             });
    //             $('.user-footer a').each(function() {
    //                 if ($(this).text().includes('Cuentas')) {
    //                     $(this).hide();
    //                     $(this).css('display', 'none !important'); // Añadir !important
    //                     $(this).remove(); // Eliminar el enlace del DOM
    //                 }
    //             });

    //             var almacenMenu = $('.nav-item.dropdown').has('.fas.fa-warehouse');

    //             // Eliminar las secciones "Alta" y "Baja" dentro del menú "Almacén"
    //             almacenMenu.find('.dropdown-item').each(function() {
    //                 var itemText = $(this).text().trim();
    //                 if (itemText === 'Alta' || itemText === 'Baja') {
    //                     $(this).parent()
    //                         .remove(); // Eliminar el elemento <li> que contiene la <a> con el texto "Alta" o "Baja"
    //                 }
    //             });

    //             $('a[href="https://www.gprogyms.com.mx/asistenciageneral"]').remove();
    //             $('a[href="https://www.gprogyms.com.mx/calendario"]').remove();
    //             $('a[href="https://www.gprogyms.com.mx/vacaciones"]').remove();
    //             // Quitar Inventario
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Inventario');
    //             }).remove();
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Clientes');
    //             }).remove();
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Compras');
    //             }).remove();
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Vendedores');
    //             }).remove();
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Precios');
    //             }).remove();
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Proveedores');
    //             }).remove();
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Reportes');
    //             }).remove();
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Reconocimientos');
    //             }).remove();
    //             break;

    //             // JEFATURA
    //         case 3:

    //             // Cambiar nombre
    //             $('small').each(function() {
    //                 if ($(this).text().includes('Administrador')) {
    //                     $(this).text('Jefatura');
    //                 }
    //             });

    //             $('.user-footer a').each(function() {
    //                 if ($(this).text().includes('Cuentas')) {
    //                     $(this).hide();
    //                     $(this).css('display', 'none !important'); // Añadir !important
    //                     $(this).remove(); // Eliminar el enlace del DOM
    //                 }
    //             });

    //             var almacenMenu = $('.nav-item.dropdown').has('.fas.fa-warehouse');

    //             // Eliminar las secciones "Alta" y "Baja" dentro del menú "Almacén"
    //             almacenMenu.find('.dropdown-item').each(function() {
    //                 var itemText = $(this).text().trim();
    //                 if (itemText === 'Alta' || itemText === 'Baja') {
    //                     $(this).parent()
    //                         .remove(); // Eliminar el elemento <li> que contiene la <a> con el texto "Alta" o "Baja"
    //                 }
    //             });

    //             $('a[href="https://www.gprogyms.com.mx/asistenciageneral"]').remove();
    //             $('a[href="https://www.gprogyms.com.mx/calendario"]').remove();
    //             $('a[href="https://www.gprogyms.com.mx/vacaciones"]').remove();

    //             // Cambiar nombre
    //             $('small').each(function() {
    //                 if ($(this).text().includes('Administrador')) {
    //                     $(this).text('Supervision');
    //                 }
    //             });
    //             $('.user-footer a').each(function() {
    //                 if ($(this).text().includes('Cuentas')) {
    //                     $(this).hide();
    //                     $(this).css('display', 'none !important'); // Añadir !important
    //                     $(this).remove(); // Eliminar el enlace del DOM
    //                 }
    //             });

    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Proveedores');
    //             }).remove();
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Clientes');
    //             }).remove();
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Reconocimientos');
    //             }).remove();
    //             break;



    //             // SUPERVISION
    //         case 2:

    //             // Cambiar nombre
    //             $('small').each(function() {
    //                 if ($(this).text().includes('Administrador')) {
    //                     $(this).text('Supervision');
    //                 }
    //             });
    //             $('.user-footer a').each(function() {
    //                 if ($(this).text().includes('Cuentas')) {
    //                     $(this).hide();
    //                     $(this).css('display', 'none !important'); // Añadir !important
    //                     $(this).remove(); // Eliminar el enlace del DOM
    //                 }
    //             });

    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Proveedores');
    //             }).remove();
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Clientes');
    //             }).remove();
    //             $('li.nav-item.dropdown').filter(function() {
    //                 return $(this).text().trim().includes('Reconocimientos');
    //             }).remove();
    //             break;


    //             // ADMINISTRADOR
    //         case 1:

    //             $('.user-footer a').each(function() {
    //                 if ($(this).text().includes('Cuentas')) {
    //                     $(this).hide();
    //                     $(this).css('display', 'none !important'); // Añadir !important
    //                     $(this).remove(); // Eliminar el enlace del DOM
    //                 }
    //             });
    //             break;
    //         default:



    //             break;
    //     }





    // }

    function getFormattedDateTime() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var year = now.getFullYear().toString().slice(-2);
        var hours = ("0" + now.getHours()).slice(-2);
        var minutes = ("0" + now.getMinutes()).slice(-2);

        return day + month + year + hours + minutes;
    }
</script>
