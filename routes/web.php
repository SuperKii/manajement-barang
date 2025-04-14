<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\RiwayatStokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('app.dashboard.index');
})->middleware('auth')->name('dashboard');

Route::get('/login', [AuthController::class, "login"])->name('login');
Route::post('/loginProses', [AuthController::class, "loginProses"])->name('loginProses');

// Route::get('/register',[AuthController::class, "register"])->name('register');
// Route::post('/registerProses',[AuthController::class, "registerProses"])->name('registerProses');
Route::get('/logout', [AuthController::class, "logout"])->name('logout');

Route::prefix('Barang')->group(function () {
    Route::get('/barangIndex', [BarangController::class, 'index'])->name('barangIndex');
    Route::get('/barangAdd', [BarangController::class, 'create'])->name('barangAdd');
    Route::POST('/barangStore', [BarangController::class, 'store'])->name('barangStore');
    Route::get('/barangEdit/{id}', [BarangController::class, 'edit'])->name('barangEdit');
    Route::POST('/barangUpdate{id}', [BarangController::class, 'update'])->name('barangUpdate');
    Route::get('/barangDelete/{id}', [BarangController::class, "destroy"])->name('barangDelete');
});
Route::prefix('Kategori')->group(function () {
    Route::get('/kategoriIndex', [KategoriController::class, 'index'])->name('kategoriIndex');
    Route::get('/kategoriAdd', [KategoriController::class, 'create'])->name('kategoriAdd');
    Route::POST('/kategoriStore', [KategoriController::class, 'store'])->name('kategoriStore');
    Route::get('/kategoriEdit/{id}', [KategoriController::class, 'edit'])->name('kategoriEdit');
    Route::POST('/kategoriUpdate{id}', [KategoriController::class, 'update'])->name('kategoriUpdate');
    Route::get('/kategoriDelete/{id}', [KategoriController::class, "destroy"])->name('kategoriDelete');
});
Route::prefix('User')->group(function () {
    Route::get('/userIndex', [UserController::class, 'index'])->name('userIndex');
    Route::get('/userAdd', [UserController::class, 'create'])->name('userAdd');
    Route::POST('/userStore', [UserController::class, 'store'])->name('userStore');
    Route::get('/userEdit/{id}', [UserController::class, 'edit'])->name('userEdit');
    Route::POST('/userUpdate{id}', [UserController::class, 'update'])->name('userUpdate');
    Route::get('/userDelete/{id}', [UserController::class, "destroy"])->name('userDelete');
});

Route::prefix('Pengiriman')->group(function() {
    Route::get('/pengirimanIndex',[PengirimanController::class,'index'])->name('pengirimanIndex');
    Route::get('/pengirimanNota',[PengirimanController::class,'create'])->name('pengirimanNota');
    Route::get('/pengirimanDetail/{id}',[PengirimanController::class,'show'])->name('pengirimanDetail');
    Route::post('/pengirimanStore',[PengirimanController::class,'store'])->name('pengirimanStore');
});
Route::prefix('Penerimaan')->group(function() {
    Route::get('/penerimaanIndex',[PenerimaanController::class,'index'])->name('penerimaanIndex');
    Route::get('/penerimaanNota',[PenerimaanController::class,'create'])->name('penerimaanNota');
    Route::get('/penerimaanDetail/{id}',[PenerimaanController::class,'show'])->name('penerimaanDetail');
    Route::post('/penerimaanStore',[PenerimaanController::class,'store'])->name('penerimaanStore');
});

Route::prefix('Nota')->group(function(){
    Route::post('/notaStore',[NotaController::class,'store'])->name('notaStore');
    Route::get('/notaDestroy',[NotaController::class,'destroy'])->name('notaDestroy');
});

Route::prefix('LogActivity')->group(function(){
    Route::get('/logActivity',[LogActivityController::class,'index'])->name('logActivityIndex');
});

Route::prefix('RiwayatStok')->group(function(){
    Route::get('/riwayatStok',[RiwayatStokController::class,'index'])->name('riwayatIndex');
});

Route::prefix('Verifikasi')->group(function(){
    Route::get('/verifikasiPenerimaan',[VerifikasiController::class,'indexPenerimaan'])->name('verifikasiPenerimaan');
    Route::get('/verifikasiPengiriman',[VerifikasiController::class,'indexPengiriman'])->name('verifikasiPengiriman');
    Route::get('/catatanTransaksi',[VerifikasiController::class,'indexCatatanTransaksi'])->name('catatanTransaksi');
    Route::POST('/updatePenerimaan/{id}',[VerifikasiController::class,'updatePenerimaan'])->name('updatePenerimaan');
    Route::POST('/updatePengiriman/{id}',[VerifikasiController::class,'updatePengiriman'])->name('updatePengiriman');
});
