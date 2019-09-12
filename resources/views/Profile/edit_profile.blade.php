@extends('menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/Profile/edit_profile.css')}}">

@endsection
@section('content')

    <h2 class="title">Sửa thông tin tài khoản</h2>
    <form action="/updateProfile" method="POST">
        @csrf
        <label>Tên: </label>
        <input type="text" value="{{auth()->user()->name}}" name="name" required>
        <br> <br>
        <label>Email: </label>
        <input type="text" value="{{auth()->user()->email}}" name="email" required>
        <br> <br>
        <button type="submit" class="btn-primary  bt-save">Lưu</button>
        <button class="bt-cancel">
            <a href="/editProfile/{{auth()->user()->name}}" >
                Hủy
            </a>
        </button>
        <button class="bt-changepw">
            <a href="/changePassword/{{auth()->user()->name}}" >Đổi mật khẩu</a>
        </button>

    </form>
    @if($alert == 'successI')
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title custom_align" id="Heading" style="text-align: center">Thông báo</h3>
                </div>
                <div class="modal-body">

                    <div class="alert alert-info">
                        <p>Cập nhật thông tin thành công.</p>
                    </div>
                    <div class="modal-footer " style="text-align: center">
                        <form action="/editProfile/{{auth()->user()->name}}" class="cancel-order">
                            <button type="submit" class="btn btn-success" >Thoát</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($alert == 'successPW')
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title custom_align" id="Heading" style="text-align: center">Thông báo</h3>
                </div>
                <div class="modal-body">

                    <div class="alert alert-info">
                        <p>Đổi mật khẩu thành công.</p>
                    </div>
                    <div class="modal-footer " style="text-align: center">
                        <form action="/editProfile/{{auth()->user()->name}}" class="cancel-order">
                            <button type="submit" class="btn btn-success" >Thoát</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
