@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Penataan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('penataan.update', $penataan->id_penataan) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-bold">ID Penataan</label>
                                <input type="text" name="id_penataan" class="form-control" value="{{ $penataan->id_penataan }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Kode Rak</label>
                                <select name="kode_rak" class="form-select @error('kode_rak') is-invalid @enderror" required>
                                    @foreach($raks as $rak)
                                        <option value="{{ $rak->id_rak }}" {{ $penataan->id_rak == $rak->id_rak ? 'selected' : '' }}>
                                            {{ $rak->id_rak }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kode_rak')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Buku</label>
                                <select name="id_buku" class="form-select @error('id_buku') is-invalid @enderror" required>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id_buku }}" {{ $penataan->id_buku == $book->id_buku ? 'selected' : '' }}>
                                            {{ $book->judul }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_buku')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update
                                </button>
                                <a href="{{ route('penataan.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
