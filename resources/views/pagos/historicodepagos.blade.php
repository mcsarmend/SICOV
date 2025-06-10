@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')

@stop

@section('content')
    <div class="card">

        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title" style ="font-size: 2rem">Historico de pagos</h1>
                </div>
                <div class="card-body">
                    <table id=clientes class="table">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Nombre</th>
                                <th>Monto</th>
                                <th>Concepto</th>
                                <th>Fecha de pago</th>
                                <th>Metodo de pago</th>
                                <th>Registrado por</th>
                                <th>Observaciones</th>
                                <th>Mes correspondiente</th>
                                <th>Estatus</th>
                                <th>Imprimir</th>
                                <th>Cancelar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>




    <div class="modal fade" id="historialpagos" tabindex="-1" role="dialog" aria-labelledby="historialpagosCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-width " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historialpagosLongTitle">Detalle de Historial de Pagos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="historialpagostabla" class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Cantidad</th>
                                <th>Tipo de pago</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>

    @include('fondo')
@stop

@section('css')
    <style>
        .modal-dialog.custom-width {
            max-width: 55%;
            /* Ajusta este valor según tus necesidades */
        }

        #direcciontabla th:first-child,
        #direcciontabla td:first-child {
            min-width: 300px;
            /* Ajusta este valor según tus necesidades */
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script>
        $(document).ready(function() {
            drawTriangles();
            var pagos = @json($pagos);
            $('#clientes').DataTable({
                destroy: true,
                scrollX: true,
                scrollCollapse: true,
                "language": {
                    "url": "{{ asset('js/datatables/lang/Spanish.json') }}"
                },
                "buttons": [
                    'copy', 'excel', 'pdf', 'print'
                ],
                dom: 'Blfrtip',
                destroy: true,
                processing: true,
                sort: true,
                paging: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ], // Personalizar el menú de longitud de visualización

                // Configurar las opciones de exportación
                // Para PDF
                pdf: {
                    orientation: 'landscape', // Orientación del PDF (landscape o portrait)
                    pageSize: 'A4', // Tamaño del papel del PDF
                    exportOptions: {
                        columns: ':visible' // Exportar solo las columnas visibles
                    }
                },
                // Para Excel
                excel: {
                    exportOptions: {
                        columns: ':visible' // Exportar solo las columnas visibles
                    }
                },
                "data": pagos,
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "nombre"
                    },
                    {
                        "data": "monto"
                    },
                    {
                        "data": "concepto"
                    },
                    {
                        "data": "fecha_pago"
                    },
                    {
                        "data": "metodo_pago"
                    },
                    {
                        "data": "usuario"
                    },
                    {
                        "data": "observaciones"
                    },
                    {
                        "data": "mes_correspondiente",
                    },
                    {
                        "data": "estatus"
                    },
                    {
                        "data": "imprimir",
                        "render": function(data, type, row) {
                            return '<button onclick="imprimir(' + JSON.stringify(row).replace(/"/g,
                                "'") + ')" class="btn btn-primary">Imprimir</button>';
                        }
                    },
                    {
                        "data": "cancelar",
                        "render": function(data, type, row) {

                            if (row.estatus == "cancelada") {
                                return '-';
                            } else {

                                return '<button onclick="cancela_pago(' + row.id +
                                    ')" class="btn btn-danger">Cancelar</button>';
                            }

                        }
                    },

                ]
            });
            drawTriangles();
            //     showUsersSections();
        });


        function imprimir(rowData) {
            // Crear el documento PDF en formato ticket (58mm de ancho)
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: [58, 100] // Ancho fijo de 58mm, altura dinámica
            });

            // Configuración inicial
            doc.setFont('helvetica');
            const pageWidth = doc.internal.pageSize.getWidth();
            let yPosition = 5; // Posición vertical inicial

            // Encabezado - Centrado
            doc.setFontSize(10);
            doc.setFont('helvetica', 'bold');
            doc.text('Instituto Zaragoza', pageWidth / 2, yPosition, {
                align: 'center'
            });
            yPosition += 5;

            doc.setFontSize(8);
            doc.text('Comprobante de venta electrónica', pageWidth / 2, yPosition, {
                align: 'center'
            });
            yPosition += 4;

            // Línea divisoria
            doc.setDrawColor(0);
            doc.setLineWidth(0.2);
            doc.line(5, yPosition, pageWidth - 5, yPosition);
            yPosition += 5;

            // Número de comprobante
            doc.setFontSize(8);
            doc.text(`No. ${rowData.id}`, pageWidth / 2, yPosition, {
                align: 'center'
            });
            yPosition += 4;

            // Fechas
            const today = new Date();
            doc.text(
                `Emisión: ${today.toLocaleDateString()} ${today.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}`,
                pageWidth / 2, yPosition, {
                    align: 'center'
                });
            yPosition += 4;
            doc.text(`Pago: ${rowData.fecha_pago}`, pageWidth / 2, yPosition, {
                align: 'center'
            });
            yPosition += 6;

            // Línea divisoria
            doc.line(5, yPosition, pageWidth - 5, yPosition);
            yPosition += 5;

            // Nombre del cliente (NUEVO)
            doc.setFont('helvetica', 'bold');
            doc.text('CLIENTE:', 10, yPosition);
            doc.setFont('helvetica', 'normal');
            // Dividir el nombre si es muy largo
            const nombreCliente = doc.splitTextToSize(rowData.nombre, 40);
            doc.text(nombreCliente, 10, yPosition + 4);
            yPosition += (nombreCliente.length * 4) + 6;

            // Detalles del pago
            doc.setFont('helvetica', 'bold');
            doc.text('CONCEPTO:', 10, yPosition);
            doc.setFont('helvetica', 'normal');
            doc.text(rowData.concepto, 10, yPosition + 4);
            yPosition += 10;

            doc.setFont('helvetica', 'bold');
            doc.text('MONTO:', 10, yPosition);
            doc.setFont('helvetica', 'normal');
            doc.text(`$${parseFloat(rowData.monto).toFixed(2)}`, 10, yPosition + 4);
            yPosition += 8;

            // Forma de pago mejorada (CORRECCIÓN)
            doc.setFont('helvetica', 'bold');
            doc.text('FORMA DE PAGO:', 10, yPosition);
            doc.setFont('helvetica', 'normal');
            const formaPago = rowData.metodo_pago.toUpperCase(); // Convertir a mayúsculas
            doc.text(formaPago, 10, yPosition + 4);
            yPosition += 8;

            //Mes Correspondiente
            doc.setFont('helvetica', 'bold');
            doc.text('MES CORRESPONDIENTE:', 10, yPosition);
            doc.setFont('helvetica', 'normal');
            const mes_correspondiente = rowData.mes_correspondiente.toUpperCase(); // Convertir a mayúsculas
            doc.text(mes_correspondiente, 10, yPosition + 4);
            yPosition += 8;





            // Línea divisoria
            doc.line(5, yPosition, pageWidth - 5, yPosition);
            yPosition += 5;

            // Pie de página
            doc.setFontSize(6);
            doc.setFont('helvetica', 'italic');
            doc.text('SIN VALOR LEGAL', pageWidth / 2, yPosition, {
                align: 'center'
            });
            yPosition += 3;
            doc.text('Gracias por su pago', pageWidth / 2, yPosition, {
                align: 'center'
            });

            // Abrir en nueva ventana para imprimir
            const pdfOutput = doc.output('bloburl');
            window.open(pdfOutput, '_blank');
        }

        function cancela_pago(id) {

            Swal.fire({
                title: "¿Estas seguro?",
                text: "¡Esta acción no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Si, cancelar remisión!"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: 'cancelarremision', // URL a la que se hace la solicitud
                        type: 'POST', // Tipo de solicitud (GET, POST, etc.)
                        data: {
                            id: id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json', // Tipo de datos esperados en la respuesta
                        success: function(data) {
                            Swal.fire({
                                title: "¡Cancelada!",
                                text: "La remisón ha sido cancelada.",
                                icon: "success"
                            });

                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        }
                    });
                }
            });

        }
    </script>
@stop
