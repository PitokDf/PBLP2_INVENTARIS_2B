<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\UsersController;
use App\Models\Users;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('user', UsersController::class);
Route::get('getAllDataUser', [UsersController::class, "getAllData"]);
Route::resource("kategori-berita", KategoriBeritaController::class);
Route::get('getAllDataKategori', [KategoriBeritaController::class, "getData"]);
Route::resource("dosen", DosenController::class);
Route::get('getAllDataDosen', [DosenController::class, "getData"]);

Route::get("dashboard", function () {
    $userCount = Users::count();
    return view("dashboard.index")->with("count", $userCount);
})->name('dashboard');