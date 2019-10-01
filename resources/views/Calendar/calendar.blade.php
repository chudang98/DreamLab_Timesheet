@extends('menu')
@section('css')



    <link rel='stylesheet' href='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css'>
    <link rel='stylesheet' href='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.3/css/mdb.min.css'>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/calendar/calendar.css')}}">

@endsection
@section('content')

    <div id='calendar'></div>
    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled tooltip">
    </span>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" style="opacity: 1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Thiết lập lịch</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="date" style="text-align: center">
                        <h4 id="date"></h4>
                    </div>
                    <form action="/addEvent" class="select-type" method="GET">
                        <input type="text" id="event-date" class="hidden" name="event-date">
                        <input type="radio" value="working" name="type" required id="radio-working"> Ngày làm việc
                        <br>
                        <div id="reason-working">
                            Lí do:
                            <input type="text" name="reason-working" id="input-reason-working" >
                        </div>
                        <br>
                        <input type="radio" value="off" name="type" required id="radio-off"> Ngày nghỉ
                        <br>
                        <div id="reason-off">
                            Lí do:
                            <input type="text" name="reason-off" id="input-reason-off">
                        </div>
                        <br>
                        <input type="radio" value="break" name="type" required id="radio-break"> Giờ nghỉ
                        <br> <br>
                        <div id="hour-minute">
                            <select name="hour-from" id="hour-from">
                                @for($i=0; $i<=23; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            :
                            <select name="minute-from" id="minute-from">
                                @for($i=0; $i<=60; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            đến
                            <select name="hour-to" id="hour-to">
                                @for($i=0; $i<=23; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            :
                            <select name="minute-to" id="minute-to">
                                @for($i=0; $i<=60; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <br>
                        <div id="reason-break">
                            Lí do:
                            <input type="text" name="reason-break" id="input-reason-break">
                        </div>
                        <br> <br>
                        <div class="button" style="text-align: center">
                            <button type="submit" class="btn btn-info" style="font-size: 12px">Lưu</button>
                            <button type="button" class="btn " data-dismiss="modal" style="font-size: 12px">Hủy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js"></script>
    <script src="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js"></script>
    <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.3/js/mdb.min.js"></script>
{{--    <script src="{{asset('js/calendar/calendar.js')}}"></script>--}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            let date;
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'vi',
                plugins: [ 'interaction', 'dayGrid','timeGrid' ],
                defaultView: 'dayGridMonth',
                defaultDate: '2019-09-12',
                selectable: true,
                firstDay: 1,
                dateClick: function(info) {
                    $('#exampleModal').modal('show');
                    date = info.dateStr;
                },
                eventRender: function(info) {
                    $(info.el).tooltip({
                        title: info.event.extendedProps.description,
                        placement: "top",
                        trigger: "hover",
                        container: "body"
                    });
                },
                events: [

                ]
            });

            // thêm sự kiện từ db
            let days = <?php echo json_encode($days) ?>;
            let n = <?php echo sizeof($days); ?>;
            for(let i=0; i<n; i++){
                if(days[i].state == 'working')
                    calendar.addEvent({
                        title: 'Ngày làm việc',
                        description: days[i].reason,
                        start:days[i].date
                    });
                else if(days[i].state == 'off')
                    calendar.addEvent({
                        title: 'Ngày nghỉ',
                        description: days[i].reason,
                        start:days[i].date
                    });
                else{
                    calendar.addEvent({
                        title: 'Giờ nghỉ',
                        description:'Từ '+days[i].startt_break+" đến "+
                            days[i].endt_break+" do "+days[i].reason,
                        start:days[i].date
                    });
                }
            }
            // set attribute modal
            $('#exampleModal').on('shown.bs.modal', function () {
                document.getElementById("date").innerHTML= date;
                document.getElementById("event-date").value = date;
                var kt =0;
                // view nếu update event
                for(let i=0; i<n; i++){
                    if(days[i].date == date){
                        kt=1;
                        if(document.getElementById('radio-working').value == days[i].state){
                            $("#radio-working").prop("checked", true);
                            document.getElementById('reason-working').style.display = "block";
                            document.getElementById('reason-off').style.display="none";
                            document.getElementById('hour-minute').style.display="none";
                            document.getElementById('reason-break').style.display="none";
                            document.getElementById('input-reason-working').value = days[i].reason;
                        }
                        else if(document.getElementById('radio-off').value == days[i].state){
                            $("#radio-off").prop("checked", true);
                            document.getElementById('reason-working').style.display = "none";
                            document.getElementById('reason-off').style.display="block";
                            document.getElementById('hour-minute').style.display="none";
                            document.getElementById('reason-break').style.display="none";
                            document.getElementById('input-reason-off').value = days[i].reason;
                        }
                        else if(document.getElementById('radio-break').value == days[i].state){
                            $("#radio-break").prop("checked", true);
                            document.getElementById('reason-working').style.display = "none";
                            document.getElementById('reason-off').style.display="none";
                            document.getElementById('hour-minute').style.display="block";
                            document.getElementById('reason-break').style.display="block";
                            document.getElementById('input-reason-break').value = days[i].reason;
                            var startt_break = days[i].startt_break.split(':');
                            var endt_break = days[i].endt_break.split(':');
                            var x= parseInt(startt_break[0], 10);
                            $('#hour-from').val( parseInt(startt_break[0], 10));
                            $('#minute-from').val( parseInt(startt_break[1], 10));
                            $('#hour-to').val( parseInt(endt_break[0], 10));
                            $('#minute-to').val( parseInt(endt_break[1], 10));
                        }
                    }
                }
                if(kt ==0 ){
                    $("#radio-working").prop("checked", false);
                    $("#radio-off").prop("checked", false);
                    $("#radio-break").prop("checked", false);
                    document.getElementById('reason-working').style.display = "none";
                    document.getElementById('reason-off').style.display="none";
                    document.getElementById('hour-minute').style.display="none";
                    document.getElementById('reason-break').style.display="none";
                }
            })
            //Set event radio
            $('input[type=radio][name=type]').change(function() {
                if (this.value == 'working') {
                    document.getElementById('reason-working').style.display = "block";
                    document.getElementById('reason-off').style.display="none";
                    document.getElementById('hour-minute').style.display="none";
                    document.getElementById('reason-break').style.display="none";
                }
                else if (this.value == 'off') {
                    document.getElementById('reason-working').style.display = "none";
                    document.getElementById('reason-off').style.display="block";
                    document.getElementById('hour-minute').style.display="none";
                    document.getElementById('reason-break').style.display="none";
                }
                else if (this.value == 'break') {
                    document.getElementById('reason-working').style.display = "none";
                    document.getElementById('reason-off').style.display="none";
                    document.getElementById('hour-minute').style.display="block";
                    document.getElementById('reason-break').style.display="block";
                }
            });


            calendar.render();
            document.querySelector('.fc-today-button').innerText
                = "Hôm nay";
        });

    </script>
@endsection
