@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
@stop

@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h1>Home</h1>
        </div>
        <div class="card-body" style="width: 100%">


        </div>
    </div>
    @include('fondo')
@stop

@section('css')
    <style>
    </style>

@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            drawTriangles();



           });


    </script>
@stop
