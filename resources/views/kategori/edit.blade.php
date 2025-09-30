@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card bg-white shadow rounded">
            <div class="card-body">
                <h1 class="mb-4">✏️ Edit Kategori</h1>

                <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="id_kategori" class="form-label">ID Kategori</label>
                        <input type="text" id="id_kategori" class="form-control"
                               value="{{ $kategori->id_kategori }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori"
                               class="form-control"
                               value="{{ $kategori->nama_kategori }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
