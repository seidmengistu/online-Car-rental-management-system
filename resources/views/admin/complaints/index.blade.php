@extends('layouts.admin')

@section('title', 'Complaints')

@section('breadcrumb')
    <span class="separator">/</span>
    <span class="current">Complaints</span>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">Customer Complaints</h1>
        <p class="page-subtitle">Manage and resolve customer issues</p>
    </div>

    <!-- Filters -->
    <div class="modern-card mb-4">
        <div class="modern-card-body">
            <form action="{{ route('admin.complaints.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label-modern">Search</label>
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" name="search" class="form-control-modern"
                                placeholder="Search subject, message, or user..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-modern">Status</label>
                        <select name="status" class="form-select form-control-modern">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress
                            </option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn-modern btn-modern-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('admin.complaints.index') }}"
                            class="btn-modern btn-modern-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Complaints Table -->
    <div class="modern-card">
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                        <tr>
                            <td>#{{ $complaint->id }}</td>
                            <td>
                                <div>{{ $complaint->user->name }}</div>
                                <div class="small text-muted">{{ $complaint->user->email }}</div>
                            </td>
                            <td>{{ Str::limit($complaint->subject, 40) }}</td>
                            <td>
                                @if($complaint->status == 'pending')
                                    <span class="modern-badge modern-badge-warning">Pending</span>
                                @elseif($complaint->status == 'in_progress')
                                    <span class="modern-badge modern-badge-info">In Progress</span>
                                @else
                                    <span class="modern-badge modern-badge-success">Resolved</span>
                                @endif
                            </td>
                            <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.complaints.show', $complaint) }}"
                                    class="btn-modern btn-modern-primary btn-sm">
                                    Manage
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">No complaints found.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($complaints->hasPages())
            <div class="modern-card-footer">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>
@endsection