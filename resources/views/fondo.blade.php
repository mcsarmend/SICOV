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
        document.querySelectorAll(".content-wrapper canvas").forEach(el => el.remove());
        const contentWrapper = document.querySelector(".content-wrapper");
        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");
        contentWrapper.appendChild(canvas);

        canvas.width = contentWrapper.clientWidth;
        canvas.height = contentWrapper.clientHeight;

        // Cielo con tonos rojizos/naranjas más intensos
        function drawSky() {
            const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
            gradient.addColorStop(0, "#FF6B6B"); // rojo claro
            gradient.addColorStop(0.5, "#FF4E2E"); // rojo anaranjado
            gradient.addColorStop(1, "#A62920"); // rojo oscuro
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        }

        // Dunas con un tono rojo tierra
        function drawDunes() {
            ctx.fillStyle = "#C1440E"; // rojo tierra
            ctx.beginPath();
            ctx.moveTo(0, canvas.height - 100);
            for (let x = 0; x <= canvas.width; x += 50) {
                ctx.lineTo(x, canvas.height - (Math.sin(x / 80) * 30 + 80));
            }
            ctx.lineTo(canvas.width, canvas.height);
            ctx.lineTo(0, canvas.height);
            ctx.closePath();
            ctx.fill();

            // Capa extra para profundidad
            ctx.fillStyle = "#8B2E0B";
            ctx.beginPath();
            ctx.moveTo(0, canvas.height - 60);
            for (let x = 0; x <= canvas.width; x += 60) {
                ctx.lineTo(x, canvas.height - (Math.sin(x / 60) * 20 + 50));
            }
            ctx.lineTo(canvas.width, canvas.height);
            ctx.lineTo(0, canvas.height);
            ctx.closePath();
            ctx.fill();
        }

        drawSky();
        drawDunes();

        window.addEventListener('resize', () => {
            canvas.width = contentWrapper.clientWidth;
            canvas.height = contentWrapper.clientHeight;
            drawSky();
            drawDunes();
        });
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
