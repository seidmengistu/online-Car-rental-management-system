@extends('layouts.admin')

@section('title', 'System Settings')

@section('breadcrumb')
    <span class="separator">/</span>
    <span class="current">Settings</span>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h1 class="page-title">System Settings</h1>
            <p class="page-subtitle">Manage system-wide settings and policies</p>
        </div>
        <a href="{{ route('admin.settings.create') }}" class="btn-modern btn-modern-success">
            <i class="bi bi-plus-circle"></i> Add Setting
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @foreach($groupedSettings as $group => $settings)
        <div class="modern-card mb-4">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="bi bi-gear me-2"></i>
                    {{ ucfirst($group) }} Settings
                </h3>
                <span class="modern-badge modern-badge-primary">{{ $settings->count() }} settings</span>
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($settings as $setting)
                            <tr>
                                <td>
                                    <code class="text-primary">{{ $setting->key }}</code>
                                </td>
                                <td>
                                    @if($setting->type === 'boolean')
                                        <span
                                            class="modern-badge modern-badge-{{ $setting->value === 'true' ? 'success' : 'secondary' }}">
                                            {{ $setting->value === 'true' ? 'Enabled' : 'Disabled' }}
                                        </span>
                                    @else
                                        <span class="text-dark">{{ \Illuminate\Support\Str::limit($setting->value, 50) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="modern-badge modern-badge-info">{{ $setting->type }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $setting->description ?? 'No description' }}</small>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.settings.edit', $setting) }}"
                                            class="btn-modern btn-modern-primary btn-modern-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.settings.destroy', $setting) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this setting?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-modern btn-modern-danger btn-modern-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    @if($groupedSettings->isEmpty())
        <div class="modern-card">
            <div class="modern-card-body">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <h5 class="empty-state-title">No settings found</h5>
                    <p class="empty-state-text">Create your first system setting to get started.</p>
                    <a href="{{ route('admin.settings.create') }}" class="btn-modern btn-modern-primary">
                        <i class="bi bi-plus-circle"></i> Add Setting
                    </a>
                </div>
            </div>
        </div>
    @endif

@endsection