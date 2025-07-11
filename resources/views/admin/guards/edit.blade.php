@extends('layouts.admin')

@section('title', 'Edit Guard')
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.guards.index') }}">Guards</a></li>
<li class="breadcrumb-item active">Edit Guard</li>
@endsection

@section('content')
<form action="{{ route('admin.guards.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password (leave blank to keep current)</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
