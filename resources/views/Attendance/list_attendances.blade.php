@extends('menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/Attendance/list_attendances.css')}}">
@endsection
@section('content')
    <form action="#">
        <div class="container">
            <p data-placement="top" data-toggle="tooltip" title="Edit" class="bt-left">
                <a href="#">
                    <button class="btn btn-primary" data-title="Edit" data-toggle="modal" data-target="#edit" >
                        Thêm lần điểm danh
                    </button>
                </a>
            </p>
            <p data-placement="top" data-toggle="tooltip" title="Edit" class="bt-right">
                <a href="#">
                    <button class="btn btn-primary" data-title="Edit" data-toggle="modal" data-target="#edit" >
                        Cập nhật
                    </button>
                </a>
            </p>
            <p data-placement="top" data-toggle="tooltip" title="Edit" class="bt-right">
                <a href="#">
                    <button class="btn btn-primary" data-title="Edit" data-toggle="modal" data-target="#edit" >
                        Tải xuống
                    </button>
                </a>
            </p>
            <div class="row">
                <div class="col-md-11">
                    <div class="table-responsive">


                        <table id="mytable" class="table table-bordred table-striped">

                            <thead>

                            <th><input type="checkbox" id="checkall" /></th>
                            <th>Ngày</th>
                            <th>Thao tác</th>
                            </thead>
                            <tbody>

                            @foreach($days as $day)
                                <tr>
                                    <td><input type="checkbox" class="checkthis" /></td>
                                    <td>{{$day}}</td>
                                    <td>
                                        <p data-placement="top" data-toggle="tooltip" title="Edit" class="bt-left">
                                            <a href="/detailAttendance/{{$day}}" class="btn btn-primary btn-xs" >
                                                    Xem chi tiết
                                            </a>
                                        </p>
                                        <p data-placement="top" data-toggle="tooltip" title="Delete" class="bt-right">
                                            <a href="#" class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete{{$day}}" >
                                                Xóa
                                            </a>
                                        </p>
                                        <div class="modal fade" id="delete{{$day}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete information of date "{{$day}}"?</div>

                                                    </div>
                                                    <div class="modal-footer ">
                                                        <a href="/deleteAttendances/{{$day}}" class="btn btn-danger" >
                                                            <span class="glyphicon glyphicon-ok-sign"></span> Yes
                                                        </a>
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
        </div>
    </form>


@endsection
