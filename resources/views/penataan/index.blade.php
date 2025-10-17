@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-book"></i> Penataan Buku</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahPenataan">
                <i class="fas fa-plus"></i> Catat Penataan
            </button>
        </div>

        <!-- Search Form -->
        <form action="{{ route('penataan.index') }}" method="GET" class="mb-3">
            <div class="input-group" style="max-width:500px">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari judul buku atau nama rak..."
                       value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('penataan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-dark">
                        <tr class="text-center">
                            <th style="width: 5%">ID</th>
                            <th style="width: 25%">Judul Buku</th>
                            <th style="width: 15%">Nama Rak</th>
                            <th style="width: 8%">Kolom</th>
                            <th style="width: 8%">Baris</th>
                            <th style="width: 10%">Jumlah</th>
                            <th style="width: 14%">Penyusun</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($penataans as $penataan)
                            <tr class="text-center align-middle">
                                <td>{{ $penataan->id_penataan }}</td>
                                <td class="text-start">{{ $penataan->books->judul ?? 'N/A' }}</td>
                                <td>{{ $penataan->raks->nama ?? 'N/A' }}</td>
                                <td>{{ $penataan->kolom }}</td>
                                <td>{{ $penataan->baris }}</td>
                                <td>{{ $penataan->jumlah_buku }}</td>
                                <td>{{ $penataan->user->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('penataan.show', $penataan->id_penataan) }}"
                                           class="btn btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $penataan->id_penataan }}"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapus{{ $penataan->id_penataan }}"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    Belum ada data penataan buku
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $penataans->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Modal Tambah Penataan -->
    <div class="modal fade" id="modalTambahPenataan" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus"></i> Tambah Penataan Buku
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('penataan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Pilih Buku -->
                        <div class="mb-3">
                            <label>Judul Buku <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" id="selected_judul_buku_tambah"
                                       class="form-control" readonly
                                       placeholder="-- Klik tombol untuk pilih buku --">
                                <input type="hidden" name="id_buku" id="selected_id_buku_tambah">
                                <button type="button" class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalPilihBuku"
                                        data-form-type="tambah">
                                    <i class="fas fa-search"></i> Pilih Buku
                                </button>
                            </div>
                            @error('id_buku')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Nama Rak -->
                        <div class="mb-3">
                            <label>Nama Rak <span class="text-danger">*</span></label>
                            <select name="id_rak" class="form-control" required>
                                <option value="">-- Pilih Rak --</option>
                                @foreach($raks as $rak)
                                    <option value="{{ $rak->id_rak }}">{{ $rak->nama }}</option>
                                @endforeach
                            </select>
                            @error('id_rak')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Kolom -->
                            <div class="col-md-6 mb-3">
                                <label>Kolom <span class="text-danger">*</span></label>
                                <input type="number" name="kolom" class="form-control"
                                       min="1" value="1" required>
                                @error('kolom')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Baris -->
                            <div class="col-md-6 mb-3">
                                <label>Baris <span class="text-danger">*</span></label>
                                <input type="number" name="baris" class="form-control"
                                       min="1" value="1" required>
                                @error('baris')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Jumlah Buku -->
                        <div class="mb-3">
                            <label>Jumlah Buku <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_buku" class="form-control"
                                   min="1" value="1" required>
                            @error('jumlah_buku')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sumber_tambah"> Sumber <span class="text-danger">*</span></label>
                            <input type="text" name="sumber" id="sumber_tambah" placeholder="--sumber buku--"
                                   class="form-control"required>
                        </div>

                        <!-- Penyusun -->
                        <div class="mb-3">
                            <label>Penyusun</label>
                            <input type="text" class="form-control"
                                   value="{{ Auth::user()->name }}" readonly>
                            <input type="hidden" name="id_user" value="{{ Auth::user()->id_user }}">
                            <small class="text-muted">Otomatis terisi dengan akun yang login</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Penataan (Loop untuk setiap data) -->
    @foreach($penataans as $penataan)
        <div class="modal fade" id="modalEdit{{ $penataan->id_penataan }}" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-edit"></i> Edit Penataan Buku
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('penataan.update', $penataan->id_penataan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <!-- Pilih Buku -->
                            <div class="mb-3">
                                <label>Judul Buku <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text"
                                           id="selected_judul_buku_edit_{{ $penataan->id_penataan }}"
                                           class="form-control"
                                           readonly
                                           value="{{ $penataan->books->judul ?? '' }}">
                                    <input type="hidden"
                                           name="id_buku"
                                           id="selected_id_buku_edit_{{ $penataan->id_penataan }}"
                                           value="{{ $penataan->id_buku }}">
                                    <button type="button" class="btn btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalPilihBuku"
                                            data-form-type="edit"
                                            data-penataan-id="{{ $penataan->id_penataan }}">
                                        <i class="fas fa-search"></i> Pilih Buku
                                    </button>
                                </div>
                            </div>

                            <!-- Nama Rak -->
                            <div class="mb-3">
                                <label>Nama Rak <span class="text-danger">*</span></label>
                                <select name="id_rak" class="form-control" required>
                                    <option value="">-- Pilih Rak --</option>
                                    @foreach($raks as $rak)
                                        <option value="{{ $rak->id_rak }}"
                                            {{ $penataan->id_rak == $rak->id_rak ? 'selected' : '' }}>
                                            {{ $rak->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <!-- Kolom -->
                                <div class="col-md-6 mb-3">
                                    <label>Kolom <span class="text-danger">*</span></label>
                                    <input type="number" name="kolom" class="form-control"
                                           value="{{ $penataan->kolom }}" min="1" required>
                                </div>

                                <!-- Baris -->
                                <div class="col-md-6 mb-3">
                                    <label>Baris <span class="text-danger">*</span></label>
                                    <input type="number" name="baris" class="form-control"
                                           value="{{ $penataan->baris }}" min="1" required>
                                </div>
                            </div>

                            <!-- Jumlah Buku -->
                            <div class="mb-3">
                                <label>Jumlah Buku <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_buku" class="form-control"
                                       value="{{ $penataan->jumlah_buku }}" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="sumber_tambah"> Sumber <span class="text-danger">*</span></label>
                                <input type="text" name="sumber" id="sumber_tambah" placeholder="--sumber buku--"
                                       class="form-control" required>
                            </div>

                            <!-- Penyusun -->
                            <div class="mb-3">
                                <label>Penyusun</label>
                                <input type="text" class="form-control"
                                       value="{{ $penataan->user->name ?? 'N/A' }}" readonly>
                                <input type="hidden" name="id_user" value="{{ $penataan->id_user }}">
                                <small class="text-muted">Penyusun tidak dapat diubah</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Hapus Penataan (Loop untuk setiap data) -->
    @foreach($penataans as $penataan)
        <div class="modal fade" id="modalHapus{{ $penataan->id_penataan }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-trash"></i> Konfirmasi Hapus
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            Apakah Anda yakin ingin menghapus penataan ini?
                        </div>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="35%">Judul Buku</th>
                                <td>{{ $penataan->books->judul ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Nama Rak</th>
                                <td>{{ $penataan->raks->nama ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Lokasi</th>
                                <td>Kolom {{ $penataan->kolom }}, Baris {{ $penataan->baris }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Buku</th>
                                <td>{{ $penataan->jumlah_buku }} eksemplar</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('penataan.destroy', $penataan->id_penataan) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Pilih Buku -->
    <div class="modal fade" id="modalPilihBuku" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-book"></i> Pilih Buku
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Form search -->
                    <form id="search-buku-form" class="mb-3">
                        <div class="input-group" style="max-width:400px">
                            <input type="text" id="search-buku-input" class="form-control"
                                   placeholder="Cari judul buku...">
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <button type="button" id="reset-buku-search" class="btn btn-dark">
                                <i class="fas fa-sync"></i> Reset
                            </button>
                        </div>
                    </form>

                    <!-- Container table -->
                    <div id="buku-table-container">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary"></div>
                            <p class="mt-2 text-muted">Memuat data...</p>
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

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentFormType = '';
            let currentPenataanId = '';

            const modalPilihBuku = document.getElementById('modalPilihBuku');
            const modalTambah = document.getElementById('modalTambahPenataan');

            // Event modal pilih buku dibuka
            if (modalPilihBuku) {
                modalPilihBuku.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    currentFormType = button.getAttribute('data-form-type');
                    currentPenataanId = button.getAttribute('data-penataan-id') || '';
                    loadBukuTable();
                });

                // Event modal pilih buku ditutup
                modalPilihBuku.addEventListener('hidden.bs.modal', function() {
                    if (currentFormType === 'tambah' && modalTambah) {
                        bootstrap.Modal.getOrCreateInstance(modalTambah).show();
                    } else if (currentFormType === 'edit' && currentPenataanId) {
                        const modalEdit = document.querySelector(`#modalEdit${currentPenataanId}`);
                        if (modalEdit) {
                            bootstrap.Modal.getOrCreateInstance(modalEdit).show();
                        }
                    }
                });
            }

            // Load tabel buku
            function loadBukuTable(search = '', page = 1) {
                const container = document.getElementById('buku-table-container');
                if (!container) return;

                const url = `{{ route('penataan.get-books') }}?search=${encodeURIComponent(search)}&page=${page}`;

                fetch(url)
                    .then(res => res.text())
                    .then(html => {
                        container.innerHTML = html;
                        attachPilihButtonListeners();
                        attachPaginationListeners();
                    })
                    .catch(() => {
                        container.innerHTML = '<div class="alert alert-danger">Gagal memuat data buku</div>';
                    });
            }

            // Event pilih buku
            function attachPilihButtonListeners() {
                document.querySelectorAll('.pilih-buku').forEach(button => {
                    button.addEventListener('click', function() {
                        const idBuku = this.dataset.id;
                        const judulBuku = this.dataset.judul;

                        if (currentFormType === 'tambah') {
                            document.getElementById('selected_id_buku_tambah').value = idBuku;
                            document.getElementById('selected_judul_buku_tambah').value = judulBuku;
                        } else if (currentFormType === 'edit' && currentPenataanId) {
                            document.getElementById(`selected_id_buku_edit_${currentPenataanId}`).value = idBuku;
                            document.getElementById(`selected_judul_buku_edit_${currentPenataanId}`).value = judulBuku;
                        }

                        const modal = bootstrap.Modal.getInstance(modalPilihBuku);
                        if (modal) modal.hide();
                    });
                });
            }

            // Event pagination
            function attachPaginationListeners() {
                document.querySelectorAll('#buku-table-container .pagination a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = new URL(this.href);
                        const page = url.searchParams.get('page') || 1;
                        const search = document.getElementById('search-buku-input')?.value || '';
                        loadBukuTable(search, page);
                    });
                });
            }

            // Search form
            const searchForm = document.getElementById('search-buku-form');
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const search = document.getElementById('search-buku-input').value;
                    loadBukuTable(search);
                });
            }

            // Reset button
            const resetButton = document.getElementById('reset-buku-search');
            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    const input = document.getElementById('search-buku-input');
                    if (input) input.value = '';
                    loadBukuTable();
                });
            }
        });
    </script>
@endpush
