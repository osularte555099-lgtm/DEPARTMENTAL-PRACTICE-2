@extends('layouts.app')

@section('title', $equipment->equipment_name . ' - Equipment Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-info-circle text-info me-2"></i>Equipment Details</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
                <a href="{{ route('equipment.edit', $equipment) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
            </div>
        </div>

        <div class="card card-custom">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="badge bg-light text-dark border fs-6">{{ $equipment->category }}</span>
                @if($equipment->availability_status === 'Available')
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6">
                        <i class="bi bi-check-circle me-1"></i> Available
                    </span>
                @else
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fs-6">
                        <i class="bi bi-x-circle me-1"></i> Unavailable
                    </span>
                @endif
            </div>

            <div class="card-body p-4">
                <h3 class="fw-bold text-dark">{{ $equipment->equipment_name }}</h3>
                <h4 class="text-success fw-bold mb-4">${{ number_format($equipment->unit_price, 2) }}</h4>

                <h6 class="fw-bold text-secondary text-uppercase small">Description & Specifications</h6>
                <p class="text-secondary leading-relaxed bg-light p-3 rounded-3 border">
                    {{ $equipment->description }}
                </p>

                <hr class="my-4">

                <div class="row text-muted small">
                    <div class="col-sm-6 mb-2">
                        <strong>Recorded By:</strong> {{ $equipment->user->name ?? 'System Admin' }} ({{ $equipment->user->email ?? 'N/A' }})
                    </div>
                    <div class="col-sm-6 mb-2">
                        <strong>Record ID:</strong> #{{ $equipment->id }}
                    </div>
                    <div class="col-sm-6 mb-2">
                        <strong>Date Created:</strong> {{ $equipment->created_at->format('M d, Y h:i A') }}
                    </div>
                    <div class="col-sm-6 mb-2">
                        <strong>Last Updated:</strong> {{ $equipment->updated_at->format('M d, Y h:i A') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection