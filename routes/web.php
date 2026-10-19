<?php

use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

// Rute untuk menampilkan daftar produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

// Rute untuk menampilkan form tambah produk (opsional jika menggunakan modal)
Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');

// Rute untuk memproses penyimpanan data
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');

// Rute untuk menampilkan form edit produk (Route Model Binding otomatis)
Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');

// Rute untuk memproses update data (menggunakan method PUT/PATCH)
Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');

// Rute untuk memproses delete data
Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');