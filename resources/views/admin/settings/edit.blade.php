@extends('layouts.admin')

@section('title', 'Edit Setting')

@section('breadcrumb')
    <span class="separator">/</span>
    <a href="{{ route('admin.settings.index') }}">Settings</a>
    <span class="separator">/</span>
    <span class="current">Edit</span>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Setting</h1>
        <p class="page-subtitle">Update system setting: <code>{{ $setting->key }}</code></p>
    </div>

    <div class="modern-card">
        <div class="modern-card-body">
            <form action="{{ route('admin.settings.update', $setting) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-modern">Key</label>
                        <input type="text" class="form-control-modern" value="{{ $setting->key }}" disabled>
                        <small class="text-muted">Setting key cannot be changed</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-modern">Type</label>
                        <input type="text" class="form-control-modern" value="{{ $setting->type }}" disabled>
                        <small class="text-muted">Setting type cannot be changed</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label-modern" for="value">Value <span class="text-danger">*</span></label>
                    @if($setting->type === 'boolean')
                        <select name="value" id="value" class="form-control-modern @error('value') is-invalid @enderror"
                            required>
                            <option value="true" {{ $setting->value === 'true' ? 'selected' : '' }}>Enabled</option>
                            <option value="false" {{ $setting->value === 'false' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    @elseif($setting->type === 'number')
                        <input type="number" name="value" id="value"
                            class="form-control-modern @error('value') is-invalid @enderror"
                            value="{{ old('value', $setting->value) }}" required>
                    @else
                        <textarea name="value" id="value" class="form-control-modern @error('value') is-invalid @enderror"
                            rows="3" required>{{ old('value', $setting->value) }}</textarea>
                    @endif
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label-modern" for="description">Description</label>
                    <textarea name="description" id="description"
                        class="form-control-modern @error('description') is-invalid @enderror"
                        rows="2">{{ old('description', $setting->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-modern btn-modern-success">
                        <i class="bi bi-check-circle"></i> Update Setting
                    </button>
                    <a href="{{ route('admin.settings.index') }}" class="btn-modern btn-modern-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection