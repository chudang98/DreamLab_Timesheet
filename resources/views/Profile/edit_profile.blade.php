@extends('menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/Profile/edit_profile.css')}}">
@endsection
@section('content')
    <h2 class="title">Edit your profile</h2>
    <form action="/saveProfile">
        <label>Name: </label>
        <input type="text" value="Thao" required>
        <br> <br>
        <label>Email: </label>
        <input type="text" value="a@gmail.com" required>
        <br> <br>
        <button type="submit" class="btn-primary">Save</button>
        <button type="button">Cancel</button>
        <a href="#"><button>Change Password</button></a>
    </form>
@endsection
