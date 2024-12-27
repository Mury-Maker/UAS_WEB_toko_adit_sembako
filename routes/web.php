<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AdminTransaksiDetailController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/login',[AdminAuthController::class, 'index'] )->name('login')->middleware('guest');
Route::post('/login/do',[AdminAuthController::class, 'doLogin'] )->middleware('guest');

Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
Route::get('/admin/laporan/bulanan', [AdminLaporanController::class, 'penghasilanBulanan']);
Route::get('admin/laporan/transaksi-pdf', [AdminLaporanController::class, 'exportPdf'])->name('admin.laporan.transaksiPdf');
Route::get('/admin/laporan/export-excel', [AdminLaporanController::class, 'exportExcel'])->name('admin.laporan.exportExcel');


Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout',[AdminAuthController::class, 'logout'] )->middleware('auth');

Route::get('/', function () {
    $data = [
        'content'   => 'admin.dashboard.index'
    ];
    return view('admin.layouts.wrapper', $data);
})->middleware('auth');

Route::prefix('/admin')->middleware('auth')->group(function(){
    Route::get('/dashboard', function () {
        $data = [
            'content'   => 'admin.dashboard.index'
        ];
        return view('admin.layouts.wrapper', $data);
    });

    Route::get('/transaksi/detail/selesai/{id}', [AdminTransaksiDetailController::class, 'done']);
    Route::get('/transaksi/detail/delete', [AdminTransaksiDetailController::class, 'delete']);
    Route::post('/transaksi/detail/create', [AdminTransaksiDetailController::class, 'create']);
    Route::resource('/transaksi', AdminTransaksiController::class);
    Route::resource('/produk', AdminProdukController::class);
    Route::resource('/kategori', AdminKategoriController::class);


    
    Route::resource('/user', AdminUserController::class);
    
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/bulanan', [AdminLaporanController::class, 'penghasilanBulanan']);
    Route::get('/laporan/transaksi-pdf', [AdminLaporanController::class, 'exportPdf'])->name('admin.laporan.transaksiPdf');
    Route::get('/laporan/export-excel', [AdminLaporanController::class, 'exportExcel'])->name('admin.laporan.exportExcel');
    Route::resource('/laporan', AdminLaporanController::class)->except(['index', 'create', 'store', 'destroy']); // Sesuaikan resource jika tidak semua metode digunakan
});




