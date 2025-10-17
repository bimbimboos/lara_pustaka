```html
@extends('layouts.app')

@section('content')
    <div class="modal-content p-3">
        <!-- Judul -->
        <h4 class="fw-bold text-dark mb-3">{{ $book->judul }}</h4>

        <!-- Detail Buku -->
        <div class="row g-2">
            <div class="col-6">
                <p class="text-muted mb-1">ID Buku</p>
                <p class="fw-medium">{{ $book->id_buku }}</p>
            </div>
            <div class="col-6">
                <p class="text-muted mb-1">Kategori</p>
                <p class="fw-medium">{{ $book->kategori->nama_kategori ?? '-' }}</p>
            </div>
            <div class="col-6">
                <p class="text-muted mb-1">Subkategori</p>
                <p class="fw-medium">{{ $book->subkategori->nama_subkat ?? '-' }}</p>
            </div>
            <div class="col-6">
                <p class="text-muted mb-1">Penerbit</p>
                <p class="fw-medium">{{ $book->penerbit->nama ?? '-' }}</p>
            </div>
            <div class="col-6">
                <p class="text-muted mb-1">Pengarang</p>
                <p class="fw-medium">{{ $book->pengarang ?? '-' }}</p>
            </div>
            <div class="col-6">
                <p class="text-muted mb-1">Tahun Terbit</p>
                <p class="fw-medium">{{ $book->tahun_terbit ?? '-' }}</p>
            </div>
            <div class="col-6">
                <p class="text-muted mb-1">ISBN</p>
                <p class="fw-medium">{{ $book->isbn ?? '-' }}</p>
            </div>
            <div class="col-6">
                <p class="text-muted mb-1">Harga</p>
                <p class="fw-medium text-success">Rp {{ number_format($book->harga, 0, ',', '.') }}</p>
            </div>
            <div class="col-6">
                <p class="text-muted mb-1">Barcode</p>
                <p class="fw-medium">{{ $book->barcode ?? '-' }}</p>
            </div>
        </div>

        <!-- Cover (opsional, kecil) -->
        @if($book->cover)
            <div class="mt-3 text-center">
                <img src="{{ asset('storage/' . $book->cover) }}" class="img-fluid rounded shadow-sm" style="max-width: 150px;" alt="Cover Buku">
            </div>
        @endif
    </div>
@endsection
```
