@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Buku</h1>

    <form action="{{ route('books.store') }}" method="POST">
        @csrf

        {{-- Judul --}}
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" required placeholder="Judul buku">
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        {{-- Penerbit --}}
        <div class="mb-3">
            <label for="id_penerbit" class="form-label">Penerbit</label>
            <select name="id_penerbit" id="id_penerbit" class="form-control" required>
                <option value="">-- Pilih Penerbit --</option>
                @foreach($penerbits as $pen)
                    <option value="{{ $pen->id_penerbit }}">{{ $pen->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- Subkategori --}}
        <div class="mb-3">
            <label for="id_subkat" class="form-label">Subkategori</label>
            <select name="id_subkat" id="id_subkat" class="form-control">
                <option value="">-- Pilih Subkategori --</option>
                @foreach($subkategories as $sub)
                    <option value="{{ $sub->id_subkat }}">{{ $sub->nama_subkat }}</option>
                @endforeach
            </select>
        </div>
        {{-- ISBN --}}
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" name="isbn" id="isbn" class="form-control" placeholder="Nomor ISBN">
        </div>
        {{-- Pengarang --}}
        <div class="mb-3">
            <label for="pengarang" class="form-label">Pengarang</label>
            <input type="text" name="pengarang" id="pengarang" class="form-control" placeholder="Nama pengarang">
        </div>
        {{-- Tahun Terbit --}}
        <div class="mb-3">
            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" placeholder="Format YYYY">
        </div>
        {{-- Harga --}}
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" placeholder="Harga dalam Rupiah">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
