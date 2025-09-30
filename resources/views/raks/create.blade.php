@extends('layouts.app')

@section('content')
    <h1>Tambah Rak Baru</h1>
    <form action="{{ route('raks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Rak</label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Barcode</label>
            <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode') }}" required>
            @error('barcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Kolom</label>
            <input type="number" name="kolom" class="form-control @error('kolom') is-invalid @enderror" value="{{ old('kolom') }}" min="1" required>
            @error('kolom') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Baris</label>
            <input type="number" name="baris" class="form-control @error('baris') is-invalid @enderror" value="{{ old('baris') }}" min="1" required>
            @error('baris') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Kapasitas</label>
            <input type="number" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" value="{{ old('kapasitas') }}" min="1" required>
            @error('kapasitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <select name="id_lokasi" class="form-select @error('id_lokasi') is-invalid @enderror" required>
                <option value="">Pilih Lokasi</option>
                @foreach($lokasis as $lokasi)
                    <option value="{{ $lokasi->id }}" {{ old('id_lokasi') == $lokasi->id ? 'selected' : '' }}>
                        {{ $lokasi->nama }}
                    </option>
                @endforeach
            </select>
            @error('id_lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('raks.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
