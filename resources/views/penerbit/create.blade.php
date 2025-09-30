@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">➕ Tambah Penerbit</h1>

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('penerbit.store') }}" method="POST">
            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Penerbit</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat') }}" required>
            </div>

            {{-- Kontak --}}
            <div class="mb-3">
                <label for="kontak" class="form-label">Kontak</label>
                <input type="text" name="kontak" id="kontak" class="form-control" value="{{ old('kontak') }}" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('penerbit.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
