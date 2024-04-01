<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\MahasiswasController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UsersController;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
    Route::get("login", [SessionController::class, "index"]);
    Route::post("login", [SessionController::class, "login"])->name('login');
});

Route::group(['middleware' => ['auth', 'userAkses:2,3,4,5']], function () {
    Route::get('/test', function () {
        echo "diizinkan";
    });
});

Route::middleware(['auth'])->group(function () {
    Route::middleware('userAkses:1')->group(function () {
        Route::middleware('userAkses:1')->group(function () {
            Route::get('/', function () {
                $userCount = Users::count();
                return view("dashboard.index")->with("count", $userCount);
            })->name('dashboard');
        });
        Route::resource('user', UsersController::class);
        Route::get('getAllDataUser', [UsersController::class, "getAllData"]);
        Route::post('importUser', [UsersController::class, "import"]);
        Route::get('exportUser', [UsersController::class, "export"])->name('user.export');
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
        Route::resource("berita", BeritaController::class);
        Route::get("getBerita", [BeritaController::class, "getData"]);
    });
    // Route::group(['middleware' => 'userAkses:1'], function () {
    //     // Route::get('/', function () {
    //     //     $userCount = Users::count();
    //     //     return view("dashboard.index")->with("count", $userCount);
    //     // })->name('dashboard');
    //     Route::resource('user', UsersController::class);
    //     Route::get('getAllDataUser', [UsersController::class, "getAllData"]);
    //     Route::post('importUser', [UsersController::class, "import"]);
    //     Route::get('exportUser', [UsersController::class, "export"])->name('user.export');
    //     Route::resource("kategori-berita", KategoriBeritaController::class);
    //     Route::get('getAllDataKategori', [KategoriBeritaController::class, "getData"]);
    //     Route::resource("dosen", DosenController::class);
    //     Route::get('getAllDataDosen', [DosenController::class, "getData"]);
    //     Route::resource("kategori-barang", KategoriBarangController::class);
    //     Route::get("getKategori", [KategoriBarangController::class, "getKategori"]);
    //     Route::resource("barang", BarangController::class);
    //     Route::get('getAllDataBarang', [BarangController::class, "getData"]);
    //     Route::resource("mahasiswa", MahasiswasController::class);
    //     Route::get("getAllDataMahasiswa", [MahasiswasController::class, "getData"]);
    //     Route::resource("berita", BeritaController::class);
    //     Route::get("getBerita", [BeritaController::class, "getData"]);
    // });

    // Route::middleware('userAkses:1')->group(function () {
    //     Route::get('/', function () {
    //         $userCount = Users::count();
    //         return view("dashboard.index")->with("count", $userCount);
    //     })->name('dashboard');
    // });
    // Route::middleware('userAkses:2')->group(function () {
    //     Route::get('/', function () {
    //         $userCount = Users::count();
    //         return view("dashboard.index")->with("count", $userCount);
    //     })->name('dashboard');
    // });

    // Route::middleware('userAkses:3,4,5')->group(function () {
    //     Route::resource("berita", BeritaController::class);
    //     Route::get("getBerita", [BeritaController::class, "getData"]);
    // });

    // Route::group(['middleware' => 'userAkses:3,4,5'], function () {
    //     // echo "hehei";
    // });

    Route::get("logout", [SessionController::class, "logout"])->name('logout');
});

Route::fallback(
    function () {
        return view("404");
    }
);