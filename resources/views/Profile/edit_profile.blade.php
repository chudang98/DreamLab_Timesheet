@extends('menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/Profile/edit_profile.css')}}">
@endsection
@section('content')
    <h2 class="title">Sửa thông tin tài khoản</h2>
    <form action="/updateProfile" method="post">
        @csrf
        <label>Tên: </label>
        <input type="text" value="Thao" required>
        <br> <br>
        <label>Email: </label>
        <input type="text" value="a@gmail.com" required>
        <br> <br>
        <button type="submit" class="btn-primary  bt-save">Lưu</button>
        <a href="/updateProfile" class="bt-cancel">
            <button type="button " >Hủy</button>
        </a>

        <a href="#" class="bt-changepw"><button >Đổi mật khẩu</button></a>
    </form>
@endsection
