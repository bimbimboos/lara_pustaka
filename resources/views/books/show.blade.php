@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Buku: {{ $book->judul }}</h1>

        <!-- Navigasi Balik -->
        <a href="{{ route('books.index') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Buku</a>

        <!-- Detail Buku -->
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Judul:</strong> {{ $book->judul }}</p>
                <p><strong>Kategori:</strong> {{ $book->kategori }}</p>
                <p><strong>Penerbit:</strong> {{ $book->penerbit }}</p>
                <p><strong>Subkategori:</strong> {{ $book->subkategori }}</p>
                <!-- Tambah field lain sesuai model jika ada -->
            </div>
        </div>

        <!-- Daftar Item Buku -->
        <h3>Item Buku Terkait</h3>
        @if($book->bookItems->isNotEmpty())
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID Item</th>
                    <th>Barcode</th>
                    <th>Status</th>
                    <th>Kondisi</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($book->bookItems as $item)
                    <tr>
                        <td>{{ $item->id_buku_item }}</td>
                        <td>{{ $item->barcode_perpus }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>{{ ucfirst($item->kondisi) }}</td>
                        <td>
                            <a href="{{ route('bookitems.show', [$book->id, $item->id_buku_item]) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-warning">Belum ada item buku untuk buku ini.</p>
        @endif

        <!-- Tombol Tambah Item (Opsional, redirect ke halaman item) -->
        <a href="{{ route('bookitems.index', $book->id) }}" class="btn btn-primary mt-3">Tambah Item Buku</a>
    </div>
@endsection
