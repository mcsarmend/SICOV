@extends('adminlte::page')

@section('title', 'Reporte > Inventario > Corte de Caja')

@section('content_header')

@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h1 class="card-title" style="font-size: 2rem;">Reporte Sucursal</h1>
                </div>
                <form id="cortecajaform">

                    <div class="card-body">
                        <div>
                            <h3>Total General</h3>
                            <p style="background-color: #d4edda; color: #155724; padding: 10px; text-align: center;"
                                id="total-general">
                                <strong>$0.00</strong>
                            </p>

                            <h3>Total en efectivo a entregar</h3>
                            <p style="background-color: #d4edda; color: #155724; padding: 10px; text-align: center;"
                                id="total-efectivo-entregar">
                                <strong>$0.00</strong>
                            </p>

                            <hr style="border: 1px solid #000;">
                            <div class="concept-container" id="remesa-recibida-container">
                                <div class="concept-header">REMESA RECIBIDA</div>
                                <div class="inputs-container" id="remesa-recibida-inputs"></div>
                                <button class="add-button" onclick="addInput('remesa-recibida-inputs')">Agregar</button>
                            </div>
                            <hr style="border: 1px solid #000;">
                            <div class="concept-container" id="remesa-entregada-container">
                                <div class="concept-header">REMESA ENTREGADA</div>
                                <div class="inputs-container" id="remesa-entregada-inputs"></div>
                                <button class="add-button" onclick="addInput('remesa-entregada-inputs')">Agregar</button>
                            </div>
                            <hr style="border: 1px solid #000;">
                            <div class="concept-container" id="otras-ventas-container">
                                <div class="concept-header">OTRAS VENTAS</div>
                                <div class="inputs-container" id="otras-ventas-inputs"></div>
                                <button class="add-button" onclick="addInput('otras-ventas-inputs')">Agregar</button>
                            </div>
                            <hr style="border: 1px solid #000;">
                            <div class="concept-container" id="gastos-en-general-container">
                                <div class="concept-header">GASTOS EN GENERAL</div>
                                <div class="inputs-container" id="gastos-en-general-inputs"></div>
                                <button class="add-button" onclick="addInput('gastos-en-general-inputs')">Agregar</button>
                            </div>
                            <hr style="border: 1px solid #000;">
                        </div>
                        @foreach ($remisiones_por_pago as $forma_pago => $remisiones)
                            @if ($totales_por_pago[$forma_pago] > 0)
                                <h3>Forma de Pago: {{ ucfirst($forma_pago) }}</h3>
                                <table border="1" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                            <th>Vendedor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($remisiones as $remision)
                                            <tr>
                                                <td>{{ $remision->id }}</td>
                                                <td>{{ $remision->fecha }}</td>
                                                <td>{{ $remision->cliente }}</td>
                                                <td>${{ number_format($remision->total, 2) }}</td>
                                                <td>{{ $remision->vendedor }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" style="text-align: center;">
                                                    Sin datos para esta forma de pago
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">
                                                <strong>Total por {{ ucfirst($forma_pago) }}</strong>
                                            </td>
                                            <td colspan="2"
                                                style="background-color: #d4edda; color: #155724; text-align: center;">
                                                <strong>${{ number_format($totales_por_pago[$forma_pago], 2) }}</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <br>
                            @endif
                        @endforeach

                        <div class="col"><label for="observaciones">Observaciones:</label></div>
                        <div class="col">
                            <textarea id="observaciones" name="observaciones" rows="3" cols="120" placeholder="Escribe tu texto aquí..."
                                data-value="" value=""></textarea>
                        </div>
                        <br>

                        <button type="button" class="btn btn-primary" onclick="sendDataAsJson()">Realizar corte</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    @include('fondo')
@stop

@section('css')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: top;
        }

        th {
            text-align: center;
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .concept-container {
            margin-bottom: 20px;
        }

        .concept-header {
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }

        .inputs-container {
            margin-top: 10px;
        }

        .add-button {
            margin-top: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .add-button:hover {
            background-color: #218838;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .input-group input {
            margin-right: 10px;
            flex: 1;
        }

        .remove-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 3px 8px;
            cursor: pointer;
            margin-left: 10px;
        }

        .remove-button:hover {
            background-color: #c82333;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {


            drawTriangles();
            showUsersSections();
            calculateTotals();
            document.querySelectorAll('.concept-container input[type="number"]').forEach(input => {
                input.addEventListener('input', calculateTotals);
            });

            $('#cortecajaform').submit(function(e) {
                e.preventDefault(); // Evitar la recarga de la página

                // Obtener los datos del formulario
                var datosFormulario = $(this).serialize();



                $.ajax({
                    url: '/enviarcortecaja', // Ruta al controlador de Laravel
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
                    error: function(response) {
                        Swal.fire(
                            '¡Gracias por esperar!',
                            "Existe un error: " + response.message,
                            'error'
                        )
                    }
                });

            });

        });


        function sendDataAsJson() {

            let data = {
                total_general: parseFloat($("#total-general").text().replace("$", "").trim()) || 0,
                total_efectivo_entregar: parseFloat($("#total-efectivo-entregar").text().replace("$", "").trim()) || 0,
                inputs_adicionales: {},
                formas_pago: [],
                observaciones: $("#observaciones").val() || "Sin Observaciones"
            };

            // Recopilar los datos de los inputs adicionales (CXC, REMESA RECIBIDA, etc.)
            $(".concept-container").each(function() {
                let conceptId = $(this).attr('id').replace('-container', '');
                let inputs = [];
                $(this).find(".inputs-container input").each(function() {
                    valor = $(this).val()

                    if ($.isNumeric(valor)) {
                        inputs.push(parseFloat($(this).val()) || 0);
                    } else {
                        inputs.push($(this).val() || "Sin Concepto");
                    }

                });
                data.inputs_adicionales[conceptId] = inputs;
            });

            // Obtener las formas de pago
            $("h3:contains('Forma de Pago:')").each(function() {
                let formaPago = $(this).text().replace("Forma de Pago: ", "").trim();

                let tabla = $(this).next("table");
                let totalTexto = tabla.find("tfoot td strong").text().trim();
                let totalFormaPago = parseFloat(totalTexto.replace(/[^\d.]/g, '')) || 0;


                let remisiones = [];

                // Recopilar las remisiones dentro de esta forma de pago
                $(this).next("table").find("tbody tr").each(function() {
                    let celdas = $(this).find("td");
                    remisiones.push({
                        id: $(celdas[0]).text().trim(),
                        fecha: $(celdas[1]).text().trim(),
                        cliente: $(celdas[2]).text().trim(),
                        total: parseFloat($(celdas[3]).text().replace("$", "").trim()),
                        vendedor: $(celdas[4]).text().trim()
                    });
                });

                data.formas_pago.push({
                    forma_pago: formaPago,
                    remisiones: remisiones,
                    total: totalFormaPago
                });
            });





            // Enviar los datos como JSON mediante Ajax
            $.ajax({
                url: '/enviarinfocortecaja', // Ajusta la ruta al endpoint adecuado
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    Swal.fire(
                        '¡Datos enviados!',
                        'Se ha procesado correctamente la información.',
                        'success'
                    );
                },
                error: function(response) {
                    Swal.fire(
                        '¡Error!',
                        'Hubo un problema al procesar la información.',
                        'error'
                    );
                }
            });
        }


        function addInput(containerId) {
            const container = document.getElementById(containerId);

            // Crear un grupo para los inputs
            const inputGroup = document.createElement('div');
            inputGroup.classList.add('input-group');

            // Crear input para el monto
            const montoInput = document.createElement('input');
            montoInput.type = 'number';
            montoInput.placeholder = 'Monto';
            montoInput.required = true;
            montoInput.addEventListener('input', calculateTotals); // Asegúrate de recalcular al escribir

            // Crear input para el concepto
            const conceptoInput = document.createElement('input');
            conceptoInput.type = 'text';
            conceptoInput.placeholder = 'Concepto';
            conceptoInput.required = true;

            // Botón para eliminar la fila
            const removeButton = document.createElement('button');
            removeButton.textContent = 'Eliminar';
            removeButton.classList.add('remove-button');
            removeButton.onclick = function() {
                container.removeChild(inputGroup);
                calculateTotals(); // Recalcular después de eliminar
            };

            // Agregar inputs y botón al grupo
            inputGroup.appendChild(montoInput);
            inputGroup.appendChild(conceptoInput);
            inputGroup.appendChild(removeButton);

            // Agregar el grupo al contenedor
            container.appendChild(inputGroup);

            // Recalcular totales inmediatamente después de agregar un input
            calculateTotals();
        }

        function calculateTotals() {
            let totalGeneral = 0;
            let totalEfectivo = 0;

            // Variables para sumar valores
            let remesaRecibida = sumContainerInputs('remesa-recibida-container');
            let otrasVentas = sumContainerInputs('otras-ventas-container');
            let remesaEntregada = sumContainerInputs('remesa-entregada-container');
            let totalPorEfectivo = parseFloat('{{ $totales_por_pago['efectivo'] ?? 0 }}');
            let totalPorTransferencia = parseFloat('{{ $totales_por_pago['transferencia'] ?? 0 }}');
            let totalPorTerminal = parseFloat('{{ $totales_por_pago['terminal'] ?? 0 }}');
            let totalPorClip = parseFloat('{{ $totales_por_pago['clip'] ?? 0 }}');
            let totalPorMercadoPago = parseFloat('{{ $totales_por_pago['mercado_pago'] ?? 0 }}');
            let totalPorVales = parseFloat('{{ $totales_por_pago['vales'] ?? 0 }}');
            let gastosEnGeneral = sumContainerInputs('gastos-en-general-container');


            // Cálculo de total general

            totalGeneral =
                remesaRecibida +
                otrasVentas +
                totalPorEfectivo +
                totalPorTransferencia +
                totalPorTerminal +
                totalPorClip +
                totalPorMercadoPago +
                totalPorVales;


            total_electronico = totalPorTransferencia + totalPorTerminal + totalPorClip + totalPorMercadoPago +
                totalPorVales

            // Cálculo de total efectivo
            totalEfectivo = totalGeneral - remesaEntregada - gastosEnGeneral - total_electronico;

            // Actualizar los valores en pantalla
            document.getElementById('total-general').textContent = `$${totalGeneral.toFixed(2)}`;
            document.getElementById('total-efectivo-entregar').textContent = `$${totalEfectivo.toFixed(2)}`;
        }

        function sumContainerInputs(containerId) {
            let total = 0;
            document.querySelectorAll(`#${containerId} .input-group input[type="number"]`).forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            return total;
        }
    </script>
@stop
