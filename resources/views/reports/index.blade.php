@extends('layouts.app')

@section('title', 'Equipment Reports - Pickleball System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-0"><i class="bi bi-file-earmark-bar-graph text-success me-2"></i>Equipment Reports</h2>
        <p class="text-muted small mb-0">Generate filtered inventory reports, price lists, and export to PDF or Excel.</p>
    </div>
    
    <!-- Export Buttons with Active Filters -->
    <div class="btn-group shadow-sm">
        <a href="{{ route('reports.export.excel', ['category' => $category, 'availability_status' => $status]) }}" class="btn btn-outline-success">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export Excel (CSV)
        </a>
        <a href="{{ route('reports.export.pdf', ['category' => $category, 'availability_status' => $status]) }}" target="_blank" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export / Print PDF
        </a>
    </div>
</div>

<!-- Summary Metrics Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-custom border-start border-primary border-4 p-3 bg-white">
            <div class="text-muted small text-uppercase fw-semibold">Filtered Items</div>
            <div class="fs-3 fw-bold text-dark">{{ $totalRecords }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom border-start border-success border-4 p-3 bg-white">
            <div class="text-muted small text-uppercase fw-semibold">Total Price Valuation</div>
            <div class="fs-3 fw-bold text-success">${{ number_format($totalValue, 2) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom border-start border-info border-4 p-3 bg-white">
            <div class="text-muted small text-uppercase fw-semibold">Available Units</div>
            <div class="fs-3 fw-bold text-info">{{ $availableCount }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom border-start border-danger border-4 p-3 bg-white">
            <div class="text-muted small text-uppercase fw-semibold">Unavailable Units</div>
            <div class="fs-3 fw-bold text-danger">{{ $unavailableCount }}</div>
        </div>
    </div>
</div>

<!-- Filter Control Card -->
<div class="card card-custom mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('reports.index') }}" class="row g-3 align-items-end">
            <!-- Category Filter -->
            <div class="col-md-4">
                <label for="category" class="form-label small fw-semibold text-secondary">Filter by Category:</label>
                <select name="category" id="category" class="form-select">
                    <option value="">-- All Categories --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Availability Status Filter -->
            <div class="col-md-4">
                <label for="availability_status" class="form-label small fw-semibold text-secondary">Filter by Availability Status:</label>
                <select name="availability_status" id="availability_status" class="form-select">
                    <option value="">-- All Statuses --</option>
                    @foreach ($statuses as $st)
                        <option value="{{ $st }}" {{ $status === $st ? 'selected' : '' }}>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-funnel me-1"></i> Apply Filters
                </button>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Report Table / Price List -->
<div class="card card-custom">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-list-check text-success me-1"></i> Report Results & Equipment Price List
        </h5>
        <span class="text-muted small">Showing {{ $equipments->count() }} records</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Equipment Name</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                        <th>Availability Status</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($equipments as $item)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $item->equipment_name }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $item->category }}</span></td>
                            <td class="fw-bold text-success">${{ number_format($item->unit_price, 2) }}</td>
                            <td>
                                @if($item->availability_status === 'Available')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                        Available
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                        Unavailable
                                    </span>
                                @endif
                            </td>
                            <td class="text-secondary small" style="max-width: 320px;">{{ Str::limit($item->description, 75) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-funnel fs-1 text-secondary d-block mb-2"></i>
                                    <h5 class="fw-bold">No records match the selected filters</h5>
                                    <p class="small mb-3">Try choosing different criteria or click Reset to view all records.</p>
                                    <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection