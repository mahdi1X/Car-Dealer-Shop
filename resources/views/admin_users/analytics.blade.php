@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(120deg, #e0e7ef 0%, #f8fafc 60%, #e0f7fa 100%);
            background-attachment: fixed;
        }

        .dashboard-bg {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(75, 139, 145, 0.10), 0 2px 8px rgba(0, 0, 0, 0.04);
            padding: 2.5rem 2rem 2rem 2rem;
            margin: 40px auto 0 auto;
            max-width: 1200px;
            position: relative;
        }

        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .dashboard-title {
            font-size: 2.3rem;
            font-weight: 700;
            color: #2b3a4a;
            letter-spacing: 1px;
        }

        .dashboard-region {
            font-size: 1.1rem;
            color: #4b8b91;
            background: #e0f7fa;
            border-radius: 8px;
            padding: 0.4rem 1.2rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(75, 139, 145, 0.06);
        }

        .dashboard-charts-row {
            display: flex;
            flex-wrap: wrap;
            gap: 2.5rem;
            justify-content: space-between;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(75, 139, 145, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
            padding: 2rem 1.5rem 1.5rem 1.5rem;
            flex: 1 1 440px;
            min-width: 440px;
            max-width: 540px;
            margin-bottom: 2rem;
            position: relative;
            transition: box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .dashboard-card:hover {
            box-shadow: 0 8px 32px rgba(75, 139, 145, 0.15), 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        .dashboard-card h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #4b8b91;
            margin-bottom: 1.2rem;
            letter-spacing: 0.5px;
        }

        .chart-controls {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: flex-end;
            width: 100%;
        }

        .chart-controls label {
            font-weight: 500;
            color: #4b8b91;
        }

        .chart-controls select,
        .chart-controls button {
            border-radius: 8px;
            border: 1px solid #e0e7ef;
            padding: 0.3rem 0.8rem;
            font-size: 1rem;
            background: #f8fafc;
            color: #2b3a4a;
            transition: background 0.2s;
        }

        .chart-controls button {
            background: #4b8b91;
            color: #fff;
            border: none;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(75, 139, 145, 0.08);
        }

        .chart-controls button:hover {
            background: #2196F3;
        }

        .dashboard-card .chart-canvas-wrapper {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 420px;
        }

        .dashboard-card canvas {
            margin: 0 auto;
            display: block;
            background: #f8fafc;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(75, 139, 145, 0.04);
            max-width: 100%;
            max-height: 420px;
            width: 100% !important;
            height: 420px !important;
        }

        @media (max-width: 1400px) {
            .dashboard-card {
                min-width: 320px;
                max-width: 100%;
            }
        }

        @media (max-width: 1200px) {
            .dashboard-charts-row {
                flex-direction: column;
                gap: 1.5rem;
            }

            .dashboard-card {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .dashboard-bg {
                padding: 1.2rem 0.5rem;
            }

            .dashboard-header {
                flex-direction: column;
                gap: 0.5rem;
            }

            .dashboard-card .chart-canvas-wrapper {
                min-height: 220px;
            }

            .dashboard-card canvas {
                height: 220px !important;
            }
        }
    </style>

    <div class="dashboard-bg">
        <div class="dashboard-header">
            <div class="dashboard-title">Admin Analytics Dashboard</div>
            <div class="dashboard-region">
                @if (Auth::user()->role == 'admin')
                    Region: All Lebanon
                @else
                    Region: {{ Auth::user()->region }}
                @endif
            </div>
        </div>

        <div class="dashboard-charts-row">
            {{-- Brand Chart --}}
            <div class="dashboard-card">
                <h2>📊 Top 5 Reserved Brands</h2>
                <div class="chart-controls">
                    <label for="brandChartType">Chart type:</label>
                    <select id="brandChartType" aria-label="Select Brand Chart Type">
                        <option value="pie" selected>Pie</option>
                        <option value="doughnut">Doughnut</option>
                    </select>
                    <button onclick="downloadChart('brandPieChart')">Download PNG</button>
                </div>
                <div class="chart-canvas-wrapper">
                    <canvas id="brandPieChart"></canvas>
                </div>
            </div>

            {{-- User Chart --}}
            <div class="dashboard-card">
                <h2>👤 Top 5 Users by Reservations</h2>
                <div class="chart-controls">
                    <label for="userChartType">Chart type:</label>
                    <select id="userChartType" aria-label="Select User Chart Type">
                        <option value="bar" selected>Bar</option>
                        <option value="line">Line</option>
                    </select>
                    <button onclick="downloadChart('userBarChart')">Download PNG</button>
                </div>
                <div class="chart-canvas-wrapper">
                    <canvas id="userBarChart"></canvas>
                </div>
            </div>

            {{-- Trend Chart --}}
            <div class="dashboard-card">
                <h2>📅 Reservation Trends by Month</h2>
                <div class="chart-controls">
                    <label for="trendChartType">Chart type:</label>
                    <select id="trendChartType" aria-label="Select Trend Chart Type">
                        <option value="line" selected>Line</option>
                        <option value="bar">Bar</option>
                    </select>
                    <button onclick="downloadChart('trendLineChart')">Download PNG</button>
                </div>
                <div class="chart-canvas-wrapper">
                    <canvas id="trendLineChart"></canvas>
                </div>
            </div>

            {{-- Reservations by Region --}}
            <div class="dashboard-card">
                <h2>📍 Reservations by Region</h2>
                <div class="chart-controls">
                    <label for="regionChartType">Chart type:</label>
                    <select id="regionChartType" aria-label="Select Region Chart Type">
                        <option value="bar" selected>Bar</option>
                        <option value="pie">Pie</option>
                        <option value="doughnut">Doughnut</option>
                    </select>
                    <button onclick="downloadChart('regionChart')">Download PNG</button>
                </div>
                <div class="chart-canvas-wrapper">
                    <canvas id="regionChart"></canvas>
                </div>
            </div>

            {{-- Reservations per Month by State --}}
            <div class="dashboard-card">
                <h2>📊 Reservations per Month by State</h2>
                <div class="chart-controls">
                    <label for="stateMonthChartType">Chart type:</label>
                    <select id="stateMonthChartType" aria-label="Select State Month Chart Type">
                        <option value="bar" selected>Bar</option>
                        <option value="line">Line</option>
                    </select>
                    <button onclick="downloadChart('stateMonthChart')">Download PNG</button>
                </div>
                <div class="chart-canvas-wrapper">
                    <canvas id="stateMonthChart"></canvas>
                </div>
            </div>

            {{-- User Growth Over Time --}}
            <div class="dashboard-card">
                <h2>📈 User Growth Over Time</h2>
                <div class="chart-controls">
                    <label for="userGrowthChartType">Chart type:</label>
                    <select id="userGrowthChartType" aria-label="Select User Growth Chart Type">
                        <option value="line" selected>Line</option>
                        <option value="bar">Bar</option>
                    </select>
                    <button onclick="downloadChart('userGrowthChart')">Download PNG</button>
                </div>
                <div class="chart-canvas-wrapper">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>

            {{-- Reservation Status Distribution --}}
            <div class="dashboard-card">
                <h2>🗂️ Reservation Status Distribution</h2>
                <div class="chart-controls">
                    <label for="statusChartType">Chart type:</label>
                    <select id="statusChartType" aria-label="Select Status Chart Type">
                        <option value="pie" selected>Pie</option>
                        <option value="doughnut">Doughnut</option>
                        <option value="bar">Bar</option>
                    </select>
                    <button onclick="downloadChart('statusChart')">Download PNG</button>
                </div>
                <div class="chart-canvas-wrapper">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            {{-- Average Reservation Value by Brand --}}
            <div class="dashboard-card">
                <h2>💰 Avg Reservation Value by Brand</h2>
                <div class="chart-controls">
                    <label for="avgPriceBrandChartType">Chart type:</label>
                    <select id="avgPriceBrandChartType" aria-label="Select Avg Price Brand Chart Type">
                        <option value="bar" selected>Bar</option>
                        <option value="pie">Pie</option>
                        <option value="doughnut">Doughnut</option>
                    </select>
                    <button onclick="downloadChart('avgPriceBrandChart')">Download PNG</button>
                </div>
                <div class="chart-canvas-wrapper">
                    <canvas id="avgPriceBrandChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const brandLabels = {!! json_encode($topBrands->pluck('name')) !!};
            const brandData = {!! json_encode($topBrands->pluck('reservation_count')) !!};

            const userLabels = {!! json_encode($topUsers->pluck('name')) !!};
            const userData = {!! json_encode($topUsers->pluck('reservations_count')) !!};

            const trendLabels = {!! json_encode($reservationTrends->pluck('month')) !!};
            const trendData = {!! json_encode($reservationTrends->pluck('total')) !!};

            // New charts data
            const regionLabels = {!! json_encode($reservationsByRegion ? $reservationsByRegion->keys() : []) !!};
            const regionData = {!! json_encode($reservationsByRegion ? $reservationsByRegion->values() : []) !!};

            const userGrowthLabels = {!! json_encode($userGrowth ? $userGrowth->pluck('month') : []) !!};
            const userGrowthData = {!! json_encode($userGrowth ? $userGrowth->pluck('total') : []) !!};

            const statusLabels = {!! json_encode($stateCounts ? $stateCounts->keys() : []) !!};
            const statusData = {!! json_encode($stateCounts ? $stateCounts->values() : []) !!};

            const avgPriceBrandLabels = {!! json_encode($avgPriceByBrand ? $avgPriceByBrand->keys() : []) !!};
            const avgPriceBrandData = {!! json_encode($avgPriceByBrand ? $avgPriceByBrand->values() : []) !!};

            // Add stateMonthChart data from controller
            const stateMonthLabels = {!! json_encode($reservationsPerMonthByState['labels'] ?? []) !!};
            const stateMonthDatasets = {!! json_encode($reservationsPerMonthByState['datasets'] ?? []) !!};

            // Chart objects for dynamic type switching
            let brandChart, userChart, trendChart, regionChart, userGrowthChart, statusChart, avgPriceBrandChart,
                stateMonthChart;

            // Brand Chart
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
                                '#9C27B0'
                            ],
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }
            createBrandChart('pie');
            document.getElementById('brandChartType').addEventListener('change', function() {
                createBrandChart(this.value);
            });

            // User Chart
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
            createUserChart('bar');
            document.getElementById('userChartType').addEventListener('change', function() {
                createUserChart(this.value);
            });

            // Trend Chart
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
                            fill: type === 'bar',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }
            createTrendChart('line');
            document.getElementById('trendChartType').addEventListener('change', function() {
                createTrendChart(this.value);
            });

            // Reservations by Region
            function createRegionChart(type) {
                if (regionChart) regionChart.destroy();
                regionChart = new Chart(document.getElementById('regionChart'), {
                    type: type,
                    data: {
                        labels: regionLabels,
                        datasets: [{
                            label: 'Reservations',
                            data: regionData,
                            backgroundColor: ['#4b8b91', '#2196F3', '#FFC107', '#E91E63', '#9C27B0',
                                '#EF5350', '#8BC34A', '#FF9800'
                            ]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }
            createRegionChart('bar');
            document.getElementById('regionChartType').addEventListener('change', function() {
                createRegionChart(this.value);
            });

            // Reservations per Month by State
            function createStateMonthChart(type) {
                if (stateMonthChart) stateMonthChart.destroy();
                stateMonthChart = new Chart(document.getElementById('stateMonthChart'), {
                    type: type,
                    data: {
                        labels: stateMonthLabels,
                        datasets: stateMonthDatasets
                    },
                    options: {
                        responsive: true
                    }
                });
            }
            createStateMonthChart('bar');
            document.getElementById('stateMonthChartType').addEventListener('change', function() {
                createStateMonthChart(this.value);
            });

            // User Growth Over Time
            function createUserGrowthChart(type) {
                if (userGrowthChart) userGrowthChart.destroy();
                userGrowthChart = new Chart(document.getElementById('userGrowthChart'), {
                    type: type,
                    data: {
                        labels: userGrowthLabels,
                        datasets: [{
                            label: 'New Users',
                            data: userGrowthData,
                            borderColor: '#9C27B0',
                            backgroundColor: 'rgba(156,39,176,0.1)',
                            fill: type === 'line',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }
            createUserGrowthChart('line');
            document.getElementById('userGrowthChartType').addEventListener('change', function() {
                createUserGrowthChart(this.value);
            });

            // Reservation Status Distribution
            function createStatusChart(type) {
                if (statusChart) statusChart.destroy();
                statusChart = new Chart(document.getElementById('statusChart'), {
                    type: type,
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            label: 'Reservations',
                            data: statusData,
                            backgroundColor: ['#4CAF50', '#FFC107', '#EF5350', '#2196F3']
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }
            createStatusChart('pie');
            document.getElementById('statusChartType').addEventListener('change', function() {
                createStatusChart(this.value);
            });

            // Average Reservation Value by Brand
            function createAvgPriceBrandChart(type) {
                if (avgPriceBrandChart) avgPriceBrandChart.destroy();
                avgPriceBrandChart = new Chart(document.getElementById('avgPriceBrandChart'), {
                    type: type,
                    data: {
                        labels: avgPriceBrandLabels,
                        datasets: [{
                            label: 'Avg Price',
                            data: avgPriceBrandData,
                            backgroundColor: ['#FFC107', '#4b8b91', '#2196F3', '#E91E63', '#9C27B0',
                                '#EF5350', '#8BC34A', '#FF9800'
                            ]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }
            createAvgPriceBrandChart('bar');
            document.getElementById('avgPriceBrandChartType').addEventListener('change', function() {
                createAvgPriceBrandChart(this.value);
            });

            // Reservations by User Region
            function createUserRegionChart(type) {
                if (userRegionChart) userRegionChart.destroy();
                userRegionChart = new Chart(document.getElementById('userRegionChart'), {
                    type: type,
                    data: {
                        labels: userRegionLabels,
                        datasets: [{
                            label: 'Reservations',
                            data: userRegionData,
                            backgroundColor: ['#42A5F5', '#FFC107', '#4CAF50', '#E91E63', '#9C27B0',
                                '#EF5350', '#8BC34A', '#FF9800'
                            ]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }
            createUserRegionChart('bar');
            document.getElementById('userRegionChartType').addEventListener('change', function() {
                createUserRegionChart(this.value);
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
