@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('complaints.index') }}">Complaints</a></li>
                        <li class="breadcrumb-item active" aria-current="page">#{{ $complaint->id }}</li>
                    </ol>
                </nav>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $complaint->subject }}</h4>
                        <span
                            class="badge {{ $complaint->status == 'resolved' ? 'bg-success' : ($complaint->status == 'in_progress' ? 'bg-info' : 'bg-warning text-dark') }}">
                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-2 text-muted small">
                            Submitted on {{ $complaint->created_at->format('M d, Y') }} at
                            {{ $complaint->created_at->format('H:i') }}
                        </div>

                        <div class="p-3 bg-light rounded mb-4">
                            {{ $complaint->message }}
                        </div>

                        @if($complaint->staff_response)
                            <div class="mt-4 pt-4 border-top">
                                <h5 class="mb-3 text-primary">
                                    <i class="bi bi-person-badge me-2"></i>Staff Response
                                </h5>
                                <div
                                    class="p-3 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded text-dark">
                                    {{ $complaint->staff_response }}
                                    <div class="mt-2 text-end text-muted small">
                                        Resolved on
                                        {{ $complaint->resolved_at ? $complaint->resolved_at->format('M d, Y') : '' }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('complaints.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection