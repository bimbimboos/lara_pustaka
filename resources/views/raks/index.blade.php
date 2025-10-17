@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><i class="fas fa-box"></i> Daftar Rak</h1>

        <!-- Search Form -->
        <form action="{{ route('raks.index') }}" method="GET" class="mb-3 d-flex" role="search">
            <input type="text" name="search" class="form-control me-2"
                   placeholder="Cari nama/barcode/lokasi" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
            @if(request('search'))
                <a href="{{ route('raks.index') }}" class="btn btn-secondary ms-2"><i class="fas fa-sync"></i></a>
            @endif
        </form>

        <!-- Tombol Tambah Rak -->
        <a href="{{ route('raks.create') }}" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Rak Baru
        </a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead>
                <tr class="table-secondary text-center">
                    <th style="width: 20%">ID Rak</th>
                    <th style="width: 30%">Nama</th>
                    <th style="width: 20%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($raks as $rak)
                    <tr id="row-{{ $rak->id_rak }}" class="text-center">
                        <td>{{ $rak->id_rak }}</td>
                        <td>{{ $rak->nama }}</td>
                        <td>
                            <!-- Tombol Detail -->
                            <a href="{{ route('raks.show', $rak->id_rak) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>

                            <!-- Tombol Edit -->
                            <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $rak->id_rak }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <!-- Tombol Hapus -->
                            <button type="button" class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#hapusModal{{ $rak->id_rak }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            @if(request('search'))
                                Tidak ada rak yang ditemukan dengan kata kunci "{{ request('search') }}"
                            @else
                                Tidak ada data rak.
                            @endif
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $raks->appends(['search' => request('search')])->links('pagination::simple-bootstrap-5') }}
        </div>
    </div>

    <!-- Modals Section -->
    @foreach($raks as $rak)
        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $rak->id_rak }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 shadow-lg">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Rak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('raks.update', $rak->id_rak) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Rak</label>
                                <input type="text" name="nama" class="form-control" value="{{ $rak->nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Barcode</label>
                                <input type="text" name="barcode" class="form-control" value="{{ $rak->barcode }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kolom</label>
                                <input type="number" name="kolom" class="form-control" value="{{ $rak->kolom }}" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Baris</label>
                                <input type="number" name="baris" class="form-control" value="{{ $rak->baris }}" min="1" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div class="modal fade" id="hapusModal{{ $rak->id_rak }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content shadow-md border-0 rounded-3">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                        <p class="mt-3">Apakah kamu yakin ingin menghapus <strong>{{ $rak->nama }}</strong>?</p>
                        <p class="text-muted mb-0">Barcode: <strong>{{ $rak->barcode }}</strong></p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <form action="{{ route('raks.destroy', $rak->id_rak) }}" method="POST"
                              class="d-inline delete-form" data-id="{{ $rak->id_rak }}">
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
    @endforeach
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
                            alert("Rak berhasil dihapus!");
                        }
                    });
                });
            });
        });
    </script>
@endpush
