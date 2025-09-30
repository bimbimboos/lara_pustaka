@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Profile Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-user-circle"></i> Profil Saya</span>
                    
                    <!-- Tombol Delete -->
                    <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Yakin mau hapus akun ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i> Hapus Akun
                        </button>
                    </form>
                </div>

                <div class="card-body">

                    <!-- Foto Profile -->
                    <div class="text-center mb-4">
                        @if (Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                 alt="Profile" class="rounded-circle shadow-sm" width="120" height="120">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff&size=120" 
                                 alt="Profile" class="rounded-circle shadow-sm">
                        @endif
                        
                        <h4 class="mt-3 fw-bold">{{ Auth::user()->name }}</h4>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>

                    <!-- Info User -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->email }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->role ?? 'User' }}" readonly>
                    </div>

                    <!-- Tombol -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
