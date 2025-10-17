@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><i class="fas fa-book"></i> Penataan Buku</h1>

        <!-- Search Form -->
        <form action="{{ route('penataan.index') }}" method="GET" class="mb-3 d-flex" role="search">
            <input type="text" name="search" class="form-control me-2"
                   placeholder="Cari berdasarkan judul buku atau nama rak..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
            @if(request('search'))
                <a href="{{ route('penataan.index') }}" class="btn btn-secondary"><i class="fas fa-sync"></i></a>
            @endif
        </form>

        <!-- Tombol buka modal -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahPenataanModal">
            <i class="fas fa-plus"></i> Tambah Penataan
        </button>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table class="table table-bordered table-striped table-hover align-middle">
            <thead>
            <tr class="table-secondary text-center">
                <th style="width: 30%">ID</th>
                <th style="width: 35%">Judul Buku</th>
                <th style="width: 35%">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($penataans as $penataan)
                <tr id="row-{{ $penataan->id_penataan }}" class="text-center">
                    <td>{{ $penataan->id_penataan }}</td>
                    <td class="text-center">{{ $penataan->book->judul ?? 'N/A' }}</td>
                    <td>
                        <!-- Tombol Detail -->
                        <a href="{{ route('penataan.show', $penataan->id_penataan) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>

                        <!-- Tombol Edit -->
                        <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $penataan->id_penataan }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <!-- Tombol Hapus -->
                        <button type="button" class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#hapusModal{{ $penataan->id_penataan }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $penataan->id_penataan }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark py-2">
                                <h6 class="modal-title mb-0"><i class="fas fa-edit"></i> Edit Penataan</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('penataan.update', $penataan->id_penataan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body py-2 px-3">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="row mb-2 align-items-center">
                                        <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Judul Buku</label>
                                        <div class="col-8">
                                            <select name="id_buku" class="form-select form-select-sm" required>
                                                @foreach($books as $book)
                                                    <option value="{{ $book->id_buku }}" {{ $penataan->id_buku == $book->id_buku ? 'selected' : '' }}>
                                                        {{ $book->judul }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Nama Rak</label>
                                        <div class="col-8">
                                            <select name="id_rak" class="form-select form-select-sm" required>
                                                @foreach($raks as $rak)
                                                    <option value="{{ $rak->id_rak }}" {{ $penataan->id_rak == $rak->id_rak ? 'selected' : '' }}>
                                                        {{ $rak->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Kolom</label>
                                        <div class="col-8">
                                            <input type="number" name="kolom" class="form-control form-control-sm" value="{{ $penataan->kolom }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Baris</label>
                                        <div class="col-8">
                                            <input type="number" name="baris" class="form-control form-control-sm" value="{{ $penataan->baris }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Jumlah Buku</label>
                                        <div class="col-8">
                                            <input type="number" name="jumlah_buku" class="form-control form-control-sm" value="{{ $penataan->jumlah_buku ?? 1 }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Penyusun</label>
                                        <div class="col-8">
                                            <select name="id_user" class="form-select form-select-sm" required>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id_user }}" {{ $penataan->id_user == $user->id_user ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer py-2">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i> Batal
                                    </button>
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Hapus -->
                <div class="modal fade" id="hapusModal{{ $penataan->id_penataan }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content shadow-md border-0 rounded-3">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                                <p class="mt-3">Apakah kamu yakin ingin menghapus penataan buku <strong>{{ $penataan->book->judul ?? 'N/A' }}</strong>?</p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                                <form action="{{ route('penataan.destroy', $penataan->id_penataan) }}" method="POST" class="d-inline delete-form" data-id="{{ $penataan->id_penataan }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> Ya, Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada data penataan</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Modal Tambah Penataan -->
        <div class="modal fade" id="tambahPenataanModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="fas fa-plus"></i> Tambah Penataan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('penataan.store') }}" method="POST">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Buku</label>
                                <select name="id_buku" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Buku --</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id_buku }}">{{ $book->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Rak</label>
                                <select name="id_rak" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Rak --</option>
                                    @foreach($raks as $rak)
                                        <option value="{{ $rak->id_rak }}">{{ $rak->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kolom</label>
                                <input type="number" class="form-control" name="kolom" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Baris</label>
                                <input type="number" class="form-control" name="baris" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jumlah Buku</label>
                                <input type="number" class="form-control" name="jumlah_buku" min="1" value="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Penyusun</label>
                                <select name="id_user" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Penyusun --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id_user }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $penataans->links('pagination::simple-bootstrap-5') }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".delete-form").forEach(form => {
                form.addEventListener("submit", function (e) {
                    e.preventDefault();
                    let id = this.dataset.id;
                    let row = document.querySelector(`#row-${id}`);

                    fetch(this.action, {
                        method: "POST",
                        body: new FormData(this),
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    }).then(res => {
                        if (res.ok) {
                            let modalEl = document.getElementById(`hapusModal${id}`);
                            let modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();
                            if (row) row.remove();
                            alert("Penataan berhasil dihapus!");
                        }
                    }).catch(error => {
                        alert("Gagal menghapus penataan!");
                    });
                });
            });
        });
    </script>
@endpush
