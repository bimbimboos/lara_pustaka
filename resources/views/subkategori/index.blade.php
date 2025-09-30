@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4"><i class="fas fa-folder-open"></i> Daftar Subkategori</h1>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search --}}
        <form action="{{ route('subkategori.index') }}" method="GET" class="mb-3 d-flex" role="search">
            <input type="text" name="search" class="form-control me-2"
                   placeholder="Cari subkategori/kategori" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
            @if(request('search'))
                <a href="{{ route('subkategori.index') }}" class="btn btn-secondary"><i class="fas fa-sync"></i></a>
            @endif
        </form>

        {{-- Tombol Tambah Subkategori yang buka modal --}}
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahSubkategoriModal">
            <i class="fas fa-plus"></i> Tambah Subkategori
        </button>

        {{-- Tabel --}}
        <table class="table table-bordered">
            <thead>
            <tr class="table-secondary">
                <th>No</th>
                <th>Nama Subkategori</th>
                <th>Kategori Induk</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($subkategoris as $s => $sub)
                <tr>
                    <td>{{ $subkategoris->firstItem() + $s }}</td>
                    <td>{{ $sub->nama_subkat }}</td>
                    <td>{{ $sub->kategori->nama_kategori ?? '-' }}</td>
                    <td>
                        <a href="{{ route('subkategori.edit', $sub->id_subkat) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- Tombol Hapus buka modal -->
                        <button type="button" class="btn btn-danger btn-sm"
                                data-bs-toggle="modal" data-bs-target="#deleteSubkategoriModal{{ $sub->id_subkat }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>

                {{-- Modal Delete --}}
                <div class="modal fade" id="deleteSubkategoriModal{{ $sub->id_subkat }}" tabindex="-1"
                     aria-labelledby="deleteSubkategoriModalLabel{{ $sub->id_subkat }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('subkategori.destroy', $sub->id_subkat) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="deleteSubkategoriModalLabel{{ $sub->id_subkat }}">
                                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    Yakin mau hapus subkategori <strong>{{ $sub->nama_subkat }}</strong>?
                                    <br>
                                    <small class="text-muted">Data ini tidak bisa dikembalikan setelah dihapus.</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i> Batal
                                    </button>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-check"></i> Ya, Hapus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data subkategori</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $subkategoris->appends(request()->except('page'))->links('pagination::simple-bootstrap-5') }}
        </div>
    </div>

    {{-- Modal Tambah Subkategori --}}
    <div class="modal fade" id="tambahSubkategoriModal" tabindex="-1" aria-labelledby="tambahSubkategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('subkategori.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="tambahSubkategoriModalLabel">
                            <i class="fas fa-plus"></i> Tambah Subkategori
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Validasi error --}}
                        @if ($errors->any() && session('form') === 'tambah_subkategori')
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="nama_subkat" class="form-label">Nama Subkategori</label>
                            <input type="text" name="nama_subkat" id="nama_subkat"
                                   class="form-control @error('nama_subkat') is-invalid @enderror"
                                   placeholder="Masukkan nama subkategori" required
                                   value="{{ old('nama_subkat') }}">
                            @error('nama_subkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_kategori" class="form-label">Kategori Induk</label>
                            <select name="id_kategori" id="id_kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>

                            @error('id_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script untuk buka modal otomatis jika ada error validasi --}}
    @if ($errors->any() && session('form') === 'tambah_subkategori')
        @push('scripts')
            <script>
                var tambahSubkategoriModal = new bootstrap.Modal(document.getElementById('tambahSubkategoriModal'));
                tambahSubkategoriModal.show();
            </script>
        @endpush
    @endif
@endsection