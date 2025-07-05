@extends('layouts.admin')

@section('title', 'Reports')

@section('breadcrumb')
<li class="breadcrumb-item active">Reports</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3">Reports</h1>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalUsers ?? 0 }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="bi bi-people"></i>
                </div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                    More info <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalCars ?? 0 }}</h3>
                    <p>Total Cars</p>
                </div>
                <div class="icon">
                    <i class="bi bi-car-front"></i>
                </div>
                <a href="{{ route('admin.cars.index') }}" class="small-box-footer">
                    More info <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalReservations ?? 0 }}</h3>
                    <p>Total Reservations</p>
                </div>
                <div class="icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <a href="{{ route('admin.reservations.index') }}" class="small-box-footer">
                    More info <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalRentals ?? 0 }}</h3>
                    <p>Total Rentals</p>
                </div>
                <div class="icon">
                    <i class="bi bi-key"></i>
                </div>
                <a href="{{ route('admin.rentals.index') }}" class="small-box-footer">
                    More info <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Revenue Charts -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Monthly Revenue</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="revenueChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reservation Status</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="reservationStatusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Export Reports</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.reports') }}?export=users" class="btn btn-outline-primary btn-block">
                                <i class="bi bi-people me-2"></i> Export Users
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.reports') }}?export=cars" class="btn btn-outline-success btn-block">
                                <i class="bi bi-car-front me-2"></i> Export Cars
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.reports') }}?export=reservations" class="btn btn-outline-warning btn-block">
                                <i class="bi bi-calendar-check me-2"></i> Export Reservations
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.reports') }}?export=rentals" class="btn btn-outline-danger btn-block">
                                <i class="bi bi-key me-2"></i> Export Rentals
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Monthly Revenue',
                    data: {{ json_encode($monthlyRevenue ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) }},
                    borderColor: '#17a2b8',
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Reservation Status Chart
        const reservationCtx = document.getElementById('reservationStatusChart').getContext('2d');
        new Chart(reservationCtx, {
            type: 'pie',
            data: {
                labels: ['Pending', 'Confirmed', 'Cancelled', 'Completed'],
                datasets: [{
                    data: {{ json_encode($reservationStatusCounts ?? [0, 0, 0, 0]) }},
                    backgroundColor: ['#ffc107', '#28a745', '#dc3545', '#17a2b8']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endpush
@endsection 