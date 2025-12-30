@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>My Complaints</h1>
            <a href="{{ route('complaints.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Submit New Complaint
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($complaints->count() > 0)
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Date Submitted</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($complaints as $complaint)
                                <tr>
                                    <td>#{{ $complaint->id }}</td>
                                    <td>{{ $complaint->subject }}</td>
                                    <td>
                                        @if($complaint->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($complaint->status == 'in_progress')
                                            <span class="badge bg-info text-dark">In Progress</span>
                                        @else
                                            <span class="badge bg-success">Resolved</span>
                                        @endif
                                    </td>
                                    <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('complaints.show', $complaint) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($complaints->hasPages())
                    <div class="card-footer">
                        {{ $complaints->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-inbox text-muted display-1"></i>
                </div>
                <h3>No complaints found</h3>
                <p class="text-muted">You haven't submitted any complaints yet.</p>
                <a href="{{ route('complaints.create') }}" class="btn btn-primary mt-2">Submit a Complaint</a>
            </div>
        @endif
    </div>
@endsection