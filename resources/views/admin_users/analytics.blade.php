@extends('layouts.app')

@section('content')

    <head>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            .chart-container {
                max-width: 80%;
                margin: 40px auto;
                text-align: center;
            }

            canvas {
                max-width: 100%;
                height: 300px !important;
                margin-bottom: 10px;
            }

            .chart-controls {
                margin-bottom: 20px;
            }

            .chart-controls button,
            .chart-controls select {
                margin: 0 5px;
            }

            h2 {
                margin-bottom: 15px;
            }
        </style>
    </head>
    <div>
        <h1 class="text-center mt-4">Admin Analytics Dashboard</h1>
        <br>
        @if (Auth::user()->role == 'admin')
            <p class="text-center">Region: All Lebanon</p>
        @else
        <p class="text-center">Region: {{ Auth::user()->region }}</p>
        @endif
    </div>

    <div class="container">
        {{-- Brand Chart --}}
        <div class="chart-container">
            <h2>📊 Top 5 Reserved Brands</h2>
            <div class="chart-controls">
                <label for="brandChartType">Chart type:</label>
                <select id="brandChartType" aria-label="Select Brand Chart Type">
                    <option value="pie" selected>Pie</option>
                    <option value="doughnut">Doughnut</option>
                </select>
                <button onclick="downloadChart('brandPieChart')">Download PNG</button>
            </div>
            <canvas id="brandPieChart"></canvas>
        </div>

        {{-- User Chart --}}
        <div class="chart-container">
            <h2>👤 Top 5 Users by Reservations</h2>
            <div class="chart-controls">
                <label for="userChartType">Chart type:</label>
                <select id="userChartType" aria-label="Select User Chart Type">
                    <option value="bar" selected>Bar</option>
                    <option value="line">Line</option>
                </select>
                <button onclick="downloadChart('userBarChart')">Download PNG</button>
            </div>
            <canvas id="userBarChart"></canvas>
        </div>

        {{-- Trend Chart --}}
        <div class="chart-container">
            <h2>📅 Reservation Trends by Month</h2>
            <div class="chart-controls">
                <label for="trendChartType">Chart type:</label>
                <select id="trendChartType" aria-label="Select Trend Chart Type">
                    <option value="line" selected>Line</option>
                    <option value="bar">Bar</option>
                </select>
                <button onclick="downloadChart('trendLineChart')">Download PNG</button>
            </div>
            <canvas id="trendLineChart"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const brandLabels = {!! json_encode($topBrands->pluck('name')) !!};
            const brandData = {!! json_encode($topBrands->pluck('reservation_count')) !!};

            const userLabels = {!! json_encode($topUsers->pluck('name')) !!};
            const userData = {!! json_encode($topUsers->pluck('reservations_count')) !!};

            const trendLabels = {!! json_encode($reservationTrends->pluck('month')) !!};
            const trendData = {!! json_encode($reservationTrends->pluck('total')) !!};

            // Global chart objects so we can update & destroy
            let brandChart, userChart, trendChart;

            // Create initial charts with default types
            function createBrandChart(type) {
                if (brandChart) brandChart.destroy();
                brandChart = new Chart(document.getElementById('brandPieChart'), {
                    type: type,
                    data: {
                        labels: brandLabels,
                        datasets: [{
                            label: 'Reservations',
                            data: brandData,
                            backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#E91E63',
                                '#9C27B0'],
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }

            function createUserChart(type) {
                if (userChart) userChart.destroy();
                userChart = new Chart(document.getElementById('userBarChart'), {
                    type: type,
                    data: {
                        labels: userLabels,
                        datasets: [{
                            label: 'Reservations',
                            data: userData,
                            backgroundColor: (type === 'bar') ? '#42A5F5' :
                                'rgba(66, 165, 245, 0.5)',
                            borderColor: (type === 'line') ? '#42A5F5' : undefined,
                            fill: (type === 'line')
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            function createTrendChart(type) {
                if (trendChart) trendChart.destroy();
                trendChart = new Chart(document.getElementById('trendLineChart'), {
                    type: type,
                    data: {
                        labels: trendLabels,
                        datasets: [{
                            label: 'Monthly Reservations',
                            data: trendData,
                            borderColor: '#EF5350',
                            backgroundColor: (type === 'bar') ? '#EF5350' : 'transparent',
                            fill: false,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }

            // Initial load
            createBrandChart('pie');
            createUserChart('bar');
            createTrendChart('line');

            // Event listeners for selects
            document.getElementById('brandChartType').addEventListener('change', function() {
                createBrandChart(this.value);
            });

            document.getElementById('userChartType').addEventListener('change', function() {
                createUserChart(this.value);
            });

            document.getElementById('trendChartType').addEventListener('change', function() {
                createTrendChart(this.value);
            });
        });

        // Download chart as PNG
        function downloadChart(canvasId) {
            const canvas = document.getElementById(canvasId);
            const link = document.createElement('a');
            link.download = canvasId + '.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        }
    </script>
@endsection
