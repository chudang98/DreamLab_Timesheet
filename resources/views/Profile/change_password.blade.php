@extends('menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/Profile/change_password.css')}}">
@endsection
@section('content')

    <h2 class="title">Đổi mật khẩu</h2>
    <form action="/updatePassword" method="POST">
        @csrf
        <label>Mật khẩu hiện tại: </label>
        <input type="password" name="old-password" required>
        @if($alert == 'old')
            <p class="text-danger">Mật khẩu hiện tại không đúng</p>
        @endif
        <br> <br>
        <label>Mật khẩu mới: </label>
        <input type="password" name="new-password" required>
        @if($alert == 'new1')
            <p class="text-danger">Mật khẩu mới bị trùng với mật khẩu cũ</p>
        @endif
        @if($alert == 'new2')
            <p class="text-danger">Mật khẩu: </p>
            <p class="text-danger">- Ít nhất 8 kí tự </p>
            <p class="text-danger">- Ít nhất 1 kí tự số và 1 kí tự chũ </p>
        @endif
        @if($alert == 'new3')
            <p class="text-danger">Mật khẩu mới không khớp với mật khẩu nhập lại</p>
        @endif
        <br> <br>
        <label>Nhập lại mật khẩu mới: </label>
        <input type="password"  name="re-password" required>
        <br> <br>
        <button type="submit" class="btn-primary  bt-save">Lưu</button>
        <button class="bt-cancel">
            <a href="/editProfile/{{auth()->user()->name}}" >
                Hủy
            </a>
        </button>

    </form>

@endsection
