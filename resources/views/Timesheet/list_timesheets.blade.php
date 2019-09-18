@extends('menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/Attendance/list_attendances.css')}}">
@endsection
@section('content')
    <form action="#">
        <div class="container">
            <form action="/listTimesheets" method="GET">
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
                        Xuất chấm công
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
                            <th>Ngày</th>
                            <th>Mã nhân viên</th>
                            <th>Tên nhân viên</th>
                            <th>Giờ vào</th>
                            <th>Giờ ra</th>
                            <th>Phép</th>
                            <th>Ngày công</th>
                            </thead>
                            <tbody>
                            <?php $dem=1; ?>
                            @foreach($timesheets as $timesheet)
                                <tr>
                                    {{--                                    <td><input type="checkbox" class="checkthis" /></td>--}}
                                    <td>{{$dem++}}</td>
                                    <td>{{$timesheet->date}}</td>
                                    <td>
                                        @foreach($users as $user)
                                            @if($user->id == $timesheet->user_id)
                                                {{$user->employee_id}}
                                                @break
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($users as $user)
                                            @if($user->id == $timesheet->user_id)
                                                {{$user->name}}
                                                @break
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{$timesheet->date}}</td>
                                    <td>{{$timesheet->date}}</td>
                                    <td>{{$timesheet->date}}</td>
                                    <td>{{$timesheet->date}}</td>
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
