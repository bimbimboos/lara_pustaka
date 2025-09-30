@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                <i class="bi bi-box-seam text-primary fs-3"></i>
                            </div>
                            <div>
                                <h2 class="mb-1 fw-bold">Edit Rak</h2>
                                <p class="text-muted mb-0">Perbarui informasi rak penyimpanan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('raks.update', $rak->id_rak) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama Rak -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-tag me-2 text-primary"></i>Nama Rak
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="nama"
                                    class="form-control form-control-lg @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $rak->nama) }}"
                                    placeholder="Contoh: Rak A1"
                                    required
                                >
                                @error('nama')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                                <small class="form-text text-muted">Nama untuk mengidentifikasi rak</small>
                            </div>

                            <!-- Barcode -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-upc-scan me-2 text-primary"></i>Barcode
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="barcode"
                                    class="form-control form-control-lg @error('barcode') is-invalid @enderror"
                                    value="{{ old('barcode', $rak->barcode) }}"
                                    placeholder="Masukkan kode barcode"
                                    required
                                >
                                @error('barcode')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                                <small class="form-text text-muted">Kode unik untuk scanning rak</small>
                            </div>

                            <!-- Row untuk Kolom dan Baris -->
                            <div class="row">
                                <!-- Kolom -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-grid-3x3 me-2 text-primary"></i>Kolom
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        name="kolom"
                                        class="form-control form-control-lg @error('kolom') is-invalid @enderror"
                                        value="{{ old('kolom', $rak->kolom) }}"
                                        min="1"
                                        placeholder="0"
                                        required
                                    >
                                    @error('kolom')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                    <small class="form-text text-muted">Jumlah kolom horizontal</small>
                                </div>

                                <!-- Baris -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-grid-3x3-gap me-2 text-primary"></i>Baris
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        name="baris"
                                        class="form-control form-control-lg @error('baris') is-invalid @enderror"
                                        value="{{ old('baris', $rak->baris) }}"
                                        min="1"
                                        placeholder="0"
                                        required
                                    >
                                    @error('baris')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                    <small class="form-text text-muted">Jumlah baris vertikal</small>
                                </div>
                            </div>

                            <!-- Info Box -->
                            <div class="alert alert-info border-0 d-flex align-items-start mb-4">
                                <i class="bi bi-info-circle fs-5 me-2 mt-1"></i>
                                <div>
                                    <strong>Info:</strong> Total kapasitas rak adalah
                                    <strong><span id="totalKapasitas">{{ $rak->kolom * $rak->baris }}</span> slot</strong>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3 pt-3 border-top">
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('raks.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                    <i class="bi bi-x-circle me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .form-control:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            }

            .card {
                transition: all 0.3s ease;
            }

            .btn {
                transition: all 0.3s ease;
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            }

            .alert-info {
                background-color: #cfe2ff;
                color: #084298;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Hitung total kapasitas secara realtime
            document.addEventListener('DOMContentLoaded', function() {
                const kolomInput = document.querySelector('input[name="kolom"]');
                const barisInput = document.querySelector('input[name="baris"]');
                const totalSpan = document.getElementById('totalKapasitas');

                function updateTotal() {
                    const kolom = parseInt(kolomInput.value) || 0;
                    const baris = parseInt(barisInput.value) || 0;
                    totalSpan.textContent = kolom * baris;
                }

                kolomInput.addEventListener('input', updateTotal);
                barisInput.addEventListener('input', updateTotal);
            });
        </script>
    @endpush
@endsection
