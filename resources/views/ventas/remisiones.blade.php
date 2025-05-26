@extends('adminlte::page')

@section('title', 'Remisiones')

@section('content_header')

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Remisiones</h2>
        </div>
        <div class="card-body">
            <table id="remisiones" class="table">
                <thead>
                    <tr>
                        <th>Remisión</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Nota</th>
                        <th>Forma de pago</th>
                        <th>Tipo de precio</th>
                        <th>Almacen</th>
                        <th>Vendedor</th>
                        <th>Productos</th>
                        <th>Total</th>
                        <th>Estatus</th>
                        <th>Es Reparto</th>
                        <th>Asignado por</th>
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

    <div class="modal fade" id="productos" tabindex="-1" role="dialog" aria-labelledby="productosCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-width " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productosLongTitle">Detalle de productos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="productostabla" class="table">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Cantidad</th>
                                <th>Nombre</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>


    @include('fondo')
@stop

@section('css')
    <style>
        .modal-dialog.custom-width {
            max-width: 40%;
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
            showUsersSections();
            var remisiones = @json($remisiones);
            $('#remisiones').DataTable({
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
                "data": remisiones,
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "fecha"
                    },
                    {
                        "data": "cliente"
                    },

                    {
                        "data": "nota"
                    },
                    {
                        "data": "forma_pago"
                    },
                    {
                        "data": "precio"
                    },
                    {
                        "data": "almacen"
                    },
                    {
                        "data": "vendedor"
                    },
                    {
                        "data": "productos",
                        "render": function(data, type, row) {
                            return '<button onclick="ver(' + row.id +
                                ')" class="btn btn-primary">Ver</button>';
                        }
                    },
                    {
                        "data": "total"
                    },
                    {
                        "data": "estatus"
                    },
                    {
                        "data": "reparto"
                    },
                    {
                        "data": "vendedor_reparto"
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

                                return '<button onclick="cancelar_remision(' + row.id +
                                    ')" class="btn btn-danger">Cancelar</button>';
                            }

                        }
                    },

                ]
            });
        });


        function ver(id) {
            $('#productos').modal('show');


            $.ajax({
                url: 'verproductosremision', // URL a la que se hace la solicitud
                type: 'GET', // Tipo de solicitud (GET, POST, etc.)
                data: {
                    id: id
                },

                dataType: 'json', // Tipo de datos esperados en la respuesta
                success: function(data) {
                    $('#productostabla').DataTable({
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
                        "data": data.productos,
                        "columns": [{
                                "data": "Codigo"
                            },
                            {
                                "data": "Cantidad"
                            },
                            {
                                "data": "Nombre"
                            },
                            {
                                "data": "Precio Unitario"
                            },
                            {
                                "data": "Subtotal"
                            },
                        ]
                    });
                }
            });
        }


        function imprimir(rowData) {
            // Hacer la petición AJAX primero
            $.ajax({
                url: 'verproductosremision',
                type: 'GET',
                data: {
                    id: rowData.id
                },
                dataType: 'json',
                success: function(data) {
                    const productos = data.productos.map(p => ({
                        codigo: p.Codigo,
                        cantidad: p.Cantidad,
                        descripcion: p.Nombre,
                        precio: parseFloat(p['Precio Unitario']).toFixed(2),
                        total: parseFloat(p.Subtotal).toFixed(2)
                    }));
                    // Una vez que tenemos los productos, generamos el PDF
                    generarPDF(rowData, productos);
                },
                error: function(error) {
                    console.error('Error al obtener productos:', error);
                    Swal.fire('Error', 'No se pudieron obtener los productos', 'error');
                }
            });
        }

        function generarPDF(rowData, productos) {
            // Crear el documento PDF
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: [400, 400]
            });

            // Extraer datos del registro (rowData)
            var {
                id: numeroRemision,
                fecha,
                nota = 'SIN NOTA',
                forma_pago,
                cliente,
                almacen: nombreSucursal,
                vendedor,
                total
            } = rowData;


            // Agregar contenido al PDF
            doc.setFontSize(9);
            doc.setFont('helvetica', 'bold');
            doc.text('GRUPO PROGYMS', 30, 2);
            doc.text(`Sucursal: ${nombreSucursal}`, 29, 7);
            doc.text(`Remisión No.: ${numeroRemision}`, 10, 12);
            doc.text(`Hora: ${fecha}`, 10, 17);
            doc.text(`Nota: ${nota}`, 10, 22);
            doc.text(`Forma de pago: ${forma_pago}`, 10, 27);
            doc.text(`Almacen: ${nombreSucursal}`, 10, 32);
            doc.setFontSize(7);
            doc.text(`Vendedor: ${vendedor}`, 10, 37);
            doc.text(`Cliente: ${cliente}`, 10, 42);

            // Crear tabla temporal para los productos
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = `
        <table id="tempProductTable">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${productos.map(p => `
                                                                            <tr>
                                                                                <td>${p.codigo || ''}</td>
                                                                                <td>${p.cantidad || ''}</td>
                                                                                <td>${p.descripcion || ''}</td>
                                                                                <td>${p.precio ? '$' + p.precio: ''}</td>
                                                                                <td>${p.total ? '$' + p.total : ''}</td>
                                                                            </tr>
                                                                        `).join('')}
                <tr>
                    <td colspan="4" style="text-align: right;">TOTAL:</td>
                    <td>$${total ? total.toFixed(2) : '0.00'}</td>
                </tr>
            </tbody>
        </table>
    `;

            // Convertir la tabla HTML a formato para jsPDF
            const res = doc.autoTableHtmlToJson(tempDiv.querySelector('#tempProductTable'));
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

            // Pie de página
            doc.setFontSize(6);
            doc.text('Para cambios y devoluciones, presentar el producto SIN ABRIR', 10,
                doc.autoTable.previous.finalY + 10);
            doc.text('con su ticket de venta dentro de los primeros 5 días hábiles', 10,
                doc.autoTable.previous.finalY + 15);
            doc.text('después de la fecha de compra.', 10, doc.autoTable.previous.finalY + 20);

            // Guardar PDF
            doc.save(`remision_${numeroRemision}.pdf`);
            Swal.fire('Ticket impreso!', '', 'success');
        }

        function cancelar_remision(id) {

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
