@extends('adminlte::page')

@section('title', 'home')

@section('content_header')
    <h1>Home autenticado</h1>
@stop

@section('content')
    <br>
    {{-- asdsad --}}
    <div class="card">
        <div class="card-body" style="width: 1200px">


            <div class="section">
                <h3>Aforos</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Aforo</th>
                            <th>Actual Jucavi</th>
                            <th>Actual Mambu</th>
                            <th>Actual Suma</th>
                            <th>Diferencia</th>
                            <th>Cantidad Jucavi</th>
                            <th>Cantidad Mambu</th>
                            <th>Suma cantidad</th>
                            <th>Exportar Creditos</th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Promecap</th>
                            <th id="aforocalpromecap">AFORO CALCULADO PROMECAP</th>
                            <td id="valoractualjucavipromecap">Valor Actual jucavi promecap</td>
                            <td id="valoractualmambupromecap">Valor Actual mambu promecap</td>
                            <td id="valoractualsumapromecap">Valor Actual suma promecap</td>
                            <td id="valordiferenciapromecap">Valor Diferencia Promecap</td>
                            <td id="cantidadactualjucavipromecap">Cantidad actual jucavi Promecap</td>
                            <td id="cantidadactualmambupromecap">Cantidad actual mambu Promecap</td>
                            <td id="sumacantidadactualpromecap">Suma cantidad Promecap</td>
                            <th><button type="button" class="btn btn-primary"
                                    id="exportarcreditospromecap">Exportar</button></th>
                        </tr>
                        <tr>
                            <th>Blao</th>
                            <td id="valoraforoblao">$153,173,700.00</td>
                            <td id="valoractualjucaviblao">Valor Actual jucavi blao</td>
                            <td id="valoractualmambublao">Valor Actual mambu blao</td>
                            <td id="valoractualsumablao">Valor Actual suma blao</td>
                            <td id="valordiferenciablao">Valor Diferencia blao</td>
                            <td id="cantidadactualjucaviblao">Cantidad actual jucavi blao</td>
                            <td id="cantidadactualmambublao">Cantidad actual mambu blao</td>
                            <td id="sumacantidadactualblao">Suma cantidad blao</td>
                            <th>EXPORTAR</th>
                        </tr>
                        <tr>
                            <th>Mintos</th>
                            <td id="valoraforomintos">-</td>
                            <td id="valoractualjucavimintos">-</td>
                            <td id="valoractualmambumintos">Valor Actual mambu mintos</td>
                            <td id="valoractualsumamintos">Valor Actual suma mintos</td>
                            <td id="valordiferenciamintos">-</td>
                            <td id="cantidadactualjucavimintos">-</td>
                            <td id="cantidadactualmambumintos">Cantidad actual mambu mintos</td>
                            <td id="sumacantidadactualmintos">Suma cantidad mintos</td>
                            <th>EXPORTAR</th>
                        </tr>
                    </tbody>
                </table>


            </div>
            <br>

            <div class="section">
                <h2> Gráficas</h2>
                <br>
                <figure class="highcharts-figure">
                    <h2>JUCAVI</h2>
                    <div id="container-jucavi"></div>
                    <p class="highcharts-description">
                        En esta gráfica se encuentra la cantidad de elementos de un fondeador jucavi
                    </p>
                </figure>
                <br>
                <figure class="highcharts-figure">
                    <h2>MAMBU</h2>
                    <div id="container-mambu"></div>
                    <p class="highcharts-description">
                        En esta gráfica se encuentra la cantidad de elementos de un fondeador mambu
                    </p>
                </figure>
            </div>
            <br>
            <br>


        </div>

    </div>



    @include('fondo')
@stop

@section('css')
    <style>
        .section {
            border-bottom: 1px solid #034383;
            padding: 20px;
            align-content: center;
        }

        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        input[type="number"] {
            min-width: 50px;
        }

        /* Estilos para el modal */
        .modal {
            display: none;
            /* Por defecto, ocultar el modal */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            /* Fondo semi-transparente */
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
        }

        /* Estilos para el botón de cerrar el modal */
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .modalAnexo {
            font-family: Arial;
            font-size: 18.5px
        }

        .cent {
            text-align: center;
            z-index: 0;
            left: 0px;
            top: 0px
        }

        .derecha {
            text-align: right;
        }

        .justif {
            text-align-last: justify;
        }

        .container {
            max-width: 1200px !important;
        }
    </style>

@stop

@section('js')



    <script>
        var jsonjucavi = [];
        var jsonmambu = [];
        $(document).ready(function() {


            drawTriangles();
            showUsersSections();
        });
    </script>
@stop
