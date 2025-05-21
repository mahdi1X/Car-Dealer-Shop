@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center fancy-title">My Reservation Calendar</h2>
    
    <div id="reservation-calendar"></div>
</div>

<!-- FullCalendar CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('reservation-calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 650,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: '{{ route("reservations.events") }}', // dynamically fetched
        });

        calendar.render();
        
    });
</script>



<style>
    #reservation-calendar {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .fancy-title {
        font-family: 'Barlow', sans-serif;
        font-weight: 600;
        font-size: 2rem;
        border-bottom: 3px solid #4b8b91;
        display: inline-block;
        padding-bottom: 8px;
        margin-bottom: 20px;
        color: #333;
    }
</style>
@endsection
