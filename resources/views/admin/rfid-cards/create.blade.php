@extends('layouts.admin')

@section('title', 'Add RFID Card')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.rfid-cards.index') }}">RFID Cards</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="mb-4">Add RFID Card</h5>

        <form action="{{ route('admin.rfid-cards.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="rfid_string" class="form-label">RFID String</label>
                <input type="text" name="rfid_string" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" class="form-select" required>
                    <option value="permanent">Permanent</option>
                    <option value="temporary">Temporary</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Add RFID</button>
            <a href="{{ route('admin.rfid-cards.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
