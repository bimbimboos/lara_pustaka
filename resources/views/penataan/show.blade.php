@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Detail Penataan
            </h1>
            <a href="{{ route('penataan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Card Detail Penataan -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="bg-blue-600 text-white px-4 py-3">
                <h5 class="text-lg font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Informasi Penataan
                </h5>
            </div>
            <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="border-l-4 border-blue-500 pl-3">
                    <small class="text-gray-500">ID Penataan</small>
                    <h5 class="font-semibold">{{ $penataan->id_penataan }}</h5>
                </div>
                <div class="border-l-4 border-blue-500 pl-3">
                    <small class="text-gray-500">Judul Buku</small>
                    <h5 class="font-semibold">{{ $penataan->books->judul ?? 'N/A' }}</h5>
                </div>
                <div class="border-l-4 border-blue-500 pl-3">
                    <small class="text-gray-500">Nama Rak</small>
                    <h5 class="font-semibold">{{ $penataan->raks->nama ?? 'N/A' }}</h5>
                </div>
                <div class="border-l-4 border-blue-500 pl-3">
                    <small class="text-gray-500">Kolom</small>
                    <h5 class="font-semibold">{{ $penataan->kolom }}</h5>
                </div>
                <div class="border-l-4 border-blue-500 pl-3">
                    <small class="text-gray-500">Baris</small>
                    <h5 class="font-semibold">{{ $penataan->baris }}</h5>
                </div>
                <div class="border-l-4 border-blue-500 pl-3">
                    <small class="text-gray-500">Kapasitas</small>
                    <h5 class="font-semibold">
                        <span class="badge bg-info text-white">
                            Terisi: {{ $terisi }} | Tersisa: {{ $tersisa }} / {{ $kapasitas_total }} slot
                        </span>
                    </h5>
                </div>
                <div class="border-l-4 border-blue-500 pl-3">
                    <small class="text-gray-500">Penyusun</small>
                    <h5 class="font-semibold">{{ $penataan->user->name }}</h5>
                </div>
                <div class="border-l-4 border-blue-500 pl-3">
                    <small class="text-gray-500">Tanggal Disusun</small>
                    <h5 class="font-semibold">{{ $penataan->insert_date ?? 'N/A' }}</h5>
                </div>
                <div class="border-l-4 border-blue-500 pl-3">
                    <small class="text-gray-500">Tanggal Diedit</small>
                    <h5 class="font-semibold">{{ $penataan->modified_date ?? 'N/A' }}</h5>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-2">
            <button wire:click="confirmDelete" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Hapus Penataan
            </button>
            <a href="{{ route('penataan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <a href="{{ route('raks.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Lihat Rak
            </a>
        </div>

        <!-- Modal Hapus -->
        <div x-data="{ open: false }" x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50" @click.away="open = false">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md" @click.stop>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Hapus</h2>
                    <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="text-center">
                    <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>W
                    <p class="text-gray-600 mb-2">Yakin ingin hapus penataan buku <strong>{{ $books->judul ?? 'N/A' }}</strong>?</p>
                    <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
                <div class="mt-6 flex justify-end space-x-2">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Batal</button>
                    <button wire:click="deletePenataan" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('modalManager', () => ({
                open: false,
                close() {
                    this.open = false;
                }
            }));
        });

        window.addEventListener('showDeleteModal', () => {
            const modal = Alpine.store('modalManager');
            modal.open = true;
        });

        window.addEventListener('closeModal', () => {
            const modal = Alpine.store('modalManager');
            modal.open = false;
        });

        window.addEventListener('notify', (event) => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: event.detail.message,
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>
@endpush
