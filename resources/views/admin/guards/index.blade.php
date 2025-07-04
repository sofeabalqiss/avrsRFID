@extends('layouts.admin')

@section('title', 'Guards')
@section('breadcrumbs')
    <li class="breadcrumb-item active">Guards</li>
@endsection

@section('content')
<div class="mb-3">
    <!-- Button to open Create Modal -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGuardModal">Add New Guard</button>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($guards as $guard)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $guard->name }}</td>
                <td>{{ $guard->email }}</td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editGuardModal{{ $guard->id }}">Edit</button>

                    <!-- Delete Button -->
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteGuardModal{{ $guard->id }}">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $guards->links('pagination::bootstrap-5') }}

<!-- Create Guard Modal -->
<div class="modal fade" id="createGuardModal" tabindex="-1" aria-labelledby="createGuardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.guards.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createGuardModalLabel">Add New Guard</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Create</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit & Delete Modals for Each Guard -->
@foreach ($guards as $guard)
    <!-- Edit Modal -->
    <div class="modal fade" id="editGuardModal{{ $guard->id }}" tabindex="-1" aria-labelledby="editGuardModalLabel{{ $guard->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.guards.update', $guard->id) }}" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Guard</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $guard->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $guard->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Password <small>(Leave blank to keep current)</small></label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteGuardModal{{ $guard->id }}" tabindex="-1" aria-labelledby="deleteGuardModalLabel{{ $guard->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.guards.destroy', $guard->id) }}" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete Guard</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <strong>{{ $guard->name }}</strong>?
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
