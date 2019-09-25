@extends('menu')
@section('css')
    <script src="{{asset('js/calendar/calendar.js')}}"></script>
    <script src="{{asset('js/calendar/vi.js')}}"></script>
    <link rel='stylesheet' href='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css'>
    <link rel='stylesheet' href='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css'>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/calendar/calendar.css')}}">

@endsection
@section('content')
    <!-- partial:index.partial.html -->
    <div id='calendar'></div>
    <!-- partial -->
    <script src='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js'></script>
    <script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
    <script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js'></script>

@endsection
