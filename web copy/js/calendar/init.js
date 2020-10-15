document.addEventListener('DOMContentLoaded', function() {

    $.ajax({
        url: '/orders/calendar',
        type: 'POST',
        dataType: 'json',
        data: {'post': 1, _csrf: yii.getCsrfToken()},
        success: function (response) {
            var calendarEl = document.getElementById('calendar');
            var calendar  = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                themeSystem: 'materia',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                locale: {
                    code: "es",
                    week: {
                        dow: 1,
                        doy: 4 // The week that contains Jan 4th is the first week of the year.
                    },
                    buttonText: {
                        prev: "Ant",
                        next: "Sig",
                        today: "Hoy",
                        month: "Mes",
                        week: "Semana",
                        day: "Día",
                        list: "Agenda"
                    },
                    weekLabel: "S",
                    allDayHtml: "Todo<br/>el día",
                    eventLimitText: "más",
                    noEventsMessage: "No hay eventos para mostrar"
                },
                weekNumbers: true,
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events: response
            });

            calendar.render();
        }
    });


});