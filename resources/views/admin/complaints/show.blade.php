@extends('layouts.admin')

@section('title', 'Complaint Details')

@section('breadcrumb')
    <span class="separator">/</span>
    <a href="{{ route('admin.complaints.index') }}">Complaints</a>
    <span class="separator">/</span>
    <span class="current">#{{ $complaint->id }}</span>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="modern-card mb-4">
                <div class="modern-card-header d-flex justify-content-between align-items-center">
                    <h3 class="modern-card-title">Complaint Details</h3>
                    @if($complaint->status == 'pending')
                        <span class="modern-badge modern-badge-warning">Pending</span>
                    @elseif($complaint->status == 'in_progress')
                        <span class="modern-badge modern-badge-info">In Progress</span>
                    @else
                        <span class="modern-badge modern-badge-success">Resolved</span>
                    @endif
                </div>
                <div class="modern-card-body">
                    <div class="mb-4">
                        <label class="text-uppercase text-muted small fw-bold mb-1">Subject</label>
                        <h5 class="mb-0">{{ $complaint->subject }}</h5>
                    </div>

                    <div class="mb-4">
                        <label class="text-uppercase text-muted small fw-bold mb-1">Customer Message</label>
                        <div class="p-3 bg-light rounded text-dark">
                            {{ $complaint->message }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-uppercase text-muted small fw-bold mb-1">Submitted By</label>
                            <div>{{ $complaint->user->name }}</div>
                            <div class="small text-muted">{{ $complaint->user->email }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-uppercase text-muted small fw-bold mb-1">Date Submitted</label>
                            <div>{{ $complaint->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modern-card">
                <div class="modern-card-header">
                    <h3 class="modern-card-title">Resolution & Response</h3>
                </div>
                <div class="modern-card-body">
                    @if($complaint->status == 'resolved')
                        <div class="resolved-box p-3 border border-success rounded bg-success bg-opacity-10 mb-3">
                            <h6 class="text-success"><i class="bi bi-check-circle-fill me-2"></i>Resolved</h6>
                            <p class="mb-2">{{ $complaint->staff_response }}</p>
                            <div class="small text-muted border-top border-success border-opacity-25 pt-2 mt-2">
                                Resolved by <strong>{{ $complaint->resolver->name ?? 'Unknown Staff' }}</strong> on
                                {{ $complaint->resolved_at->format('M d, Y h:i A') }}
                            </div>
                        </div>
                        <div class="alert alert-info">
                            This complaint has been closed. To reopen or edit the response, please use the form below.
                        </div>
                    @endif

                    <form action="{{ route('admin.complaints.resolve', $complaint) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label-modern">Update Status</label>
                            <select name="status" class="form-select form-control-modern">
                                <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-modern">Response to Customer</label>
                            <textarea name="staff_response" rows="5" class="form-control-modern"
                                placeholder="Type your response here..."
                                required>{{ $complaint->staff_response }}</textarea>
                            <div class="form-text">This message will be visible to the customer.</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn-modern btn-modern-primary">
                                <i class="bi bi-send me-2"></i> Send Response & Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- User Info Card -->
            <div class="modern-card mb-4">
                <div class="modern-card-header">
                    <h3 class="modern-card-title">Customer Profile</h3>
                </div>
                <div class="modern-card-body text-center">
                    <div class="display-1 text-muted mb-3"><i class="bi bi-person-circle"></i></div>
                    <h5>{{ $complaint->user->name }}</h5>
                    <p class="text-muted">{{ $complaint->user->email }}</p>

                    <div class="d-grid mt-3">
                        <a href="{{ route('admin.users.edit', $complaint->user) }}"
                            class="btn-modern btn-modern-secondary btn-sm">View Full Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection