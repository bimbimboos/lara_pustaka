<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SubkategoriController;
use App\Http\Controllers\ItemsController; // Ganti ke BookItemsController kalau bener
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PenataanBukuController;

// Halaman utama -> redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Master Data
Route::middleware('auth')->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('subkategori', SubkategoriController::class);
    Route::resource('penerbit', PenerbitController::class);
    Route::resource('books', BooksController::class);
    Route::resource('users', UserController::class);
    Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);
    Route::resource('/raks', RakController::class);
    Route::resource('/lokasi', LokasiController::class);
    Route::get('penataan/get-books', [PenataanBukuController::class, 'getBooksForModal'])->name('penataan.get-books');
    Route::resource('penataan', PenataanBukuController::class);
    Route::resource('/bookitems', ItemsController::class); // Ganti ke BookItemsController

    // Tambahan rute untuk Lihat Eksemplar
    Route::get('/raks/{id_rak}/bookitems', [RakController::class, 'showBookItems'])->name('raks.bookitems');
});

// Auth
require __DIR__.'/auth.php';
