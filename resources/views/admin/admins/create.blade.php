@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Admin</h1>

    <form method="POST" action="{{ route('admin.admins.store') }}">
        @csrf

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

        <button type="submit" class="btn btn-primary">Add Admin</button>
    </form>
</div>
@endsection
