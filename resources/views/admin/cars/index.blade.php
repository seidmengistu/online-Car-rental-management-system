@extends('layouts.admin')

@section('title', 'Car Management')

@section('breadcrumb')
<li class="breadcrumb-item active">Car Management</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-6">
            <h1 class="h3">Car Management</h1>
        </div>
        <div class="col-6 text-right">
            <a href="{{ route('admin.cars.create') }}" class="btn btn-success float-end">
                <i class="bi bi-plus-circle"></i> Add New Car
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Cars</h3>
            <div class="card-tools">
                <form action="{{ route('admin.cars.index') }}" method="GET" class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Color</th>
                        <th>Seats</th>
                        <th>Daily Rate</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars ?? [] as $car)
                    <tr>
                        <td>{{ $car->id }}</td>
                        <td>{{ $car->make }}</td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->year }}</td>
                        <td>{{ $car->color }}</td>
                        <td>{{ $car->seats }}</td>
                        <td>${{ number_format($car->daily_rate, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $car->is_available ? 'success' : 'danger' }}">
                                {{ $car->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.cars.toggle-availability', $car) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-{{ $car->is_available ? 'warning' : 'success' }}">
                                        <i class="bi bi-{{ $car->is_available ? 'slash-circle' : 'check-circle' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this car?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No cars found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($cars) && $cars->hasPages())
        <div class="card-footer clearfix">
            {{ $cars->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 