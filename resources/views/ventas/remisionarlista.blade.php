@extends('adminlte::page')

@section('title', 'Remisionar')

@section('content_header')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Remisionar lista especial</h2>
        </div>
        <div class="card-body">


            <form id="remisionar">

                <div class="row">
                    <div class="col"><label for="vendedor">Vendedor:</label></div>
                    <div class="col"><input type="text" class="form-control" id="vendedor" name = "vendedor"
                            data-value={{ $idvendedor }} value="{{ $vendedor }}" readonly></div>
                    @if ($type == 4)
                        <div class="col"><label for="sucursal">Sucursal:</label></div>
                        <div class="col"><input type="text" class="form-control" id="sucursal" name = "sucursal"
                                data-value={{ $idsucursal }} value={{ $nombresucursal->nombre }} readonly></div>
                    @else
                        <div class="col"><label for="sucursal">Sucursal:</label></div>
                        <div class="col">
                            <select name="sucursal" id="sucursal" class="form-control">
                                @foreach ($idssucursales as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif


                    <div class="col"><label for="fecha">Fecha:</label></div>
                    <div class="col"><input type="date" class="form-control" id="fecha" name = "fecha"
                            data-value="" value="" readonly></div>

                </div>
                <br>
                <div class="row">
                    <div class="col"><label for="nota">Nota:</label></div>
                    <div class="col">
                        <textarea id="nota" name="nota" rows="3" cols="21" placeholder="Escribe tu texto aquí..."
                            data-value="" value=""></textarea>
                    </div>
                    <div class="col"><label for="metodo_pago">Metodo de pago:</label></div>
                    <div class="col">
                        <select name="metodo_pago" id="metodo_pago" class="form-control">
                            <option value="efectivo">Efectivo</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="terminal">Terminal</option>
                            <option value="clip">Clip</option>
                            <option value="mercado_pago">Mercado Pago</option>
                            <option value="vales">Vales</option>
                        </select>

                    </div>

                    <div class="col"><label for="cliente">Cliente:</label></div>
                    <div class="col">
                        <!-- Movemos el elemento #fila-producto aquí -->
                        <div class="row" id="fila-producto">
                            <div class="col">
                                <input type="text" id="cliente" name="cliente" list="client-list" class="form-control">
                                <datalist id="client-list">
                                    <option value="Mostrador">
                                        @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}-{{ $cliente->nombre }}">
                                        @endforeach
                                </datalist>
                            </div>

                        </div>
                        <br>

                    </div>
                </div>
                @if ($type != 4)
                    <div class="row">
                        <div class="col"><label for="reparto">Es reparto:</label></div>
                        <div class="col">
                            <input class="form-check-input" type="checkbox" id="reparto" name="reparto" value="1">
                        </div>
                        <div class="col"></div>
                        <div class="col"></div>
                        <div class="col"></div>
                        <div class="col"></div>
                        <div id = "vreparto" style="display: none;">
                            <div class="col"><label for="vendedor_reparto">Vendedor Reparto:</label></div>

                            <div class="col">
                                <select name="vendedor_reparto" id="vendedor_reparto" class="form-control">
                                    <option value="">Selecciona un vendedor</option>
                                    @foreach ($vendedores as $vendedor)
                                        <option value="{{ $vendedor->id }}">{{ $vendedor->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>


                    </div>
                @endif

                <br>


                <div class="row">
                    <div class="col">
                        <div class="btn btn-primary" onclick="buscarProducto()">Agregar otro producto</div>
                    </div>


                </div>

                <br>
                <div class="row">

                    <table id="productos" class="table" border="0.1">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Cantidad</th>
                                <th>Nombre</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                                <th>Cancelar</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>




                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-success">Realizar Remisión</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>

    <script>
        var contadorFilas = 1;
        var sum = 0;
        $(document).ready(function() {
            drawTriangles();
            showUsersSections();
            var type = @json($type);
            if (type == 4) {
                $("#tipo_precio").prop("disabled", true);
            }


            $('#fecha').val(new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60000 - 6 * 60 * 60000)
                .toISOString().split('T')[0]);

            $('#reparto').change(function() {
                if ($(this).is(':checked')) {
                    $('#vreparto').show();
                } else {
                    $('#vreparto').hide();
                }
            });


        });


        function buscarProducto() {
            var precioproducto = "";
            if ($('#cliente').val() == "") {
                Swal.fire({
                    title: '¡No has indicado cliente!',
                    icon: 'warning'
                });
                return;
            } else {
                Swal.fire({
                    title: 'Productos',
                    html: `

                <label for="inputWithDatalist">Selecciona un producto:</label>
                <input list="datalistOptions" id="inputWithDatalist" class="form-control col-sm-14">
                <datalist id="datalistOptions">
                    ${generateOptions()}
                </datalist>
                <label for="inputCantidad">Cantidad:</label>
                <input type="number" id="inputCantidad" class="form-control col-sm-14" >
                <br>
            `,
                    focusConfirm: false,
                    preConfirm: () => {
                        const cantidad = document.getElementById('inputCantidad').value;
                        const producto = document.getElementById('inputWithDatalist').value;

                        if (cantidad === "" || producto === "") {
                            Swal.showValidationMessage('Debes llenar ambos campos');
                        }

                        return {
                            cantidad: cantidad,
                            producto: producto
                        };
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Siguiente',
                    cancelButtonText: 'Cerrar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const idproducto = obtenerNumerosHastaGuion(result.value.producto);
                        var idcliente = obtenerNumerosHastaGuion($('#cliente').val());
                        var cantidad = $('#inputCantidad').val();
                        var idsucursal = $('#sucursal').val();
                        var idprecio = $('#tipo_precio').val();
                        if (idcliente == null) {
                            idcliente = 1;
                        }

                        const data = {
                            id_producto: idproducto,
                            idcliente: idcliente,
                            cantidad: cantidad,
                            sucursal: idsucursal,
                            id_precio: 6
                        };

                        $.ajax({
                            url: 'buscarprecio', // URL a la que se hace la solicitud
                            type: 'POST', // Tipo de solicitud (GET, POST, etc.)
                            data: data,
                            dataType: 'json', // Tipo de datos esperados en la respuesta
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {

                                agregarFila(data.idproducto, data.cantidad, data.subtotal, data.nombre,
                                    data.precio);


                            },
                            error: function(xhr, status, error) {

                                Swal.fire({
                                    title: 'Error:',
                                    text: xhr.responseJSON.error,
                                    icon: 'warning'
                                });
                            }
                        });


                    }
                });
            }
        }

        // Función para generar las opciones del datalist
        function generateOptions() {
            var options = @json($productos);
            var dataList = '';
            options.forEach(function(item) {
                dataList += `<option value="${item.id}-${item.nombre}">`;
            });
            return dataList;
        }

        // Función para obtener números hasta el guion
        function obtenerNumerosHastaGuion(text) {
            return text.split('-')[0];
        }


        function eliminarFila(elemento) {
            elemento.remove();
        }

        function obtenerNumerosHastaGuion(cadena) {
            // Buscar la posición del guion medio en la cadena
            const indiceGuion = cadena.indexOf('-');

            // Si no hay guion en la cadena, retornar null o algún valor indicando la ausencia del guion
            if (indiceGuion === -1) {
                return null; // o puedes retornar una cadena vacía o un valor que desees
            }

            // Extraer la parte de la cadena hasta el guion (excluyendo el guion)
            const subcadena = cadena.substring(0, indiceGuion);

            // Usar una expresión regular para obtener solo los números de la subcadena
            const numeros = subcadena.match(/\d+/g);

            // Combinar los números en una sola cadena
            return numeros ? numeros.join('') : '';
        }

        function agregarFila(codigo, cantidad, subtotal, nombre, precio) {
            // Verificar si el código ya existe en alguna fila
            var codigoExiste = false;
            $('#productos tbody tr').each(function() {
                var codigoExistente = $(this).find('td').eq(0).text();
                if (codigoExistente === codigo) {
                    codigoExiste = true;
                    return false; // Salir del bucle each
                }
            });

            // Si el código ya existe, no agregar la nueva fila
            if (codigoExiste) {
                Swal.fire({
                    title: 'El producto ya ha sido agregado',
                    icon: 'warning'
                });
                return;
            }

            // Crear la nueva fila
            var nuevaFila =
                `<tr>
                    <td>${codigo}</td>
                    <td>${cantidad}</td>
                    <td>${nombre}</td>
                    <td>${precio}</td>
                    <td>${subtotal}</td>
                    <td><button class="btn btn-danger btn-sm eliminar-fila">Eliminar</button></td>
                </tr>`;

            // Agregar la nueva fila a la tabla
            $('#productos tbody').append(nuevaFila);

            // Asignar el evento de eliminación a los botones de la nueva fila
            $('.eliminar-fila').off('click').on('click', function() {
                $(this).closest('tr').remove();
            });

            Swal.fire({
                title: 'Has seleccionado:',
                text: nombre,
                icon: 'success'
            });
        }


        $('#remisionar').submit(function(e) {
            e.preventDefault(); // Evitar la recarga de la página
            total_cantidad = 0;


            $('#productos tbody tr').each(function() {
                const cantidad = parseInt($(this).find('td:eq(1)').text()) || 0;
                total_cantidad += cantidad;
            });

            if (total_cantidad < 12) {
                Swal.fire({
                    title: 'Se requiere tener al menos 12 productos',
                    icon: 'warning'
                });
                return;
            }





            // Obtener los datos del formulario y generar la tabla inicial
            var datosFormulario = $(this).serialize();
            var datos = [];
            var formData = new URLSearchParams(datosFormulario);
            var numeroRemision = "123456789";
            for (const [key, value] of formData.entries()) {
                datos.push({
                    key: key,
                    value: value
                });
            }


            datos = datos.filter(item => item.key !== 'sucursal');
            suc = $('#sucursal option:selected').text();
            datos.push({
                key: "nombre_sucursal",
                value: suc
            });

            // Crear la tabla HTML
            var table =
                '<table style="width:100%; border: 1px solid black; border-collapse: collapse; font-size: 15px;">';
            table +=
                '<tr><th style="border: 1px solid black; padding: 8px;">Campo</th><th style="border: 1px solid black; padding: 8px;">Valor</th></tr>';
            datos.forEach(element => {
                table += '<tr><td style="border: 1px solid black; padding: 8px;">' + element.key +
                    '</td><td style="border: 1px solid black; padding: 8px;">' + element.value +
                    '</td></tr>';
            });
            table += '</table>';




            // Clonar la tabla con id="productos" y quita ultima columna
            var $productoTableClone = $('#productos').clone();
            $productoTableClone.attr('id', 'productosClone')
            $productoTableClone.find('tr').each(function() {
                $(this).find('td:last-child, th:last-child').remove();
            });

            // Calcular la suma de la columna subtotal
            var sum = 0;
            $productoTableClone.find('tr').each(function() {
                var $lastTd = $(this).find('td:last-child');
                if ($lastTd.length) {
                    var value = parseFloat($lastTd.text());
                    if (!isNaN(value)) {
                        sum += value;
                    }
                }
            });

            // Añadir una nueva fila al final de la tabla con la suma
            $productoTableClone.append('<tr><td colspan="' + ($productoTableClone.find('tr:first-child th').length -
                    1) +
                '" style="border: 1px solid black; padding: 8px;">Total</td><td style="border: 1px solid black; padding: 8px;">' +
                sum + '</td></tr>');

            // Obtener el HTML de la tabla modificada
            var productoTableHtml = $productoTableClone.prop('outerHTML');

            // Mostrar el cuadro de diálogo de confirmación con SweetAlert
            Swal.fire({
                title: '¡Se realizará una remisión con los siguientes datos!',
                html: table + '<br>' + productoTableHtml,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Remisionar',
                width: '80%'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Obtener los valores necesarios para el PDF
                    var nombreSucursal = $("#sucursal option:selected").text();
                    var idsucursal = $('#sucursal').val();
                    numeroRemision = "123456789";
                    var fecha = $('#fecha').val();
                    const opciones = {
                        timeZone: 'America/Mexico_City',
                        hour12: false
                    };
                    var hora = new Date().toLocaleString('es-MX', opciones);
                    var nota = $('#nota').val();
                    var vendedor = $('#vendedor').data('value');
                    var tipo_precio = 6;
                    var reparto = $('#reparto').val();
                    var cliente = $('#cliente').val();
                    var cantidadTotalLetra = convertirNumeroALetras(sum);
                    var forma_pago = $('#metodo_pago').val();
                    var $productoTableClone2 = $('#productos').clone();
                    var vendedor_reparto = $("#vendedor_reparto option:selected").val();
                    numeroRemision = validarRemision(idsucursal, hora, nota, vendedor, cliente, forma_pago,
                        $productoTableClone2, tipo_precio, reparto, vendedor_reparto);


                }
            });
        });




        function validarRemision(idsucursal, hora, nota, vendedor, cliente, forma_pago, numeroRemision, tipo_precio,
            reparto, vendedor_reparto) {

            var $productoTableClone = $('#productosClone').clone();

            var table = $('#productos');
            var tableData = tableToJson(table);

            // Convertir a string JSON
            tableData.forEach(element => {
                delete element["Cancelar"];
            });
            var jsonString = JSON.stringify(tableData, null, 2);

            var total = 0;
            tableData.forEach(element => {
                total += parseInt(element.Subtotal);
            });
            var nombreSucursal = $("#sucursal option:selected").text();

            const data = {
                nombreSucursal: nombreSucursal,
                nota: nota,
                fecha: hora,
                forma_pago: forma_pago,
                almacen: idsucursal,
                vendedor: vendedor,
                cliente: cliente,
                productos: jsonString,
                total: total,
                tipo_precio: tipo_precio,
                reparto: reparto,
                vendedor_reparto: vendedor_reparto
            };
            var msg = "";
            $.ajax({
                url: 'validarremision', // URL a la que se hace la solicitud
                type: 'POST', // Tipo de solicitud (GET, POST, etc.)
                data: data,
                dataType: 'json', // Tipo de datos esperados en la respuesta
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    msg = data.message + ": " + data.id;
                    numeroRemision = data.id;
                    Swal.fire({
                        title: msg,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Imprimir',
                        width: '80%'
                    }).then((result) => {
                        if (result.isConfirmed) {


                            // Crear el documento PDF
                            const {
                                jsPDF
                            } = window.jspdf;
                            const doc = new jsPDF({
                                orientation: 'landscape',
                                unit: 'mm',
                                format: [400, 400]
                            });

                            // Agregar contenido al PDF
                            doc.setFontSize(9);
                            doc.setFont('helvetica', 'bold');
                            doc.text('GRUPO PROGYMS', 30, 2);
                            doc.text(`Sucursal: ${nombreSucursal}`, 29, 7);
                            doc.text(`Remisión No.: ${numeroRemision}`, 10, 12);
                            doc.text(`Hora.: ${hora}`, 10, 17);
                            doc.text(`Nota: ${nota}`, 10, 22);
                            doc.text(`Forma de pago : ${forma_pago}`, 10, 27);
                            doc.text(`Almacen: ${idsucursal}`, 10, 32);
                            doc.setFontSize(7);
                            doc.text(`Vendedor: ${vendedor}`, 10, 37);
                            doc.text(`Cliente: ${cliente}`, 10, 42);

                            // Convertir la tabla HTML a un formato aceptable para jsPDF
                            var res = doc.autoTableHtmlToJson($productoTableClone[0]);
                            doc.autoTable(res.columns, res.data, {
                                startY: 47,
                                margin: {
                                    left: 3,
                                    right: 5
                                },
                                styles: {
                                    fontSize: 6,
                                    fontStyle: 'bold'
                                },
                                columnStyles: {
                                    0: {
                                        cellWidth: 13
                                    },
                                    1: {
                                        cellWidth: 14
                                    },
                                    2: {
                                        cellWidth: 24
                                    },
                                    3: {
                                        cellWidth: 13
                                    },
                                    4: {
                                        cellWidth: 14
                                    }
                                },
                                headStyles: {
                                    fillColor: null,
                                    textColor: 0
                                },
                                bodyStyles: {
                                    fillColor: '#FFFFFF',
                                    textColor: 0
                                }
                            });

                            doc.setFontSize(6);
                            // Agregar texto sobre cambios y devoluciones
                            doc.text(
                                'Para cambios y devoluciones, presentar el producto SIN ABRIR',
                                10, doc.autoTable.previous.finalY + 10);
                            doc.text(
                                'con su ticket de venta dentro de los primeros 5 días hábiles ',
                                10, doc.autoTable.previous.finalY + 15);
                            // Guardar y mostrar el PDF
                            doc.text(
                                'después de la fecha de compra.',
                                10, doc.autoTable.previous.finalY + 20);
                            // Guardar y mostrar el PDF
                            doc.save(`remision_${numeroRemision}.pdf`);
                            Swal.fire('Ticket impreso!', '', 'success');
                        }
                    });
                },
                error: function(xhr, status, error) {

                    return xhr.responseJSON.error;
                }
            });

        }


        function tableToJson(table) {
            var data = [];

            // Obtener encabezados de la tabla
            var headers = [];
            $(table).find('thead th').each(function(index, th) {
                headers[index] = $(th).text();
            });

            // Obtener filas de la tabla
            $(table).find('tbody tr').each(function(index, tr) {
                var row = {};
                $(tr).find('td').each(function(cellIndex, td) {
                    row[headers[cellIndex]] = $(td).text();
                });
                data.push(row);
            });

            return data;
        }



        function convertirNumeroALetras(num) {
            const unidades = ["", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve"];
            const decenas = ["", "diez", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta",
                "noventa"
            ];
            const centenas = ["", "cien", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos",
                "setecientos", "ochocientos", "novecientos"
            ];

            if (num === 0) {
                return "cero";
            }

            function convertirCentenas(num) {
                if (num > 99) {
                    return centenas[Math.floor(num / 100)] + " " + convertirDecenas(num % 100);
                } else {
                    return convertirDecenas(num);
                }
            }

            function convertirDecenas(num) {
                if (num < 10) {
                    return unidades[num];
                } else if (num >= 10 && num < 20) {
                    const excepciones = ["diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete",
                        "dieciocho", "diecinueve"
                    ];
                    return excepciones[num - 10];
                } else {
                    return decenas[Math.floor(num / 10)] + (num % 10 === 0 ? "" : " y " + unidades[num % 10]);
                }
            }

            function convertirMiles(num) {
                if (num > 999) {
                    return convertirCentenas(Math.floor(num / 1000)) + " mil " + convertirCentenas(num % 1000);
                } else {
                    return convertirCentenas(num);
                }
            }

            return convertirMiles(num).trim();
        }
    </script>
@stop
