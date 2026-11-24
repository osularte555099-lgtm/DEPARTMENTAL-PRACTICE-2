@extends('layouts.app')

@section('title', 'Equipment Inventory - Pickleball System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-0"><i class="bi bi-box-seam text-success me-2"></i>Equipment Inventory</h2>
        <p class="text-muted small mb-0">Manage all pickleball paddles, balls, nets, and accessories.</p>
    </div>
    <a href="{{ route('equipment.create') }}" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Add New Equipment
    </a>
</div>

<!-- Search & Filter Bar -->
<div class="card card-custom mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('equipment.index') }}" class="row g-2 align-items-center">
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by equipment name, category, or description..." value="{{ $search }}">
                </div>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-filter me-1"></i> Search
                </button>
                @if($search)
                    <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Equipment Records Table -->
<div class="card card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Equipment Name</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($equipments as $item)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $loop->iteration + ($equipments->currentPage() - 1) * $equipments->perPage() }}</td>
                            <td class="fw-semibold text-dark">
                                <a href="{{ route('equipment.show', $item) }}" class="text-decoration-none text-dark">
                                    {{ $item->equipment_name }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1">
                                    {{ $item->category }}
                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                ${{ number_format($item->unit_price, 2) }}
                            </td>
                            <td>
                                @if($item->availability_status === 'Available')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                        <i class="bi bi-check-circle me-1"></i> Available
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                        <i class="bi bi-x-circle me-1"></i> Unavailable
                                    </span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                {{ $item->user->name ?? 'Admin' }}
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('equipment.show', $item) }}" class="btn btn-outline-secondary" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('equipment.edit', $item) }}" class="btn btn-outline-primary" title="Edit Record">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-danger" 
                                            title="Delete Record"
                                            onclick="confirmDelete('{{ $item->id }}', '{{ addslashes($item->equipment_name) }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Hidden Delete Form for this row -->
                                <form id="delete-form-{{ $item->id }}" action="{{ route('equipment.destroy', $item) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                <h5 class="fw-semibold">No equipment records found</h5>
                                <p class="small mb-3">Get started by creating your first pickleball equipment entry.</p>
                                <a href="{{ route('equipment.create') }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-plus-circle me-1"></i> Add Equipment
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($equipments->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $equipments->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Record Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteEquipmentName" class="text-danger"></strong>?</p>
                <p class="small text-muted mb-0">This action will permanently remove the record from the inventory database.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete Record</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let activeDeleteId = null;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    function confirmDelete(id, name) {
        activeDeleteId = id;
        document.getElementById('deleteEquipmentName').textContent = name;
        deleteModal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (activeDeleteId) {
            document.getElementById('delete-form-' + activeDeleteId).submit();
        }
    });
</script>
@endsection