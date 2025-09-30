@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">📝 Edit Buku</h1>

        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-warning text-dark fw-bold">
                Formulir Edit Buku
            </div>

            <div class="card-body">
                <form action="{{ route('books.update', $book->id_buku) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label">📖 Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control"
                               value="{{ old('judul', $book->judul) }}" required>
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label for="id_kategori" class="form-label">📂 Kategori</label>
                        <select name="id_kategori" id="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id_kategori }}"
                                    {{ $book->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Subkategori --}}
                    <div class="mb-3">
                        <label for="id_subkat" class="form-label">📑 Subkategori</label>
                        <select name="id_subkat" id="id_subkat" class="form-select">
                            <option value="">-- Pilih Subkategori --</option>
                            @foreach($subkategories as $sub)
                                <option value="{{ $sub->id_subkat }}"
                                    {{ $book->id_subkat == $sub->id_subkat ? 'selected' : '' }}>
                                    {{ $sub->nama_subkat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Penerbit --}}
                    <div class="mb-3">
                        <label for="id_penerbit" class="form-label">🏢 Penerbit</label>
                        <select name="id_penerbit" id="id_penerbit" class="form-select">
                            <option value="">-- Pilih Penerbit --</option>
                            @foreach($penerbits as $penerbit)
                                <option value="{{ $penerbit->id_penerbit }}"
                                    {{ $book->id_penerbit == $penerbit->id_penerbit ? 'selected' : '' }}>
                                    {{ $penerbit->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tahun Terbit --}}
                    <div class="mb-3">
                        <label for="tahun_terbit" class="form-label">📅 Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control"
                               value="{{ old('tahun_terbit', $book->tahun_terbit) }}" placeholder="Format YYYY">
                    </div>

                    {{-- ISBN --}}
                    <div class="mb-3">
                        <label for="isbn" class="form-label">🔢 ISBN</label>
                        <input type="text" name="isbn" id="isbn" class="form-control"
                               value="{{ old('isbn', $book->isbn) }}">
                    </div>

                    {{-- Harga --}}
                    <div class="mb-3">
                        <label for="harga" class="form-label">💰 Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control"
                               value="{{ old('harga', $book->harga) }}">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">⬅️ Kembali</a>
                        <button type="submit" class="btn btn-warning">💾 Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
