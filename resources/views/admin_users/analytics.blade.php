@extends('layouts.app') {{-- or admin layout if you have one --}}

@section('content')
<head>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Resize canvas with CSS */
        canvas {
            max-width: 80%; /* Makes the charts smaller */
            height: 300px;  /* Adjust height as needed */
            margin: auto;
        }
    </style>
</head>

<div class="container">
    <h2>📊 Top 5 Reserved Brands (Pie Chart)</h2>
    <canvas id="brandPieChart"></canvas>

    <h2>👤 Top 5 Users by Reservations (Bar Chart)</h2>
    <canvas id="userBarChart"></canvas>

    <h2>📅 Reservation Trends by Month (Line Chart)</h2>
    <canvas id="trendLineChart"></canvas>
</div>

<script>
    // Ensure that the script runs after the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Passing the data to JavaScript variables
        const brandLabels = {!! json_encode($topBrands->pluck('name')) !!};
        const brandData = {!! json_encode($topBrands->pluck('reservation_count')) !!};

        const userLabels = {!! json_encode($topUsers->pluck('name')) !!};
        const userData = {!! json_encode($topUsers->pluck('reservations_count')) !!};

        const trendLabels = {!! json_encode($reservationTrends->pluck('month')) !!};
        const trendData = {!! json_encode($reservationTrends->pluck('total')) !!};

        // Pie chart - Top Reserved Brands
        new Chart(document.getElementById('brandPieChart'), {
            type: 'pie',
            data: {
                labels: brandLabels,
                datasets: [{
                    label: 'Reservations',
                    data: brandData,
                    backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#E91E63', '#9C27B0'],
                }]
            }
        });

        // Bar chart - Top Users by Reservations
        new Chart(document.getElementById('userBarChart'), {
            type: 'bar',
            data: {
                labels: userLabels,
                datasets: [{
                    label: 'Reservations',
                    data: userData,
                    backgroundColor: '#42A5F5',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Line chart - Monthly Reservation Trends
        new Chart(document.getElementById('trendLineChart'), {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Monthly Reservations',
                    data: trendData,
                    borderColor: '#EF5350',
                    fill: false,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true
            }
        });
    });
</script>

@endsection
