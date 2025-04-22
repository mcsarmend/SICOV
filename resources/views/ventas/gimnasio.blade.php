@extends('adminlte::page')

@section('title', 'home')

@section('content_header')
    <h1>Gimnasio</h1>
@stop

@section('content')
    <br>
    {{-- asdsad --}}
    <div class="card">
        <div class="card-body" style="width: 1200px">
            <div>Gimasio</div>

            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha de nacimiento</th>
                        <th>Sexo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Fecha de ingreso</th>
                        <th>Tipo de membresía</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    {{-- Aquí se llenarán los datos --}}
                </tbody>
            </table>
        </div>

    </div>



    @include('fondo')
@stop

@section('css')
    <style></style>

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
