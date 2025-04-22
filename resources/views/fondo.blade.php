
    <style>
        .content-wrapper {
            position: relative;
            overflow: hidden;
            padding: 20px;
            background-color: #f4f4f4;
            /* Fondo gris claro por defecto */
        }
        .card{
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
    </style>

    <script>
        function drawTriangles() {
            const contentWrapper = document.querySelector(".content-wrapper");
            const canvas = document.createElement("canvas");
            const ctx = canvas.getContext("2d");

            contentWrapper.appendChild(canvas);

            canvas.width = contentWrapper.clientWidth;
            canvas.height = contentWrapper.clientHeight;

            const colors = ["#3498db", "#ffffff", "#ecf0f1", "#bdc3c7"];

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

            drawRandomTriangles(50);
        }

        function showUsersSections() {
            var type = @json($type);
            switch (type) {
                case '3':
                    $('a:contains("Cuentas")').hide();
                    $('small:contains("Administrador")').text('Ejecutivo');
                    $('a:contains("Etiquetado")').hide();
                    $('a:contains("Administración de Cartera")').hide();
                    $('a:contains("Administración de Fideicomisos")').hide();
                    $('a:contains("Anexos")').hide();
                    break;
                case '2':
                    $('a:contains("Cuentas")').hide();

                    break;

                default:
                    break;
            }
        }
    </script>
