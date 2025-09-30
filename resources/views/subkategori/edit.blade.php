@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">✏️ Edit Subkategori</h1>

        {{-- Alert error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('subkategori.update', $subkategori->id_subkat) }}" method="POST" class="card shadow p-4">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_subkat" class="form-label">Nama Subkategori</label>
                <input type="text" name="nama_subkat" id="nama_subkat"
                       class="form-control @error('nama_subkat') is-invalid @enderror"
                       value="{{ old('nama_subkat', $subkategori->nama_subkat) }}" required>
                @error('nama_subkat')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="id_kategori" class="form-label">Kategori Induk</label>
                <select name="id_kategori" id="id_kategori"
                        class="form-select @error('id_kategori') is-invalid @enderror" required>
                    <option value="" disabled>-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id_kategori }}"
                            {{ old('id_kategori', $subkategori->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('id_kategori')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('subkategori.index') }}" class="btn btn-secondary">⬅ Kembali</a>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
@endsection
