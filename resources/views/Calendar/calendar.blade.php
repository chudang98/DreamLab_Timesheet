@extends('menu')
@section('css')


    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/calendar/calendar.css')}}">
    <link rel='stylesheet' href='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css'>
    <link rel='stylesheet' href='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css'>
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">--}}

@endsection
@section('content')
    <div id='calendar'></div>
    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled tooltip">
    </span>
@endsection
@section('script')
    <script src="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js"></script>
    <script src="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js"></script>
    <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.3/js/mdb.min.js"></script>
    <script src="{{asset('js/calendar/calendar.js')}}"></script>
@endsection
