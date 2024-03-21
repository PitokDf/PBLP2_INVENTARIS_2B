<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswasController;
use App\Http\Controllers\UsersController;
use App\Models\Users;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $userCount = Users::count();
    return view("dashboard.index")->with("count", $userCount);
});

Route::resource('user', UsersController::class);
Route::get('getAllDataUser', [UsersController::class, "getAllData"]);
Route::resource("kategori-berita", KategoriBeritaController::class);
Route::get('getAllDataKategori', [KategoriBeritaController::class, "getData"]);
Route::resource("dosen", DosenController::class);
Route::get('getAllDataDosen', [DosenController::class, "getData"]);
Route::resource("kategori-barang", KategoriBarangController::class);
Route::get("getKategori", [KategoriBarangController::class, "getKategori"]);
Route::resource("barang", BarangController::class);
Route::get('getAllDataBarang', [BarangController::class, "getData"]);
Route::resource("mahasiswa", MahasiswasController::class);
Route::get("getAllDataMahasiswa", [MahasiswasController::class, "getData"]);

Route::get("dashboard", function () {
    $userCount = Users::count();
    return view("dashboard.index")->with("count", $userCount);
})->name('dashboard');

Route::fallback(
    function () {
        return view("404");
    }
);