@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Drivers Management</h3>
                    <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Add New Driver
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.drivers.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search by name, email, phone..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">All Statuses</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                    <option value="on_trip" {{ request('status') == 'on_trip' ? 'selected' : '' }}>On Trip
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary w-100">Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>License Number</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($drivers as $driver)
                                    <tr>
                                        <td>{{ $driver->id }}</td>
                                        <td>
                                            @if($driver->image_path)
                                                <img src="{{ asset('storage/' . $driver->image_path) }}" alt="{{ $driver->name }}"
                                                    class="img-thumbnail" width="50">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $driver->name }}</td>
                                        <td>{{ $driver->phone }}</td>
                                        <td>{{ $driver->license_number }}</td>
                                        <td>
                                            @if($driver->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @elseif($driver->status == 'on_trip')
                                                <span class="badge bg-primary">On Trip</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.drivers.show', $driver) }}" class="btn btn-sm btn-info"
                                                title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.drivers.edit', $driver) }}" class="btn btn-sm btn-warning"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No drivers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $drivers->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection