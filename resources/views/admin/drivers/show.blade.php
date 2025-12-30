@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($driver->image_path)
                        <img src="{{ asset('storage/' . $driver->image_path) }}" alt="{{ $driver->name }}"
                            class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 150px; height: 150px;">
                            <i class="bi bi-person fs-1 text-white"></i>
                        </div>
                    @endif
                    <h4>{{ $driver->name }}</h4>
                    <p class="text-muted">{{ $driver->phone }}</p>

                    @if($driver->status == 'active')
                        <span class="badge bg-success">Active</span>
                    @elseif($driver->status == 'on_trip')
                        <span class="badge bg-primary">On Trip</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>License Number</span>
                        <span class="fw-bold">{{ $driver->license_number }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Email</span>
                        <span>{{ $driver->email ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Joined</span>
                        <span>{{ $driver->created_at->format('M d, Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Trips</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Trip Type</th>
                                    <th>ID</th>
                                    <th>Vehicle</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Merge reservations and rentals or just rentals --}}
                                @forelse($driver->rentals()->latest()->take(5)->get() as $rental)
                                    <tr>
                                        <td>Rental</td>
                                        <td>#{{ $rental->id }}</td>
                                        <td>{{ $rental->car->make }} {{ $rental->car->model }}</td>
                                        <td>{{ $rental->start_date->format('M d, Y') }}</td>
                                        <td>{{ ucfirst($rental->status) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No recent rental trips found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Back to List</a>
                <a href="{{ route('admin.drivers.edit', $driver) }}" class="btn btn-warning">Edit Driver</a>
            </div>
        </div>
    </div>
@endsection