@extends('layouts.app')

@section('content')
<div class="container">
    <h1><i class="fas fa-book"></i> Daftar Buku</h1>

    <!-- Search Form -->
    <form action="{{ route('books.index') }}" method="GET" class="mb-3 d-flex" role="search">
        <input type="text" name="search" class="form-control me-2"
            placeholder="Cari judul/kategori/penerbit" value="{{ request('search') }}">
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
                <th style="width: 15%">Judul</th>
                <th style="width: 10%">Kategori</th>
                <th style="width: 10%">Penerbit</th>
                <th style="width: 10%">Subkategori</th>
                <th style="width: 15%">Barcode</th>
                <th style="width: 30%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
                <tr id="row-{{ $book->id_buku }}" class="text-center">
                    <!-- Judul rata kiri -->
                    <td class="text-start">{{ $book->judul }}</td>
                    <td>{{ $book->kategori->nama_kategori ?? 'tidak ada' }}</td>
                    <td>{{ $book->penerbit->nama ?? 'tidak ada' }}</td>
                    <td>{{ $book->subkategori->nama_subkat ?? 'tidak ada' }}</td>
                    <td>{{ $book->barcode }}</td>
                    <td>
                        <!-- Tombol Detail -->
                        <a href="{{ route('books.show', $book->id_buku) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>

                        <!-- Tombol Edit -->
                        <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $book->id_buku }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $book->id_buku }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content rounded-3 shadow-lg">
                              <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Buku</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>

                              <form action="{{ route('books.update', $book->id_buku) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <!-- Judul -->
                                    <div class="mb-3">
                                        <label class="form-label">Judul</label>
                                        <input type="text" name="judul" class="form-control"
                                               value="{{ $book->judul }}" required>
                                    </div>

                                    <!-- Kategori -->
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="id_kategori" class="form-select" required>
                                            @foreach($kategoris as $k)
                                                <option value="{{ $k->id_kategori }}"
                                                  {{ $book->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                                                  {{ $k->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Subkategori -->
                                    <div class="mb-3">
                                        <label class="form-label">Subkategori</label>
                                        <select name="id_subkat" class="form-select">
                                            @foreach($subkategories as $s)
                                                <option value="{{ $s->id_subkat }}"
                                                  {{ $book->id_subkat == $s->id_subkat ? 'selected' : '' }}>
                                                  {{ $s->nama_subkat }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Penerbit -->
                                    <div class="mb-3">
                                        <label class="form-label">Penerbit</label>
                                        <select name="id_penerbit" class="form-select">
                                            @foreach($penerbits as $p)
                                                <option value="{{ $p->id_penerbit }}"
                                                  {{ $book->id_penerbit == $p->id_penerbit ? 'selected' : '' }}>
                                                  {{ $p->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- ISBN -->
                                    <div class="mb-3">
                                        <label class="form-label">ISBN</label>
                                        <input type="text" name="isbn" class="form-control" value="{{ $book->isbn }}">
                                    </div>

                                    <!-- Pengarang -->
                                    <div class="mb-3">
                                        <label class="form-label">Pengarang</label>
                                        <input type="text" name="pengarang" class="form-control"
                                               value="{{ $book->pengarang }}">
                                    </div>

                                    <!-- Tahun Terbit -->
                                    <div class="mb-3">
                                        <label class="form-label">Tahun Terbit</label>
                                        <input type="number" name="tahun_terbit" class="form-control"
                                               value="{{ $book->tahun_terbit }}">
                                    </div>

                                    <!-- Harga -->
                                    <div class="mb-3">
                                        <label class="form-label">Harga</label>
                                        <input type="number" name="harga" class="form-control" value="{{ $book->harga }}">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Simpan</button>
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
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
                        <div class="modal fade" id="hapusModal{{ $book->id_buku }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $book->id_buku }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-md">
                            <div class="modal-content shadow-md border-0 rounded-3">

                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="hapusModalLabel{{ $book->id_buku }}"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                                <p class="mt-3">Apakah kamu yakin ingin menghapus <strong>{{ $book->judul }}</strong>?</p>
                            </div>

                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                                <form action="{{ route('books.destroy', $book->id_buku) }}" method="POST"
                                        class="d-inline delete-form" data-id="{{ $book->id_buku }}">
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
                    <td colspan="6" class="text-center">Belum ada data buku</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Tambah Buku -->
<div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="tambahBukuModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title" id="tambahBukuModalLabel"><i class="fas fa-plus"></i> Tambah Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <form action="{{ route('books.store') }}" method="POST">
            @csrf

            <!-- Judul -->
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" name="judul" required>
            </div>

            <!-- Kategori -->
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select name="id_kategori" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Penerbit -->
            <div class="mb-3">
                <label for="penerbit" class="form-label">Penerbit</label>
                <select name="id_penerbit" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Penerbit --</option>
                    @foreach($penerbits as $p)
                        <option value="{{ $p->id_penerbit }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Subkategori -->
            <div class="mb-3">
                <label for="subkategori" class="form-label">Subkategori</label>
                <select name="id_subkat" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Subkategori --</option>
                    @foreach($subkategories as $s)
                        <option value="{{ $s->id_subkat }}">{{ $s->nama_subkat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- ISBN -->
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" name="isbn">
            </div>

            <!-- Pengarang -->
            <div class="mb-3">
                <label for="pengarang" class="form-label">Pengarang</label>
                <input type="text" class="form-control" name="pengarang">
            </div>

            <!-- Tahun Terbit -->
            <div class="mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="text" class="form-control" name="tahun_terbit" placeholder="Format YYYY">
            </div>

            <!-- Harga -->
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" name="harga" placeholder="Harga dalam Rupiah">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>

    </div>
</div>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center mt-3">
    {{ $books->links('pagination::simple-bootstrap-5') }}
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
                    // Tutup modal
                    let modalEl = document.getElementById(`hapusModal${id}`);
                    let modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();

                    // Hapus row dari tabel
                    if (row) row.remove();

                    // Notifikasi
                    alert("Buku berhasil dihapus!");
                }
            });
        });
    });

    // Live search realtime
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
                // Ambil isi <tbody> dari response dan ganti isi tabel
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, "text/html");
                let newTbody = doc.querySelector("tbody");
                if (newTbody) tableBody.innerHTML = newTbody.innerHTML;
            });
        });
    }
});
</script>
@endpush
