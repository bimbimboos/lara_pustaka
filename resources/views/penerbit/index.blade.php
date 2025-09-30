@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4"><i class="fas fa-building"></i> Daftar Penerbit</h1>

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form Search --}}
        <form action="{{ route('penerbit.index') }}" method="GET" class="mb-3 d-flex">
            <input type="text" name="search" value="{{ $search }}" class="form-control me-2" placeholder="Cari penerbit...">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
        </form>

        {{-- Tombol Tambah (Popup Modal) --}}
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus"></i> Tambah Penerbit
        </button>

        {{-- Tabel --}}
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($penerbits as $penerbit)
                <tr>
                    <td>{{ $penerbit->id_penerbit }}</td>
                    <td>{{ $penerbit->nama }}</td>
                    <td>
                        {{-- Tombol Show Modal --}}
                        <button class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#showModal{{ $penerbit->id_penerbit }}">
                            <i class="fas fa-eye"></i> Lihat
                        </button>

                        {{-- Tombol Edit Modal --}}
                        <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $penerbit->id_penerbit }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        {{-- Tombol Hapus Modal --}}
                        <button class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $penerbit->id_penerbit }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>

                <!-- Modal Show -->
                <div class="modal fade" id="showModal{{ $penerbit->id_penerbit }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content bg-white">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detail Penerbit</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong><i class="fas fa-id-card"></i> ID Penerbit</strong>
                                            </div>
                                            <div class="col-md-8">
                                                <span class="badge bg-primary">{{ $penerbit->id_penerbit }}</span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong><i class="fas fa-building"></i> Nama Penerbit</strong>
                                            </div>
                                            <div class="col-md-8">
                                                {{ $penerbit->nama }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong><i class="fas fa-map-marker-alt"></i> Alamat</strong>
                                            </div>
                                            <div class="col-md-8">
                                                {{ $penerbit->alamat }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong><i class="fas fa-phone"></i> Kontak</strong>
                                            </div>
                                            <div class="col-md-8">
                                                <a href="tel:{{ $penerbit->kontak }}">{{ $penerbit->kontak }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i> Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $penerbit->id_penerbit }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-white">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Penerbit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('penerbit.update', $penerbit->id_penerbit) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="nama" class="form-control" value="{{ $penerbit->nama }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" value="{{ $penerbit->alamat }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Kontak</label>
                                        <input type="text" name="kontak" class="form-control" value="{{ $penerbit->kontak }}" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Delete -->
                <div class="modal fade" id="deleteModal{{ $penerbit->id_penerbit }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-white">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah kamu yakin ingin menghapus penerbit <strong>{{ $penerbit->nama }}</strong>?</p>
                                <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                                <form action="{{ route('penerbit.destroy', $penerbit->id_penerbit) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-check"></i> Ya, Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data penerbit.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $penerbits->links('pagination::simple-bootstrap-4') }}
        </div>

        {{-- Modal Create --}}
        <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('penerbit.store') }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="fas fa-plus"></i> Tambah Penerbit</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">ID Penerbit</label>
                            <input type="text" name="id_penerbit" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kontak</label>
                            <input type="text" name="kontak" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
