@extends('layouts.admin')

@section('title', 'Add Guard')
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.guards.index') }}">Guards</a></li>
<li class="breadcrumb-item active">Add Guard</li>
@endsection

@section('content')
<form action="{{ route('admin.guards.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Create</button>
</form>
@endsection
