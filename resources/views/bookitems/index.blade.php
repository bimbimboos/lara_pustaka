@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><i class="fas fa-book"></i> Daftar Item Buku</h1>

        <!-- Search Form -->
        <form action="{{ route('bookitems.index') }}" method="GET" class="mb-3 d-flex" role="search">
            <input type="text" name="search" class="form-control me-2"
                   placeholder="Cari barcode atau status" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
            @if(request('search'))
                <a href="{{ route('bookitems.index') }}" class="btn btn-secondary"><i class="fas fa-sync"></i></a>
            @endif
        </form>

        <!-- Tombol buka modal -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahItemModal">
            <i class="fas fa-plus"></i> Tambah Item Buku
        </button>

        <table class="table table-bordered table-striped table-hover align-middle">
            <thead>
            <tr class="table-secondary text-center">
                <th style="width: 10%">ID Item</th>
                <th style="width: 20%">Barcode</th>
                <th style="width: 25%">Buku</th>
                <th style="width: 15%">Rak</th>
                <th style="width: 10%">Status</th>
                <th style="width: 20%">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr id="row-{{ $item->id_buku_item }}" class="text-center">
                    <td>{{ $item->id_buku_item }}</td>
                    <td>{{ $item->barcode_perpus ?? '-' }}</td>
                    <td class="text-start">{{ $item->books->judul ?? 'Tidak ada buku' }}</td>
                    <td>{{ $item->raks->nama ?? 'Tidak ada rak' }}</td> <!-- Sesuaikan ke raks -->
                    <td>
                        @if($item->status == 'Tersedia')
                            <span class="badge bg-success">Tersedia</span>
                        @else
                            <span class="badge bg-danger">Dipinjam</span>
                        @endif
                    </td>
                    <td>
                        <!-- Tombol Detail (Show Modal) -->
                        <button class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#showModal{{ $item->id_buku_item }}">
                            <i class="fas fa-eye"></i> Detail
                        </button>

                        <!-- Modal Show -->
                        <div class="modal fade" id="showModal{{ $item->id_buku_item }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title"><i class="fas fa-book-open"></i> Detail Item Buku</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body py-2">
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <td width="35%" class="fw-bold text-start ps-2">ID Item</td>
                                                <td width="5%" class="text-center">:</td>
                                                <td class="text-start">{{ $item->id_buku_item }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Barcode</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $item->barcode_perpus ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Buku</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $item->books->judul ?? 'Tidak ada buku' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Kategori</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $item->books->kategori->nama_kategori ?? 'Tidak ada kategori' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Rak</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $item->raks->nama ?? 'Tidak ada rak' }}</td> <!-- Sesuaikan ke raks -->
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Status</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">
                                                    @if($item->status == 'Tersedia')
                                                        <span class="badge bg-success">Tersedia</span>
                                                    @else
                                                        <span class="badge bg-danger">Dipinjam</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Kondisi</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $item->kondisi ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer py-2">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Edit -->
                        <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $item->id_buku_item }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $item->id_buku_item }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 500px;">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark py-2">
                                        <h6 class="modal-title mb-0"><i class="fas fa-edit"></i> Edit Item Buku</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('bookitems.update', $item->id_buku_item) }}" method="POST" id="editForm{{ $item->id_buku_item }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body py-2 px-3">
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">ID Item</label>
                                                <div class="col-8">
                                                    <input type="text" class="form-control form-control-sm" value="{{ $item->id_buku_item }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Buku</label>
                                                <div class="col-8">
                                                    <select name="id_buku" class="form-select form-select-sm" required>
                                                        @foreach($books as $book)
                                                            <option value="{{ $book->id_buku }}" {{ $item->id_buku == $book->id_buku ? 'selected' : '' }}>{{ $book->judul }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Rak</label>
                                                <div class="col-8">
                                                    <select name="id_rak" class="form-select form-select-sm" required>
                                                        @foreach($raks as $rak)
                                                            <option value="{{ $rak->id_rak }}" {{ $item->id_rak == $rak->id_rak ? 'selected' : '' }}>{{ $rak->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Status</label>
                                                <div class="col-8">
                                                    <select name="status" class="form-select form-select-sm" required>
                                                        <option value="Tersedia" {{ $item->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                        <option value="Dipinjam" {{ $item->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Kondisi</label>
                                                <div class="col-8">
                                                    <select name="kondisi" class="form-select form-select-sm" required>
                                                        <option value="Baik" {{ $item->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                        <option value="Rusak" {{ $item->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
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

                        <!-- Tombol Hapus -->
                        <button type="button" class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#hapusModal{{ $item->id_buku_item }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal{{ $item->id_buku_item }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content shadow-md border-0 rounded-3">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                                        <p class="mt-3">Apakah kamu yakin ingin menghapus item buku dengan barcode <strong>{{ $item->barcode_perpus ?? '-' }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                                        <form action="{{ route('bookitems.destroy', $item->id_buku_item) }}" method="POST" class="d-inline delete-form" data-id="{{ $item->id_buku_item }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> Ya, Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data item buku</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Item Buku -->
    <div class="modal fade" id="tambahItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header bg-success text-white py-2">
                    <h6 class="modal-title mb-0"><i class="fas fa-plus"></i> Tambah Item Buku</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('bookitems.store') }}" method="POST" id="addForm">
                    @csrf
                    <div class="modal-body py-2 px-3">
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Buku</label>
                            <div class="col-8">
                                <select name="id_buku" class="form-select form-select-sm" required>
                                    <option value="" disabled selected>-- Pilih Buku --</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id_buku }}">{{ $book->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Rak</label>
                            <div class="col-8">
                                <select name="id_rak" class="form-select form-select-sm" required>
                                    <option value="" disabled selected>-- Pilih Rak --</option>
                                    @foreach($raks as $rak)
                                        <option value="{{ $rak->id_rak }}">{{ $rak->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Status</label>
                            <div class="col-8">
                                <select name="status" class="form-select form-select-sm" required>
                                    <option value="" disabled selected>-- Pilih Status --</option>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Dipinjam">Dipinjam</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Kondisi</label>
                            <div class="col-8">
                                <select name="kondisi" class="form-select form-select-sm" required>
                                    <option value="" disabled selected>-- Pilih Kondisi --</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak">Rusak</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Sumber</label>
                            <div class="col-8">
                                <input type="text" name="sumber" class="form-control form-control-sm" maxlength="25" placeholder="Opsional">
                            </div>
                        </div>
                        <div class="alert alert-info alert-sm py-2 px-2 mb-0 mt-3">
                            <small><i class="fas fa-info-circle"></i> Barcode akan di-generate otomatis oleh sistem</small>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $items->links('pagination::simple-bootstrap-5') }}
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Handle delete form
            document.querySelectorAll(".delete-form").forEach(form => {
                form.addEventListener("submit", function (e) {
                    e.preventDefault();
                    let id = this.dataset.id;
                    let row = document.querySelector(`#row-${id}`);

                    fetch(this.action, {
                        method: "POST",
                        body: new FormData(this),
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    }).then(res => res.json()).then(data => {
                        if (data.success) {
                            let modalEl = document.getElementById(`hapusModal${id}`);
                            let modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();
                            if (row) row.remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Item buku berhasil dihapus!',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Gagal menghapus item buku. Silakan coba lagi.',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    }).catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus item buku.',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    });
                });
            });

            // Handle live search realtime
            const searchInput = document.querySelector("input[name='search']");
            const tableBody = document.querySelector("tbody");

            if (searchInput) {
                searchInput.addEventListener("keyup", function () {
                    let query = this.value;
                    fetch(`{{ route('bookitems.index') }}?search=${encodeURIComponent(query)}`, {
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    })
                        .then(res => res.text())
                        .then(html => {
                            let parser = new DOMParser();
                            let doc = parser.parseFromString(html, "text/html");
                            let newTbody = doc.querySelector("tbody");
                            if (newTbody) tableBody.innerHTML = newTbody.innerHTML;
                            // Perbarui pagination jika ada
                            let newPagination = doc.querySelector(".pagination");
                            if (newPagination) {
                                let paginationContainer = document.querySelector(".d-flex.justify-content-center.mt-3");
                                if (paginationContainer) paginationContainer.innerHTML = newPagination.innerHTML;
                            }
                        })
                        .catch(error => console.error('Error fetching search results:', error));
                });
            }

            // Handle add form submission
            const addForm = document.getElementById('addForm');
            if (addForm) {
                addForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    }).then(res => res.json()).then(data => {
                        if (data.success) {
                            let modal = bootstrap.Modal.getInstance(document.getElementById('tambahItemModal'));
                            modal.hide();
                            this.reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Item buku berhasil ditambahkan!',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            }).then(() => {
                                // Perbarui tabel tanpa reload
                                fetch(`{{ route('bookitems.index') }}?search=${encodeURIComponent(searchInput ? searchInput.value : '')}`, {
                                    headers: { "X-Requested-With": "XMLHttpRequest" }
                                })
                                    .then(res => res.text())
                                    .then(html => {
                                        let parser = new DOMParser();
                                        let doc = parser.parseFromString(html, "text/html");
                                        let newTbody = doc.querySelector("tbody");
                                        if (newTbody) tableBody.innerHTML = newTbody.innerHTML;
                                        let newPagination = doc.querySelector(".pagination");
                                        if (newPagination) {
                                            let paginationContainer = document.querySelector(".d-flex.justify-content-center.mt-3");
                                            if (paginationContainer) paginationContainer.innerHTML = newPagination.innerHTML;
                                        }
                                    });
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Gagal menambahkan item buku. Silakan coba lagi.',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    }).catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menambahkan item buku.',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    });
                });
            }

            // Handle edit form submission
            document.querySelectorAll('[id^="editForm"]').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const id = this.action.split('/').pop();
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    }).then(res => res.json()).then(data => {
                        if (data.success) {
                            let modal = bootstrap.Modal.getInstance(document.getElementById(`editModal${id}`));
                            modal.hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Item buku berhasil diperbarui!',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            }).then(() => {
                                // Perbarui baris tabel tanpa reload
                                fetch(`{{ route('bookitems.index') }}?search=${encodeURIComponent(searchInput ? searchInput.value : '')}`, {
                                    headers: { "X-Requested-With": "XMLHttpRequest" }
                                })
                                    .then(res => res.text())
                                    .then(html => {
                                        let parser = new DOMParser();
                                        let doc = parser.parseFromString(html, "text/html");
                                        let newTbody = doc.querySelector("tbody");
                                        if (newTbody) tableBody.innerHTML = newTbody.innerHTML;
                                        let newPagination = doc.querySelector(".pagination");
                                        if (newPagination) {
                                            let paginationContainer = document.querySelector(".d-flex.justify-content-center.mt-3");
                                            if (paginationContainer) paginationContainer.innerHTML = newPagination.innerHTML;
                                        }
                                    });
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Gagal memperbarui item buku. Silakan coba lagi.',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    }).catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memperbarui item buku.',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    });
                });
            });
        });
    </script>
@endpush
