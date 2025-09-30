{{-- resources/views/users/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <!-- Foto Profil -->
            <img src="{{ $user->profile_picture ?? 'https://ui-avatars.com/api/?name='.$user->name }}" 
                 class="rounded-circle mb-3" width="120" height="120">

            <h4 class="fw-bold">{{ $user->name }}</h4>
            <p class="text-muted mb-1">{{ $user->email }}</p>
            <p><span class="badge bg-primary">{{ $user->role ?? 'User' }}</span></p>

            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                <i class="fa fa-edit me-1"></i> Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection
