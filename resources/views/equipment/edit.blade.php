@extends('layouts.app')

@section('title', 'Edit Equipment - Pickleball System')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Equipment</h2>
            <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card card-custom">
            <div class="card-body p-4">
                <form action="{{ route('equipment.update', $equipment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Equipment Name -->
                    <div class="mb-3">
                        <label for="equipment_name" class="form-label fw-semibold">Equipment Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="equipment_name" 
                               id="equipment_name" 
                               class="form-control @error('equipment_name') is-invalid @enderror" 
                               value="{{ old('equipment_name', $equipment->equipment_name) }}" 
                               required>
                        @error('equipment_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Category -->
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $equipment->category) === $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Unit Price -->
                        <div class="col-md-6 mb-3">
                            <label for="unit_price" class="form-label fw-semibold">Unit Price ($) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       name="unit_price" 
                                       id="unit_price" 
                                       class="form-control @error('unit_price') is-invalid @enderror" 
                                       value="{{ old('unit_price', $equipment->unit_price) }}" 
                                       required>
                                @error('unit_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Availability Status -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">Availability Status <span class="text-danger">*</span></label>
                        @foreach ($statuses as $status)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('availability_status') is-invalid @enderror" 
                                       type="radio" 
                                       name="availability_status" 
                                       id="status_{{ $status }}" 
                                       value="{{ $status }}" 
                                       {{ old('availability_status', $equipment->availability_status) === $status ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_{{ $status }}">
                                    @if($status === 'Available')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Available</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Unavailable</span>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                        @error('availability_status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Description & Specifications <span class="text-danger">*</span></label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  required>{{ old('description', $equipment->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check2-circle me-1"></i> Update Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection