@extends('adminlte::page')

@section('title', 'Reporte > Inventario > Existencias y Costos')

@section('content_header')

@stop

@section('content')
    <div class="card">

        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title" style ="font-size: 2rem">Reporte > Inventario > Existencias y Costos</h1>
                </div>
                <div class="card-body">
                    <table id=table-products class="table">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Producto</th>
                                <th>Marca</th>
                                <th>Categoria</th>
                                <th>Existencias Totales</th>
                                <th>Almacèn Principal</th>
                                <th>Viveros</th>
                                <th>TownCenter</th>
                                <th>Coacalco</th>
                                <th>Villas</th>
                                <th>Naucalpan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    @include('fondo')
@stop

@section('css')

@stop

@section('js')
    <script>
        $(document).ready(function() {

            // $('#table-products').DataTable({
            //     destroy: true,
            //     scrollX: true,
            //     scrollCollapse: true,
            //     "language": {
            //         "url": "{{ asset('js/datatables/lang/Spanish.json') }}"
            //     },
            //     "buttons": [

            //     ],
            //     dom: 'Blfrtip',
            //     destroy: true,
            //     processing: true,
            //     sort: true,
            //     paging: true,
            //     lengthMenu: [
            //         [10, 25, 50, -1],
            //         [10, 25, 50, 'All']
            //     ], // Personalizar el menú de longitud de visualización


            //     "data": products,
            //     columns: [{
            //             data: 'codigo'
            //         },
            //         {
            //             data: 'producto'
            //         },
            //         {
            //             data: 'marca'
            //         },
            //         {
            //             data: 'categoria'
            //         },
            //         {
            //             data: 'totales'
            //         },
            //         {
            //             data: 'almacen_principal'
            //         },
            //         {
            //             data: 'viveros'
            //         },
            //         {
            //             data: 'towncenter'
            //         },
            //         {
            //             data: 'coacalco'
            //         },
            //         {
            //             data: 'villas'
            //         },
            //         {
            //             data: 'naucalpan'
            //         }
            //     ],
            //     order: [
            //         [0, "asc"]
            //     ],
            //     pageLength: 50,
            // });
            drawTriangles();
            showUsersSections();
        });
    </script>
@stop
