@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0">Submit a Complaint</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('complaints.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject"
                                    name="subject" value="{{ old('subject') }}" required
                                    placeholder="Brief summary of the issue">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Description</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message"
                                    name="message" rows="6" required
                                    placeholder="Please describe your issue in detail...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('complaints.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit Complaint</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection