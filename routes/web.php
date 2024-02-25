<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;

use App\Http\Controllers\AccountController;



use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\TrackingStatusController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Auth;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/account/register', [AccountController::class, 'register'])->name('account.register');

Route::get('/', function () {
    return redirect()->action([HomeController::class, 'index']);
});
Route::get('/landing', [HomeController::class, 'landing'])->name('landing');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('detail-pemesanan/{id}', [HomeController::class, 'detail'])->name('detail-pemesanan');

    Route::resource('produk', ProdukController::class);
    Route::get('pemesanan/{id}', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('daftar-pesanan', [PemesananController::class, 'daftarPesanan'])->name('daftar-pesanan');
    Route::post('/produk/imageUpload', [ProdukController::class, 'imageUpload'])->name('produk.imageUpload');
    Route::delete('/produk/destroyAttach/{id}', [ProdukController::class, 'destroyAttach'])->name('produk.destroyAttach');
    Route::get('pembayaran/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::get('tracking-status', [PemesananController::class, 'trackingIndex'])->name('tracking.index');
    Route::get('tracking-status/{id}', [PemesananController::class, 'tracking'])->name('tracking');

    Route::get('autoPrint', [PemesananController::class, 'autoPrint'])->name('autoPrint');



    Route::post('/user/cek_password', [UsersController::class, 'cekPass'])->name('cek_password');

    Route::post('/laporan/daftar-pesanan-pdf', [PemesananController::class, 'daftarPesananPDF'])->name('laporan.daftarPesanan');

    Route::resource('tracking', TrackingStatusController::class);
    Route::resource('pemesanan', PemesananController::class);
    Route::resource('laporan', LaporanController::class);
    Route::resource('profil', ProfilController::class);
    Route::resource('users', UsersController::class);

    


});



