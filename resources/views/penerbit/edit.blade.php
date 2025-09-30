@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">✏️ Edit Penerbit</h1>

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

        {{-- Form Edit --}}
        <form action="{{ route('penerbit.update', $penerbit->id_penerbit) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">ID Penerbit</label>
                <input type="text" name="id_penerbit" class="form-control"
                       value="{{ $penerbit->id_penerbit }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ $penerbit->nama }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control"
                       value="{{ $penerbit->alamat }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kontak</label>
                <input type="text" name="kontak" class="form-control"
                       value="{{ $penerbit->kontak }}" required>
            </div>

            <button type="submit" class="btn btn-primary">💾 Simpan</button>
            <a href="{{ route('penerbit.index') }}" class="btn btn-secondary">↩️ Batal</a>
        </form>
    </div>
@endsection
