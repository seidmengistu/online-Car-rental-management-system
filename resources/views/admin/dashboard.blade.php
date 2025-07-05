@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-lg-3 col-6">
    <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
        <h3>{{ $stats['total_customers'] ?? 0 }}</h3>
        <p>Customers</p>
                  </div>
                  <div class="icon">
                    <i class="bi bi-people"></i>
                  </div>
      <a href="{{ route('admin.users.index') }}?role=customer" class="small-box-footer">
        More info <i class="bi bi-arrow-right-circle"></i>
                  </a>
                </div>
              </div>
  <!-- ./col -->
              <div class="col-lg-3 col-6">
    <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
        <h3>{{ $stats['active_users'] ?? 0 }}</h3>
        <p>Active Users</p>
                  </div>
                  <div class="icon">
        <i class="bi bi-person-check"></i>
                  </div>
                  <a href="{{ route('admin.users.index') }}" class="small-box-footer">
        More info <i class="bi bi-arrow-right-circle"></i>
                  </a>
                </div>
              </div>
  <!-- ./col -->
              <div class="col-lg-3 col-6">
    <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
        <h3>{{ $stats['total_staff'] ?? 0 }}</h3>
        <p>Staff Members</p>
                  </div>
                  <div class="icon">
        <i class="bi bi-person-badge"></i>
                  </div>
      <a href="{{ route('admin.users.index') }}?role=staff" class="small-box-footer">
        More info <i class="bi bi-arrow-right-circle"></i>
                  </a>
                </div>
              </div>
  <!-- ./col -->
              <div class="col-lg-3 col-6">
    <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
        <h3>{{ $stats['total_managers'] ?? 0 }}</h3>
        <p>Managers</p>
                  </div>
                  <div class="icon">
        <i class="bi bi-person-lock"></i>
                  </div>
      <a href="{{ route('admin.users.index') }}?role=manager" class="small-box-footer">
        More info <i class="bi bi-arrow-right-circle"></i>
                  </a>
                </div>
              </div>
  <!-- ./col -->
            </div>
<!-- /.row -->

<!-- Quick Actions -->
            <div class="row">
  <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="bi bi-person-plus"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Add User</span>
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-info mt-2">Create</a>
                      </div>
                    </div>
                  </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="bi bi-car-front"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Add Car</span>
                <a href="{{ route('admin.cars.create') }}" class="btn btn-sm btn-success mt-2">Create</a>
              </div>
                      </div>
                    </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="bi bi-calendar-plus"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">New Booking</span>
                <a href="{{ route('admin.rentals.create') }}" class="btn btn-sm btn-warning mt-2">Create</a>
              </div>
            </div>
                  </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-danger"><i class="bi bi-graph-up"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">View Reports</span>
                <a href="{{ route('admin.reports') }}" class="btn btn-sm btn-danger mt-2">View</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection 