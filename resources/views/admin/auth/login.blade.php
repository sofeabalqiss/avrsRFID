@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin Login</h2>

    {{-- Display error messages if any --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" required class="form-control">
        </div>

        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" required class="form-control">
        </div>

        <button class="btn btn-primary">Login as Admin</button>
    </form>
</div>
@endsection
