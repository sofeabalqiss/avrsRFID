@extends('layouts.admin')

@section('title', 'RFID Cards')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">RFID Cards</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="mb-3">RFID Cards List</h5>

        <!-- Add RFID Card Button -->
        <div class="mb-3 text-start">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRfidModal">Add RFID Card</button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>RFID String</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rfidCards as $rfid)
                        <tr>
                            <td>{{ $rfid->id }}</td>
                            <td>{{ $rfid->rfid_string }}</td>
                            <td>
                                <span class="badge bg-{{ $rfid->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($rfid->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $rfid->type === 'permanent' ? 'primary' : 'warning' }}">
                                    {{ ucfirst($rfid->type) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRfidModal{{ $rfid->id }}">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No RFID cards found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $rfidCards->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Create RFID Card Modal -->
<div class="modal fade" id="createRfidModal" tabindex="-1" aria-labelledby="createRfidModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.rfid-cards.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createRfidModalLabel">Add RFID Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>RFID String</label>
                    <input type="text" name="rfid_string" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Type</label>
                    <select name="type" class="form-select" required>
                        <option value="permanent">Permanent</option>
                        <option value="temporary">Temporary</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Add</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modals for Each RFID Card -->
@foreach ($rfidCards as $rfid)
    <div class="modal fade" id="deleteRfidModal{{ $rfid->id }}" tabindex="-1" aria-labelledby="deleteRfidModalLabel{{ $rfid->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.rfid-cards.destroy', $rfid->id) }}" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete RFID Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <strong>{{ $rfid->rfid_string }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endforeach
@endsection
