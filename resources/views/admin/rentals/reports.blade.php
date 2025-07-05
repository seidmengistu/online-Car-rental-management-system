@extends('layouts.app')

@section('title', 'Rental Reports')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3">Rental Reports</h1>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filter Reports</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.reports') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="month">Month</label>
                                    <select name="month" id="month" class="form-control">
                                        <option value="all" {{ $month === 'all' ? 'selected' : '' }}>All Months</option>
                                        @for($i = 0; $i < 12; $i++)
                                            @php 
                                                $monthValue = now()->startOfYear()->addMonths($i)->format('Y-m');
                                                $monthLabel = now()->startOfYear()->addMonths($i)->format('F Y');
                                            @endphp
                                            <option value="{{ $monthValue }}" {{ $month === $monthValue ? 'selected' : '' }}>
                                                {{ $monthLabel }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <select name="year" id="year" class="form-control">
                                        @for($i = now()->year; $i >= now()->year - 5; $i--)
                                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Statistics -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Monthly Statistics</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $monthlyStats->total_rentals ?? 0 }}</h3>
                                    <p>Total Rentals</p>
                                </div>
                                <div class="icon">
                                    <i class="bi bi-car-front"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>${{ number_format($monthlyStats->total_revenue ?? 0, 2) }}</h3>
                                    <p>Total Revenue</p>
                                </div>
                                <div class="icon">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>${{ number_format($monthlyStats->avg_rental_amount ?? 0, 2) }}</h3>
                                    <p>Average Rental Amount</p>
                                </div>
                                <div class="icon">
                                    <i class="bi bi-calculator"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="bi bi-car-front"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Active Rentals</span>
                                    <span class="info-box-number">{{ $monthlyStats->active_rentals ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="bi bi-check-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Completed Rentals</span>
                                    <span class="info-box-number">{{ $monthlyStats->completed_rentals ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="bi bi-exclamation-triangle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Overdue Rentals</span>
                                    <span class="info-box-number">{{ $monthlyStats->overdue_rentals ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Rented Cars -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top Rented Cars</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Car</th>
                                <th>Rental Count</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topCars as $car)
                            <tr>
                                <td>{{ $car->car->full_name ?? 'Unknown Car' }}</td>
                                <td>{{ $car->rental_count }}</td>
                                <td>${{ number_format($car->total_revenue, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Rentals -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Rentals</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Car</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRentals as $rental)
                            <tr>
                                <td>{{ $rental->id }}</td>
                                <td>{{ $rental->user->name ?? 'Unknown User' }}</td>
                                <td>{{ $rental->car->full_name ?? 'Unknown Car' }}</td>
                                <td>
                                    <span class="badge bg-{{ $rental->status === 'active' ? 'success' : ($rental->status === 'overdue' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                </td>
                                <td>${{ number_format($rental->total_amount, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No recent rentals</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 