<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\VarianController;
use App\Http\Controllers\User\WishlistController;
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
        /*
    |------------------
    | ❤️ Wishlist
    |------------------
    */
    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');

    Route::post('/wishlist/{produk}', [WishlistController::class, 'toggle'])
        ->name('wishlist.toggle');

    Route::delete('/wishlist/{produk}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    /*
    |------------------
    | 🛒 Cart
    |------------------
    */
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/{produk}', [CartController::class, 'store'])
        ->name('cart.store');

    Route::patch('/cart/{cart}', [CartController::class, 'update'])
    ->name('cart.update');

    Route::post('/cart/from-wishlist/{produk}', [CartController::class, 'fromWishlist'])
        ->name('cart.fromWishlist');

    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])
        ->name('cart.destroy');

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

        //banners
        Route::resource('banners', BannerController::class);

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
