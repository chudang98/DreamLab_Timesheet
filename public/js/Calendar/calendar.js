document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'vi',
        plugins: [ 'interaction', 'dayGrid','timeGrid' ],
        defaultView: 'dayGridMonth',
        // defaultDate: '2019-09-12',
        selectable: true,
        firstDay: 1,
        dateClick: function(info) {
            // alert('clicked ' + info.dateStr);
            content ="";
            content += "<h3>Thiết lập lịch</h3>" +
                "<div style='text-align: center'> infor.dateStr</div>"+
                "<form><input type=\"radio\" id=\"myRadio\">Nam <input type=\"radio\" id=\"myRadio\">Nữ" +
                "<button>Submit</button></form>";
            alert(content);
        },
        eventRender: function(info) {
            var tooltip = new Tooltip(info.el, {
                title: info.event.extendedProps.description,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
        },

        events: [
            {
                title: 'All Day Event',
                description: 'description for All Day Event',
                start: '2019-09-01'
            },
            {
                title: 'Long Event',
                description: 'description for Long Event',
                start: '2019-09-07',
                end: '2019-09-10'
            },
            {
                groupId: '999',
                title: 'Repeating Event',
                description: 'description for Repeating Event',
                start: '2019-09-09T16:00:00'
            },
            {
                groupId: '999',
                title: 'Repeating Event',
                description: 'description for Repeating Event',
                start: '2019-09-16T16:00:00'
            },
            {
                title: 'Conference',
                description: 'description for Conference',
                start: '2019-09-11',
                end: '2019-09-13'
            },
            {
                title: 'Meeting',
                description: 'description for Meeting',
                start: '2019-09-12T10:30:00',
                end: '2019-09-12T12:30:00'
            },
            {
                title: 'Lunch',
                description: 'description for Lunch',
                start: '2019-09-12T12:00:00'
            },
            {
                title: 'Meeting',
                description: 'description for Meeting',
                start: '2019-09-12T14:30:00'
            },
            {
                title: 'Birthday Party',
                description: 'description for Birthday Party',
                start: '2019-09-13T07:00:00'
            },
            {
                title: 'Click for Google',
                description: 'description for Click for Google',
                url: 'http://google.com/',
                start: '2019-09-28'
            }
        ]
    });

    calendar.render();
    document.querySelector('.fc-today-button').innerText
        = "Hôm nay";
});
