@extends('layouts.app')

@section('title', 'Return Rental')

@section('breadcrumb')
<span class="separator">/</span>
<a href="{{ route('rentals.index') }}">Rentals</a>
<span class="separator">/</span>
<span class="current">Return Car</span>
@endsection

@section('content')
<div class="container-fluid px-3 px-lg-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">Return {{ $rental->car->full_name }}</h3>
                        <p class="text-muted mb-0">Reservation #{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <a href="{{ route('rentals.show', $rental) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to rental
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Return details</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('rentals.return.submit', $rental) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="actual_end_date" class="form-label fw-semibold">Actual return date</label>
                            <input type="date" id="actual_end_date" name="actual_end_date" class="form-control @error('actual_end_date') is-invalid @enderror" value="{{ old('actual_end_date', $suggestedEnd) }}" required>
                            @error('actual_end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">
                                @if($isPaymentOnly)
                                    Return already recorded on {{ optional($rental->actual_end_date)->format('M d, Y') }}. Update only if the actual handover date changed.
                                @else
                                    You originally planned to return on {{ $rental->end_date->format('M d, Y') }}.
                                @endif
                            </small>
                        </div>
                        <div class="alert alert-info">
                            <strong>Heads up!</strong> Overdue fees are calculated automatically: daily rate ({{ number_format($rental->car->daily_rate, 2) }}) × days late.
                            @if($isPaymentOnly)
                                You currently owe ETB {{ number_format($rental->overdue_fee, 2) }}.
                            @else
                                Returning today would {{ $overduePreviewDays > 0 ? 'add ETB ' . number_format($overduePreviewFee, 2) : 'not incur any overdue fee' }}.
                            @endif
                        </div>
                        <div class="alert alert-secondary">
                            Payments for any overdue amount are handled through Chapa. After submitting this form, you'll be redirected to complete checkout if a fee is due.
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea name="overdue_payment_notes" rows="3" class="form-control @error('overdue_payment_notes') is-invalid @enderror" placeholder="Any additional context for our team...">{{ old('overdue_payment_notes') }}</textarea>
                            @error('overdue_payment_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check2-circle me-2"></i>Submit return &amp; pay with Chapa if needed
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Rental summary</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="text-muted text-uppercase small">Vehicle</span>
                        <h6 class="mb-0">{{ $rental->car->full_name }}</h6>
                        <small class="text-muted">Plate {{ $rental->car->plate_number }}</small>
                    </div>
                    <div class="mb-3">
                        <span class="text-muted text-uppercase small">Rental period</span>
                        <p class="mb-0">{{ $rental->start_date->format('M d, Y') }} – {{ $rental->end_date->format('M d, Y') }}</p>
                    </div>
                    <div class="mb-3">
                        <span class="text-muted text-uppercase small">Daily rate</span>
                        <p class="mb-0">ETB {{ number_format($rental->car->daily_rate, 2) }}</p>
                    </div>
                    <div class="alert alert-light border">
                        <strong>Total paid:</strong> Br {{ number_format($rental->total_amount, 2) }}<br>
                        <strong>Potential overdue:</strong> {{ $overduePreviewDays > 0 ? 'Br ' . number_format($overduePreviewFee, 2) : 'None if returned today' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

