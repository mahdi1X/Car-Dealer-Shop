@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <br><br>
        <h2 class="mb-4 text-center fancy-title">My Reservation Calendar</h2>

        <div id="calendar-loading" class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div id="reservation-calendar" style="display: block;"></div>
    </div>

    <!-- FullCalendar CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
    <!-- Add Bootstrap JS for tooltip support -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('reservation-calendar');
            const loadingEl = document.getElementById('calendar-loading');

            // Initially hide calendar, show loading
            calendarEl.style.display = 'none';
            loadingEl.style.display = 'block';

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                height: 'auto',
                nowIndicator: true,
                navLinks: true,
                eventDisplay: 'block',

                events: {
                    url: '{{ route('reservations.events') }}',
                    method: 'GET',
                    failure: function() {
                        alert('Failed to load events. Please try again.');
                    }
                },

                loading: function(isLoading) {
                    if (isLoading) {
                        loadingEl.style.display = 'block';
                        calendarEl.style.display = 'none';
                    } else {
                        loadingEl.style.display = 'none';
                        calendarEl.style.display = 'block';
                    }
                },

                eventDidMount: function(info) {
                    new bootstrap.Tooltip(info.el, {
                        title: `${info.event.title}\n${info.event.start ? info.event.start.toLocaleDateString() : ''} - ${info.event.end ? info.event.end.toLocaleDateString() : ''}`,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                },

                eventClick: function(info) {
                    // Navigate to the reservation view route
                    window.location.href = '{{ url('reservations') }}/' + info.event.id + '/view';
                },
            });

            calendar.render();

            // Auto refresh events every 60 seconds
            setInterval(() => {
                calendar.refetchEvents();
            }, 60000);
        });
    </script>

    <style>
        #reservation-calendar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .fancy-title {
            font-family: 'Barlow', sans-serif;
            font-weight: 600;
            font-size: 2rem;
            border-bottom: 3px solid #4b8b91;
            display: inline-block;
            padding-bottom: 8px;
            color: #333;
        }

        .fc-event {
            cursor: pointer;
            border-radius: 4px;
        }

        .fc-daygrid-event-dot {
            display: none;
        }

        @media (max-width: 768px) {
            .fc-header-toolbar {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
@endsection
