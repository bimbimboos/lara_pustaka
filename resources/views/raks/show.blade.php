@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-info-circle"></i> Detail Rak</h1>
            <a href="{{ route('raks.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Card Detail Rak -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-box"></i> Informasi Rak</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="border-start border-primary border-4 ps-3">
                            <small class="text-muted d-block">ID Rak</small>
                            <h5 class="mb-0">{{ $rak->id_rak }}</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border-start border-primary border-4 ps-3">
                            <small class="text-muted d-block">Nama Rak</small>
                            <h5 class="mb-0">{{ $rak->nama }}</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border-start border-primary border-4 ps-3">
                            <small class="text-muted d-block">Barcode</small>
                            <h5 class="mb-0"><span class="badge bg-secondary fs-6">{{ $rak->barcode }}</span></h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border-start border-primary border-4 ps-3">
                            <small class="text-muted d-block">Jumlah Kolom</small>
                            <h5 class="mb-0">{{ $rak->kolom }}</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border-start border-primary border-4 ps-3">
                            <small class="text-muted d-block">Jumlah Baris</small>
                            <h5 class="mb-0">{{ $rak->baris }}</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border-start border-primary border-4 ps-3">
                            <small class="text-muted d-block">Total Kapasitas</small>
                            <h5 class="mb-0"><span class="badge bg-success fs-6">{{ $rak->kapasitas }} slot</span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Informasi Lokasi -->
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Informasi Lokasi</h5>
                @if($rak->Lokasi)
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editLokasiModal">
                        <i class="fas fa-edit"></i> Edit Lokasi
                    </button>
                @endif
            </div>
            <div class="card-body">
                @if($rak->Lokasi)
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="border-start border-info border-4 ps-3">
                                <small class="text-muted d-block">ID Lokasi</small>
                                <h5 class="mb-0">{{ $rak->Lokasi->id_lokasi }}</h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-start border-info border-4 ps-3">
                                <small class="text-muted d-block">Nama Ruang</small>
                                <h5 class="mb-0">{{ $rak->Lokasi->ruang }}</h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-start border-info border-4 ps-3">
                                <small class="text-muted d-block">Lantai</small>
                                <h5 class="mb-0">{{ $rak->Lokasi->lantai ?? '-' }}</h5>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-triangle"></i> Lokasi belum ditentukan untuk rak ini.
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal">
                <i class="fas fa-trash"></i> Hapus Rak
            </button>
        </div>
    </div>

    <!-- Modal Edit Lokasi -->
    @if($rak->Lokasi)
        <div class="modal fade" id="editLokasiModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 shadow-lg">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Lokasi Rak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('lokasi.update', $rak->Lokasi->id_lokasi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Ruang <span class="text-danger">*</span></label>
                                <input type="text" name="ruang" class="form-control" value="{{ $rak->Lokasi->ruang }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Lantai</label>
                                <input type="text" name="lantai" class="form-control" value="{{ $rak->Lokasi->lantai }}">
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
    @endif

    <!-- Modal Hapus Rak -->
    <div class="modal fade" id="hapusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                    <p class="mt-3">Apakah kamu yakin ingin menghapus rak <strong>{{ $rak->nama }}</strong>?</p>
                    <p class="text-muted mb-0">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <form action="{{ route('raks.destroy', $rak->id_rak) }}" method="POST" class="d-inline">
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
@endsection
