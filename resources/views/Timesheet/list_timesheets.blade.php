@extends('menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/Attendance/list_attendances.css')}}">
    <script src="{{asset('js/local-vi.js')}}"></script>
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
                <button id="test" type="button" class="bt-search btn btn-primary">Tìm kiếm</button>
            </form>
            <p data-placement="top" data-toggle="tooltip" title="Edit" class="bt_right" style="margin-right: 17px">
                <a href="#">
                    <button id="export_excel" type="button" class="btn btn-primary" data-title="Edit" data-toggle="" >
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
                            <th>Thao tác</th>
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
                                    <td>
                                        @if($timesheet->check_in!=null)
                                            {{$timesheet->check_in}}
                                        @else
                                            X
                                        @endif
                                    </td>
                                    <td>
                                        @if($timesheet->check_out!=null)
                                            {{$timesheet->check_out}}
                                        @else
                                            X
                                        @endif
                                    <td>
{{--                                        <p data-placement="top" data-toggle="tooltip" title="Edit" class="bt-left">--}}
{{--                                            <a href="#" class="btn btn-primary btn-xs" >--}}
{{--                                                Cập nhật--}}
{{--                                            </a>--}}
{{--                                        </p>--}}
                                        <p data-placement="top" data-toggle="tooltip" title="Delete" class="bt-right">
                                            <a href="#" class="btn btn-danger btn-xs" data-title="Delete"
                                               data-toggle="modal" data-target="#delete{{$timesheet->id}}" >
                                                Xóa
                                            </a>
                                        </p>
                                        <div class="modal fade" id="delete{{$timesheet->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                                        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete timesheet?</div>

                                                    </div>
                                                    <div class="modal-footer ">
                                                        <a href="/deleteTimesheet/{{$timesheet->id}}" class="btn btn-danger" >
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

    <form id="export_excel" action="{{ url('export_excel') }}" method="post" style="display: hidden">
        @csrf
        <input name="month" type="hidden" value="" id="export_excel_month">
        <input name="yeah" type="hidden" value="" id="export_excel_yeah">
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            var start = '<?php echo $time[0]; ?>';
            var end = '<?php echo $time[2]; ?>';


            
            console.log(start + " " + end);
            
            function cb(start, end) {
                $('#reportrange').html(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
            }

            $('#export_excel').click(function(){
                var date = $('#reportrange').val();
                console.log(date);
                var month = parseInt(date[3] + date[4]);
                var yeah = parseInt(date[6] + date[7] + date[8] + date[9]);
                $('#export_excel_month').val(month);
                $('#export_excel_yeah').val(yeah);                
                // console.log(month + yeah);
                $('form[id="export_excel"]').submit();
            });


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
