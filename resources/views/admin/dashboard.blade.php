@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Visitor Analytics Dashboard</h2>
            <p class="text-muted">As of {{ now()->format('l, F j, Y g:i A') }}</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Visitors</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalVisitors }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                New Visitors Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $newVisitorsToday }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Check-ins Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCheckInsToday }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sign-in-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Check-outs Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCheckOutsToday }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sign-out-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Peak Hours Line Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Peak Hours Today</h6>
                </div>
                <div class="card-body">
                    <canvas id="peakHoursChart" style="height: 400px; width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Visitor Type Doughnut Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Visitor Type Distribution</h6>
                </div>
                <div class="card-body">
                    <canvas id="visitorTypeChart" style="height: 400px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const peakHoursData = @json($peakHours);
    const visitorTypeData = @json($visitorTypes);

    document.addEventListener('DOMContentLoaded', function () {
        // Prepare Peak Hours Chart Data
        const peakHoursLabels = Object.keys(peakHoursData).map(h => `${h}:00`);
        const peakHoursValues = Object.values(peakHoursData);

        new Chart(document.getElementById('peakHoursChart'), {
            type: 'line',
            data: {
                labels: peakHoursLabels,
                datasets: [{
                    label: 'Visitors',
                    data: peakHoursValues,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Visitors by Hour (Today)'
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Visitors'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Hour'
                        }
                    }
                }
            }
        });

        // Prepare Visitor Type Doughnut Chart
        const visitorTypeLabels = Object.keys(visitorTypeData);
        const visitorTypeCounts = Object.values(visitorTypeData);

        new Chart(document.getElementById('visitorTypeChart'), {
            type: 'doughnut',
            data: {
                labels: visitorTypeLabels,
                datasets: [{
                    data: visitorTypeCounts,
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Visitor Type Distribution'
                    },
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    });
</script>
@endsection
