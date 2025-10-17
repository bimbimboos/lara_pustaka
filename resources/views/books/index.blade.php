@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><i class="fas fa-book"></i> Daftar Buku</h1>

        <!-- Search Form -->
        <form action="{{ route('books.index') }}" method="GET" class="mb-3 d-flex" role="search">
            <input type="text" name="search" class="form-control me-2"
                   placeholder="Cari judul" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
            @if(request('search'))
                <a href="{{ route('books.index') }}" class="btn btn-secondary"><i class="fas fa-sync"></i></a>
            @endif
        </form>

        <!-- Tombol buka modal -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahBukuModal">
            <i class="fas fa-plus"></i> Tambah Buku
        </button>

        <table class="table table-bordered table-striped table-hover align-middle">
            <thead>
            <tr class="table-secondary text-center">
                <th style="width: 10%">ID Buku</th>
                <th style="width: 45%">Judul</th>
                <th style="width: 10%">Jumlah</th>
                <th style="width: 35%">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($books as $book)
                <tr id="row-{{ $book->id_buku }}" class="text-center">
                    <td>{{ $book->id_buku }}</td>
                    <!-- Judul rata kiri -->
                    <td class="text-start">{{ $book->judul }}</td>
                    <!-- ✅ KOLOM JUMLAH BARU -->
                    <td>
                        <span class="badge bg-{{ $book->jumlah > 0 ? 'success' : 'secondary' }}">
                            {{ $book->jumlah ?? 0 }} Eksemplar
                        </span>
                    </td>
                    <td>
                        <!-- Tombol Detail (Show Modal) -->
                        <button class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#showModal{{ $book->id_buku }}">
                            <i class="fas fa-eye"></i> Detail
                        </button>

                        <!-- Modal Show - COMPACT VERSION -->
                        <div class="modal fade" id="showModal{{ $book->id_buku }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- Header -->
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title"><i class="fas fa-book-open"></i> Detail Buku</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Body -->
                                    <div class="modal-body py-2">
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr>
                                                <td width="35%" class="fw-bold text-start ps-2">ID Buku</td>
                                                <td width="5%" class="text-center">:</td>
                                                <td class="text-start">{{ $book->id_buku }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Judul</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $book->judul }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Jumlah Eksemplar</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">
                                                    <span class="badge bg-{{ $book->jumlah > 0 ? 'success' : 'secondary' }}">
                                                        {{ $book->jumlah ?? 0 }} Eksemplar
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Kategori</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $book->kategori->nama_kategori ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Subkategori</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $book->subkategori->nama_subkat ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Penerbit</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $book->penerbit->nama ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">ISBN</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $book->isbn ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Pengarang</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $book->pengarang ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Tahun Terbit</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $book->tahun_terbit ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Harga</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start"><span class="text-success">Rp {{ number_format($book->harga, 0, ',', '.') }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-start ps-2">Barcode</td>
                                                <td class="text-center">:</td>
                                                <td class="text-start">{{ $book->barcode ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Footer -->
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
                                data-bs-target="#editModal{{ $book->id_buku }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <!-- Modal Edit - COMPACT VERSION (DITAMBAH INPUT JUMLAH) -->
                        <div class="modal fade" id="editModal{{ $book->id_buku }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 500px;">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark py-2">
                                        <h6 class="modal-title mb-0"><i class="fas fa-edit"></i> Edit Buku</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('books.update', $book->id_buku) }}" method="POST" id="editForm{{ $book->id_buku }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body py-2 px-3">
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">ID Buku</label>
                                                <div class="col-8">
                                                    <input type="text" name="id_buku" class="form-control form-control-sm" value="{{ $book->id_buku }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Judul</label>
                                                <div class="col-8">
                                                    <input type="text" name="judul" class="form-control form-control-sm" value="{{ $book->judul }}" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Kategori</label>
                                                <div class="col-8">
                                                    <select name="id_kategori" class="form-select form-select-sm" required>
                                                        @foreach($kategoris as $k)
                                                            <option value="{{ $k->id_kategori }}" {{ $book->id_kategori == $k->id_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Subkategori</label>
                                                <div class="col-8">
                                                    <select name="id_subkat" class="form-select form-select-sm">
                                                        @foreach($subkategories as $s)
                                                            <option value="{{ $s->id_subkat }}" {{ $book->id_subkat == $s->id_subkat ? 'selected' : '' }}>{{ $s->nama_subkat }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Penerbit</label>
                                                <div class="col-8">
                                                    <select name="id_penerbit" class="form-select form-select-sm">
                                                        @foreach($penerbits as $p)
                                                            <option value="{{ $p->id_penerbit }}" {{ $book->id_penerbit == $p->id_penerbit ? 'selected' : '' }}>{{ $p->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">ISBN</label>
                                                <div class="col-8">
                                                    <input type="text" name="isbn" class="form-control form-control-sm" value="{{ $book->isbn }}">
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Pengarang</label>
                                                <div class="col-8">
                                                    <input type="text" name="pengarang" class="form-control form-control-sm" value="{{ $book->pengarang }}">
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Tahun Terbit</label>
                                                <div class="col-8">
                                                    <input type="number" name="tahun_terbit" class="form-control form-control-sm" value="{{ $book->tahun_terbit }}">
                                                </div>
                                            </div>
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Harga</label>
                                                <div class="col-8">
                                                    <input type="number" name="harga" class="form-control form-control-sm" value="{{ $book->harga }}">
                                                </div>
                                            </div>
                                            <!-- ✅ INPUT BARU: Jumlah Eksemplar -->
                                            <div class="row mb-2 align-items-center">
                                                <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Jumlah Eksemplar</label>
                                                <div class="col-8">
                                                    <input type="number" name="jumlah" class="form-control form-control-sm" value="{{ $book->jumlah ?? 0 }}" min="0" required>
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
                                data-bs-target="#hapusModal{{ $book->id_buku }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal{{ $book->id_buku }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content shadow-md border-0 rounded-3">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                                        <p class="mt-3">Apakah kamu yakin ingin menghapus <strong>{{ $book->judul }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                                        <form action="{{ route('books.destroy', $book->id_buku) }}" method="POST" class="d-inline delete-form" data-id="{{ $book->id_buku }}">
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
                    <td colspan="4" class="text-center">Belum ada data buku</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <!-- Modal Tambah Buku (DITAMBAH INPUT JUMLAH) -->
    <div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header bg-success text-white py-2">
                    <h6 class="modal-title mb-0"><i class="fas fa-plus"></i> Tambah Buku</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('books.store') }}" method="POST" id="addForm">
                    @csrf
                    <div class="modal-body py-2 px-3">
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Judul</label>
                            <div class="col-8">
                                <input type="text" name="judul" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Kategori</label>
                            <div class="col-8">
                                <select name="id_kategori" class="form-select form-select-sm" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Subkategori</label>
                            <div class="col-8">
                                <select name="id_subkat" class="form-select form-select-sm">
                                    <option value="" disabled selected>-- Pilih Subkategori --</option>
                                    @foreach($subkategories as $s)
                                        <option value="{{ $s->id_subkat }}">{{ $s->nama_subkat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Penerbit</label>
                            <div class="col-8">
                                <select name="id_penerbit" class="form-select form-select-sm">
                                    <option value="" disabled selected>-- Pilih Penerbit --</option>
                                    @foreach($penerbits as $p)
                                        <option value="{{ $p->id_penerbit }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">ISBN</label>
                            <div class="col-8">
                                <input type="text" name="isbn" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Pengarang</label>
                            <div class="col-8">
                                <input type="text" name="pengarang" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Tahun Terbit</label>
                            <div class="col-8">
                                <input type="number" name="tahun_terbit" class="form-control form-control-sm" placeholder="Format YYYY">
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Harga</label>
                            <div class="col-8">
                                <input type="number" name="harga" class="form-control form-control-sm" placeholder="Harga dalam Rupiah">
                            </div>
                        </div>
                        <!-- ✅ INPUT BARU: Jumlah Eksemplar -->
                        <div class="row mb-2 align-items-center">
                            <label class="col-4 col-form-label col-form-label-sm fw-bold mb-0">Jumlah Eksemplar</label>
                            <div class="col-8">
                                <input type="number" name="jumlah" class="form-control form-control-sm" placeholder="Jumlah stok buku" min="0" required>
                            </div>
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

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $books->links('pagination::simple-bootstrap-5') }}
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
                    }).then(res => {
                        if (res.ok) {
                            let modalEl = document.getElementById(`hapusModal${id}`);
                            let modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();
                            if (row) row.remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Buku berhasil dihapus!',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Gagal menghapus buku. Silakan coba lagi.',
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
                            text: 'Terjadi kesalahan saat menghapus buku.',
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
                    fetch(`{{ route('books.index') }}?search=${query}`, {
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    })
                        .then(res => res.text())
                        .then(html => {
                            let parser = new DOMParser();
                            let doc = parser.parseFromString(html, "text/html");
                            let newTbody = doc.querySelector("tbody");
                            if (newTbody) tableBody.innerHTML = newTbody.innerHTML;
                        });
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
                    }).then(res => {
                        if (res.ok) {
                            let modal = bootstrap.Modal.getInstance(document.getElementById('tambahBukuModal'));
                            modal.hide();
                            this.reset(); // Reset form
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Buku berhasil ditambahkan!',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            }).then(() => {
                                location.reload(); // Reload page setelah sukses
                            });
                        } else {
                            res.json().then(data => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message || 'Gagal menambahkan buku. Silakan coba lagi.',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            });
                        }
                    }).catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menambahkan buku.',
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
                    const id = this.action.split('/').pop(); // Ambil id dari URL
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    }).then(res => {
                        if (res.ok) {
                            let modal = bootstrap.Modal.getInstance(document.getElementById(`editModal${id}`));
                            modal.hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Buku berhasil diperbarui!',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            }).then(() => {
                                location.reload(); // Reload page setelah sukses
                            });
                        } else {
                            res.json().then(data => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message || 'Gagal memperbarui buku. Silakan coba lagi.',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            });
                        }
                    }).catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memperbarui buku.',
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
