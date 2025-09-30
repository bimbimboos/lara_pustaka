@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Profil</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        @method('PATCH')

        <!-- Nama -->
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="form-control @error('name') is-invalid @enderror">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="form-control @error('email') is-invalid @enderror">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Foto Profil -->
        <div class="mb-3">
            <label class="form-label">Foto Profil</label>
            <div class="d-flex align-items-center">
                @if ($user->photo)
                    <img src="{{ asset('storage/'.$user->photo) }}" alt="Foto Profil"
                          class="rounded-circle me-3" width="80" height="80" style="object-fit: cover;">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                          class="rounded-circle me-3" width="80" height="80" alt="Default Avatar">
                @endif
                
                <input type="file" name="photo" accept="image/*" class="form-control @error('photo') is-invalid @enderror">
            </div>
            @error('photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        <!-- Tombol -->
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('profile.show') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>

    <!-- Tombol Hapus Akun (Form terpisah) -->
    <div class="card mt-4 p-4 shadow-sm border-danger">
        <h5 class="text-danger mb-3">Zona Bahaya</h5>
        <p class="text-muted">Setelah akun dihapus, semua data akan hilang permanen.</p>
        
        <form action="{{ route('profile.destroy') }}" method="POST" 
              onsubmit="return confirm('Yakin mau hapus akun ini? Data akan hilang permanen! 😢')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">Hapus Akun</button>
        </form>
    </div>
</div>
@endsection