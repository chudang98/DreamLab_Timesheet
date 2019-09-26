@extends('menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/Attendance/list_attendances.css')}}">
    <script src="{{asset('js/local-vi.js')}}"></script>
@endsection
@section('content')
    <form action="#">
        <div class="container">
            <form action="/listAttendances" method="GET">
                <div class="search_time">
                    <div style="position: relative; top: 5px;">
                        <label for="">Thời gian:</label>
                        <input id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px;
                        border: 1px solid #ccc; width: 60%; display: inline; padding-left: 20px" name="time">
                            <i class="icon-calendar fa fa-calendar"></i>&nbsp;
                            <i class="fa fa-caret-down icon-down"></i>
                    </div>
                </div>
                <div class="search_employee">
                    <label for="">Tên/Mã nhân viên: </label>
                    <input type="text" name="employee" placeholder="Tìm kiếm mã hoặc tên nhân viên"
                        @if(isset($employee))
                            value="{{$employee}}"
                            @endif
                    >
                </div>
                <button type="submit" class="bt-search btn btn-primary">Tìm kiếm</button>
            </form>
            
            <p data-placement="top" data-toggle="tooltip" title="Edit" class="bt_right" style="margin-right: 17px">
                <a href="#">
                    <button class="btn btn-primary" data-title="Edit" data-toggle="" >
                        Thêm mới
                    </button>
                </a>
            </p>
            <p data-placement="top" data-toggle="tooltip" title="Edit" class="bt_right" style="margin-right: 17px">
                <a href="{{ url('process_new_data') }}">
                    <button type="button" id="process_data" class="btn btn-primary" data-title="Edit" data-toggle="" >
                        Xử lí dữ liệu
                    </button>
                </a>
            </p>
            <div class="row">
                <div class="col-md-11">
                    <div class="table-responsive">


                        <table id="mytable" class="table table-bordred table-striped">

                            <thead>

{{--                            <th><input type="checkbox" id="checkall" /></th>--}}
                            <th>STT</th>
                            <th>Thời gian</th>
                            <th>Mã nhân viên</th>
                            <th>Tên nhân viên</th>
                            <th>Thao tác</th>
                            </thead>
                            <tbody>
                            <?php $dem=1; ?>
                            @foreach($attendances as $attendance)
                                <tr>
{{--                                    <td><input type="checkbox" class="checkthis" /></td>--}}
                                    <td>{{$dem++}}</td>
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
                                        <p data-placement="top" data-toggle="tooltip" title="Edit" class="bt-left">
{{--                                            <a href="#" class="btn btn-primary btn-xs" >--}}
{{--                                                    Cập nhật--}}
{{--                                            </a>--}}
                                        </p>
                                        <p data-placement="top" data-toggle="tooltip" title="Delete" class="bt-right">
                                            <a href="#" class="btn btn-danger btn-xs" data-title="Delete"
                                               data-toggle="modal" data-target="#delete{{$attendance->id}}" >
                                                Xóa
                                            </a>
                                        </p>
                                        <div class="modal fade" id="delete{{$attendance->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header alert-danger">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                        <h3 class="modal-title custom_align alert-danger" id="Heading" style="text-align: center">Cảnh báo</h3>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div>
                                                            <p>Hành động xóa lượt điểm danh có thể ảnh hưởng đến quá trình chấm công của nhân viên</p>
                                                            <p class="text-danger"> Đây là hành động không được khuyến khích!</p>
                                                            <p>Bạn có chắc muốn xóa lượt điểm danh của nhân viên?</p>

                                                        </div>

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
    </form>



    <script type="text/javascript">
        $(function() {
            var start = '<?php echo $time[0]; ?>';
            var end = '<?php echo $time[2]; ?>';

        /*    $('#process_data').click(function(){
                window.location.href = {{ url('process_new_data') }};
            }); */
 

            function cb(start, end) {
                $('#reportrange').html(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Hôm nay': [moment(), moment()],
                    'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 ngày trước': [moment().subtract(6, 'days'), moment()],
                    '30 ngày trước': [moment().subtract(29, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, cb);
            // console.log(document.querySelector('li[data-range-key="Custom Range"]'));
            document.querySelector('li[data-range-key="Custom Range"]').innerText
                = "Tự đặt ngày";
            document.querySelector('.cancelBtn').innerText
                = "Hủy";
            document.querySelector('.applyBtn ').innerText
                = "Áp dụng"
            cb(start, end);
        });
    </script>
@endsection
