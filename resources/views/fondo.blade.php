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
