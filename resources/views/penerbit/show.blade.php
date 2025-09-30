{{-- resources/views/penerbit/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-info-circle"></i> Detail Penerbit
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong><i class="fas fa-id-card"></i> ID Penerbit</strong>
                            </div>
                            <div class="col-md-8">
                                <span class="badge bg-primary fs-6">{{ $penerbit->id_penerbit }}</span>
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
                                <a href="tel:{{ $penerbit->kontak }}" class="text-decoration-none">
                                    <i class="fas fa-phone-square"></i> {{ $penerbit->kontak }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <a href="{{ route('penerbit.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('penerbit.edit', $penerbit->id_penerbit) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu yakin ingin menghapus penerbit <strong>{{ $penerbit->nama }}</strong>?</p>
                    <p class="text-muted">Data yang dihapus tidak dapat dikembalikan.</p>
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
@endsection
