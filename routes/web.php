<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\VarianController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\GambarVarianController;
use App\Http\Controllers\User\ProdukController as UserProdukController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', [UserProdukController::class, 'index'])->name('home');
Route::get('/produk/{produk}', [UserProdukController::class, 'show'])->name('produk.show');

/*
|--------------------------------------------------------------------------
| User (Authenticated User)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Kategori
        Route::resource('kategori', KategoriController::class);

        // Produk
        Route::resource('produk', ProdukController::class);

        // Varian (Nested di Produk)
        Route::resource('produk.varian', VarianController::class);

Route::post(
            'produk/{produk}/varian/{varian}/gambar',
            [GambarVarianController::class, 'store']
        )->name('produk.varian.gambar.store');

        Route::patch(
            'gambar-varian/{gambar}/primary',
            [GambarVarianController::class, 'setPrimary']
        )->name('gambar-varian.primary');

        Route::delete(
            'gambar-varian/{gambar}',
            [GambarVarianController::class, 'destroy']
        )->name('gambar-varian.destroy');
    });

require __DIR__ . '/auth.php';
