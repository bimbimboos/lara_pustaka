<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SubkategoriController;
use App\Http\Controllers\BookItemsController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\LokasiController;


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

    // ✅ Nested resource untuk bookitems
    Route::prefix('books/{id_buku}/items')->name('bookitems.')->group(function() {
        Route::get('/', [BookItemsController::class, 'index'])->name('index');
        Route::post('/', [BookItemsController::class, 'store'])->name('store');
        Route::get('/{id_buku_item}', [BookItemsController::class, 'show'])->name('show');
        Route::get('/{id_buku_item}/edit', [BookItemsController::class, 'edit'])->name('edit');
        Route::put('/{id_buku_item}', [BookItemsController::class, 'update'])->name('update');
        Route::delete('/{id_buku_item}', [BookItemsController::class, 'destroy'])->name('destroy');
    });

    Route::resource('users', UserController::class);
    // Route untuk Google login
    Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);
    Route::resource('/raks', RakController::class);
    Route::resource('/lokasi', LokasiController::class);
});


// Auth
require __DIR__.'/auth.php';
