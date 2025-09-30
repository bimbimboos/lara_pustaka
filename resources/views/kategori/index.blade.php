@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4"><i class="fas fa-folder"></i> Daftar Kategori</h1>

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form Search --}}
        <form action="{{ route('kategori.index') }}" method="GET" class="mb-3 d-flex">
            <input type="text" name="search" value="{{ $search }}" class="form-control me-2" placeholder="Cari kategori...">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
        </form>

        {{-- Tombol Tambah --}}
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus"></i> Tambah Kategori
        </button>

        {{-- Tabel --}}
        <table class="table table-bordered">
            <thead class="table-secondary">
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($kategoris as $kategori)
                <tr>
                    <td>{{ $kategori->id_kategori }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>
                        {{-- Tombol Edit --}}
                        <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $kategori->id_kategori }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        {{-- Tombol Hapus (modal) --}}
                        <button class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $kategori->id_kategori }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>

                {{-- Modal Edit --}}
                <div class="modal fade" id="editModal{{ $kategori->id_kategori }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-white shadow">
                            <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Kategori</label>
                                        <input type="text" name="nama_kategori" class="form-control"
                                               value="{{ $kategori->nama_kategori }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i> Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Modal Delete --}}
                <div class="modal fade" id="deleteModal{{ $kategori->id_kategori }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-white shadow">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Yakin ingin menghapus kategori <strong>{{ $kategori->nama_kategori }}</strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('kategori.destroy', $kategori->id_kategori) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> Ya, Hapus</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada kategori.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $kategoris->links('pagination::simple-bootstrap-4') }}
        </div>
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('kategori.store') }}" method="POST" class="modal-content bg-white shadow">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-plus"></i> Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection