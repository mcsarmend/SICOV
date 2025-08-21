@extends('adminlte::page')

@section('title', 'Agenda')

@section('content')
    <div class="card">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
    @include('fondo')
@stop

@section('css')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.css' rel='stylesheet' />
    <style>

    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                slotMinTime: '06:00:00',
                slotMaxTime: '21:00:00',
                allDaySlot: false,
                locale: 'es',
                events: {!! $events !!},
                eventDidMount: function(info) {
                    // Agregar tooltip
                    $(info.el).tooltip({
                        title: info.event.extendedProps.description || info.event.title,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                }
            });
            calendar.render();
        });
    </script>
@stop
