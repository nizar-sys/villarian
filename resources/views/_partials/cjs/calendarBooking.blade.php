<script>
    $(document).ready(()=>{
        var date = new Date()
        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        var containerEl = document.getElementById('external-events');
        var checkbox = document.getElementById('drop-remove');
        var calendarEl = document.getElementById('calendar');
        var calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left  : 'prev,next today',
            center: 'title',
            right : 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        themeSystem: 'bootstrap',
        //Random default events
        events: [
            @foreach($villa->bookings()->get() as $booking)
            {
            title          : 'Disewa {{$booking->nama_pemesan}}' ,
            start          : new Date("{{date('Y-m-d', strtotime($booking->tanggal_checkin))}}"),
            end            : new Date("{{date('Y-m-d', strtotime($booking->tanggal_checkout))}}"),
            backgroundColor: '#f39c12', //yellow
            borderColor    : '#f39c12', //yellow,
                
            },

            @endForeach
        ],
        editable  : false,
        droppable : false, // this allows things to be dropped onto the calendar !!!
        drop      : function(info) {
            // is the "remove after drop" checkbox checked?
            if (checkbox.checked) {
            // if so, remove the element from the "Draggable Events" list
            info.draggedEl.parentNode.removeChild(info.draggedEl);
            }
        },
        // change lang to in
        locale: 'id',
        });

        calendar.render();
    })
</script>