@extends('menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/index.css')}}">
@endsection
@section('content')
    <div class="employees">
        <a href="#">
            <div class="icon">
                <i class='fas fa-users'></i>
            </div>
            <div class="total">
                <p>Employees</p>
                <p>120</p>
            </div>
        </a>
    </div>
    <div class="departments">
        <a href="#">
            <div class="icon">
                <i class='fas fa-home'></i>
            </div>
            <div class="total">
                <p>Departments</p>
                <p>5</p>
            </div>
        </a>
    </div>
@endsection
