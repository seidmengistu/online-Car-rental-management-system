@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('breadcrumb')
    <span class="separator">/</span>
    <span class="current">Activity Logs</span>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h1 class="page-title">Activity Logs</h1>
            <p class="page-subtitle">Monitor system activities and user actions</p>
        </div>
        <form action="{{ route('admin.logs.clear') }}" method="POST"
            onsubmit="return confirm('Are you sure you want to clear old logs?');">
            @csrf
            <button type="submit" class="btn-modern btn-modern-danger">
                <i class="bi bi-trash"></i> Clear Old Logs
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters Card -->
    <div class="modern-card mb-4">
        <div class="modern-card-body">
            <form action="{{ route('admin.logs.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label-modern">Search</label>
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" name="search" class="form-control-modern"
                                placeholder="Action or description..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label-modern">Action</label>
                        <select name="action" class="form-control-modern">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $action)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label-modern">User</label>
                        <select name="user_id" class="form-control-modern">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label-modern">From Date</label>
                        <input type="date" name="date_from" class="form-control-modern" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn-modern btn-modern-primary w-100">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.logs.index') }}" class="btn-modern btn-modern-secondary w-100">
                            <i class="bi bi-x-lg"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h3 class="modern-card-title">
                <i class="bi bi-clock-history me-2"></i>
                Activity History
            </h3>
            <span class="modern-badge modern-badge-primary">{{ $logs->total() }} logs</span>
        </div>
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>
                                <div class="small text-muted">{{ $log->created_at->format('M d, Y') }}</div>
                                <div class="fw-semibold">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td>
                                @if($log->user)
                                    <div class="fw-semibold text-dark">{{ $log->user->name }}</div>
                                    <div class="small text-muted">{{ $log->user->email }}</div>
                                @else
                                    <span class="text-muted">System</span>
                                @endif
                            </td>
                            <td>
                                <span class="modern-badge modern-badge-info">
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>
                            <td>
                                <div class="text-dark">{{ $log->description ?? 'No description' }}</div>
                                @if($log->model_type)
                                    <div class="small text-muted">
                                        <i class="bi bi-box"></i> {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <code class="small">{{ $log->ip_address ?? 'N/A' }}</code>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <h5 class="empty-state-title">No activity logs found</h5>
                                    <p class="empty-state-text">Activity logs will appear here as users interact with the
                                        system.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="modern-card-footer">
                <div class="d-flex justify-content-center">
                    {{ $logs->links() }}
                </div>
            </div>
        @endif
    </div>

@endsection