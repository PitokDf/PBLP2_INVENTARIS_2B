<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\CommandHelper;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\MahasiswasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamanUmumController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UsersController;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Prodi;
use App\Models\User;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Telescope\Telescope;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::middleware(['guest'])->group(function () {
    Route::get("login", [SessionController::class, "index"]);
    Route::post("login", [SessionController::class, "login"])->name('login');
    Route::get("forgot", [SessionController::class, "forgotShow"])->name('forgotpass');
    Route::post("forgot", [SessionController::class, "forgotSend"])->name('password.email');
    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-pass', ['token' => $token]);
    })->middleware('guest')->name('password.reset');
    Route::post('/reset-password', [SessionController::class, 'resetPass'])->middleware('guest')->name('password.update');
    Route::get("register", [SessionController::class, "register"])->name('register');
    Route::post("register", [SessionController::class, "prosesRegister"])->name('register.proses');
    Route::get('reload-capcha', [SessionController::class, 'reloadCapcha']);
});

Route::get('activity', [ActivityLogController::class, 'index'])->name('activity');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    if (Auth::user()->role == 3 || Auth::user()->role == 4 || Auth::user()->role == 5) {
        return redirect('peminjamanUmum');
    } elseif (Auth::user()->role == 1 || Auth::user()->role == 2) {
        return redirect('/');
    }
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('topThreeBarang', [DashboardController::class, 'getTopThreeBarang']);

Route::get('editData/{id}', [UsersController::class, "edit"]);
Route::middleware(['auth', 'verified'])->group(function () {
    Route::group(["middleware" => "userAkses:1|2"], function () {
        // Route::get('/', function () {
        //     $userCount = Barang::count();
        //     return view("dashboard.index")->with("count", $userCount);
        // })->name('dashboard');
        Route::resource('/', DashboardController::class);
    });

    Route::group(["middleware" => "userAkses:1"], function () {
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
        Route::post("importMahasiswa", [MahasiswasController::class, 'import']);
        Route::get("exportMahasiswa", [MahasiswasController::class, 'export'])->name('mahasiswa.export');
        Route::get("getAllDataMahasiswa", [MahasiswasController::class, "getData"]);
        Route::resource("berita", BeritaController::class);
        Route::get("getBerita", [BeritaController::class, "getData"]);
        Route::resource('prodi', ProdiController::class);
        Route::get('getAllDataProdi', [ProdiController::class, 'getData']);
        Route::resource('jabatan', JabatanController::class);
        Route::get('getAllJabatan', [JabatanController::class, 'getAllData']);
        Route::get('getDataPeminjaman', [PeminjamanController::class, 'getData']);
        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('barangM', BarangMasukController::class);
        Route::get('getDataBarangMasuk', [BarangMasukController::class, 'getData']);

    });

    Route::group(["middleware" => "userAkses:3|4|5"], function () {
        Route::resource('peminjamanUmum', PeminjamanUmumController::class);
        Route::get('/roleMahasiswa', function () {
            User::where('id_user', auth()->user()->id_user)->update([
                'role' => '4'
            ]);
            return redirect()->back();
        })->name('mahasiswa');
        Route::get('/roleDosen', function () {
            User::where('id_user', auth()->user()->id_user)->update([
                'role' => '3'
            ]);
            return redirect()->back();
        })->name('dosen');
    });

});
Route::get("logout", [SessionController::class, "logout"])->name('logout');

Route::fallback(
    function () {
        return view("404");
    }
);
use Illuminate\Http\Request;

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!')->withInput();
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('helper', [CommandHelper::class, 'index']);
Route::post('helper', [CommandHelper::class, 'execCommand'])->name('helper.exec');

Route::get('test', function () {
    $prodi = Prodi::all();
    return view('mahasiswa.index2')->with(['prodi' => $prodi]);
});