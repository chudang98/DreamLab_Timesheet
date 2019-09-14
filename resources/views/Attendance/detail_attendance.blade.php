@extends('menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/Attendance/detail_attendance.css')}}">
@endsection
@section('content')
    <div class="container">
        <p data-placement="top" data-toggle="tooltip" title="Edit" class="bt-right">
            <a href="/listAttendances">
                <button class="btn " data-title="Edit" data-toggle="modal" data-target="#edit" >
                    Quay lại
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
                        <th>Thời gian</th>
                        <th>Mã nhân viên</th>
                        <th>Tên nhân viên</th>
                        <th>Thao tác</th>
                        </thead>
                        <tbody>

                        @foreach($attendances as $attendance)
                            <tr>
                                <td>{{$attendance->date_time}}</td>
                                <td>
                                    @foreach($users as $user)
                                        @if($user->id == $attendance->user_id)
                                            {{$user->employee_id}}
                                            @break
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($users as $user)
                                        @if($user->id == $attendance->user_id)
                                            {{$user->name}}
                                            @break
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <p data-placement="top" data-toggle="tooltip" title="Delete" class="bt-right">
                                        <a href="#" class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete{{$attendance->id}}" >
                                            Xóa
                                        </a>
                                    </p>
                                    <div class="modal fade" id="delete{{$attendance->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                    <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete attendance of datetime "{{$attendance->date_time}}"?</div>

                                                </div>
                                                <div class="modal-footer ">
                                                    <a href="/deleteAttendance/{{$attendance->id}}" class="btn btn-danger" >
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
@endsection
