@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control" 
                value="{{ old('name', $user->name) }}" 
                required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control" 
                value="{{ old('email', $user->email) }}" 
                required>
        </div>

        <div class="form-group mb-3">
            <label for="role">Role</label>
            <select 
                name="role" 
                id="role" 
                class="form-control" 
                required>
                <option value="" disabled>Select role</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User </option>
                <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                <!-- Tambahkan role lain sesuai kebutuhan -->
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="password">Password <small>(Leave blank if you don't want to change)</small></label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <input 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation" 
                class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection