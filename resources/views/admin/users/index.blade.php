@extends('layouts.admin')

@section('title', 'User Management')

@section('breadcrumb')
<span class="separator">/</span>
<span class="current">Users</span>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
    <div>
        <h1 class="page-title">User Management</h1>
        <p class="page-subtitle">Manage all users, customers, and staff members</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-modern btn-modern-primary">
        <i class="bi bi-person-plus"></i> Add New User
    </a>
</div>

<!-- Filters Card -->
<div class="modern-card mb-4">
    <div class="modern-card-body">
        <form action="{{ route('admin.users.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label-modern">Search Users</label>
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" class="form-control-modern" placeholder="Name, email, phone..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label-modern">Filter by Role</label>
                    <select name="role" class="form-control-modern">
                        <option value="">All Roles</option>
                        <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label-modern">Status</label>
                    <select name="status" class="form-control-modern">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-modern btn-modern-primary flex-grow-1">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn-modern btn-modern-secondary">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="modern-card">
    <div class="modern-card-header">
        <h3 class="modern-card-title">
            <i class="bi bi-people me-2"></i>
            All Users
        </h3>
        <span class="modern-badge modern-badge-primary">{{ $users->total() ?? 0 }} Total</span>
    </div>
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Contact</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users ?? [] as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="user-avatar">
                                <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                <div class="text-muted small">ID: #{{ $user->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="small">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-envelope text-muted"></i>
                                {{ $user->email }}
                            </div>
                            @if($user->phone)
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <i class="bi bi-telephone"></i>
                                {{ $user->phone }}
                            </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="modern-badge modern-badge-{{ 
                            $user->role->name == 'manager' ? 'danger' : 
                            ($user->role->name == 'staff' ? 'warning' : 'primary') 
                        }}">
                            {{ $user->role->display_name }}
                        </span>
                    </td>
                    <td>
                        <span class="modern-badge modern-badge-{{ $user->is_active ? 'success' : 'secondary' }}">
                            <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i>
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="small text-muted">
                            {{ $user->created_at->format('M d, Y') }}
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon btn-icon-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-icon btn-icon-{{ $user->is_active ? 'warning' : 'success' }}" title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="bi bi-{{ $user->is_active ? 'pause-circle' : 'play-circle' }}"></i>
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-icon-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <h5 class="empty-state-title">No users found</h5>
                            <p class="empty-state-text">Try adjusting your search or filter to find what you're looking for.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($users) && $users->hasPages())
    <div class="modern-card-footer">
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }
</style>
@endpush
@endsection
