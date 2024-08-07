<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BugReportController;
use App\Http\Controllers\CommandHelper;
use App\Http\Controllers\CopyRightMeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\MahasiswasController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamanUmumController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestPeminjaman;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UsersController;
use App\Models\Barang;
use App\Models\Dosen;
use App\Models\KategoriBarang;
use App\Models\Mahasiswas;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::middleware('me')->group(function () {
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
    });
    Route::get('reload-capcha', [SessionController::class, 'reloadCapcha']);


    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        if (Auth::user()->role == 3 || Auth::user()->role == 4 || Auth::user()->role == 5) {
            return redirect('peminjamanUmum');
        } elseif (Auth::user()->role == 1 || Auth::user()->role == 2) {
            return redirect('/');
        }
    })->middleware(['auth.withMessage', 'signed'])->name('verification.verify');

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth.withMessage')->name('verification.notice');

    Route::get('topThreeBarang', [DashboardController::class, 'getTopThreeBarang']);

    Route::get('editData/{id}', [UsersController::class, "edit"]);
    Route::middleware(['auth.withMessage', 'verified'])->group(function () {
        Route::get('getAllDataBarang', [BarangController::class, "getData"]);
        Route::group(["middleware" => "userAkses:1|2"], function () {
            Route::resource('/', DashboardController::class);
            Route::get('report-stok', [ReportController::class, 'cetakStok'])->name('cetak.pdf');
            Route::get('report-barang', [ReportController::class, 'cetakBarang'])->name('cetak.barang');
            Route::get('report-peminjaman', [ReportController::class, 'cetakPeminjaman'])->name('cetak.peminjaman');
            Route::get('report-barang-masuk', [ReportController::class, 'cetakBarangMasuk'])->name('cetak.barang.masuk');
            Route::get('report-barang-keluar', [ReportController::class, 'cetakBarangKeluar'])->name('cetak.barang.masuk');
            Route::get('/laporan-barang', [ReportController::class, 'reportBarang']);
            Route::get('/laporan-barang-masuk', [ReportController::class, 'reportBarangMasuk']);
            Route::get('/laporan-barang-keluar', [ReportController::class, 'reportBarangKeluar']);
            Route::get('/laporan-peminjaman', [ReportController::class, 'reportPeminjaman']);
            Route::get('/laporan-stok', [ReportController::class, 'reportStok']);
            Route::get('test', function () {
                $result = KategoriBarang::with([
                    'barang.peminjaman' => function ($query) {
                        $query->whereNull('tgl_pengembalian')->where('status', '=', true);
                    }
                ])->latest()->get()->map(function ($kategori) {
                    return [
                        'jumlah_peminjaman' => $kategori->barang->sum(function ($barang) {
                            return $barang->peminjaman->sum('jumlah');
                        })
                    ];
                });
                $kategori = KategoriBarang::latest()->get();
                $labels = [];
                $idKategori = [];
                $stock = [];
                $bgColor = [];

                foreach ($kategori as $item) {
                    $labels[] = $item->nama_kategori_barang;
                    $idKategori[] = $item->id;
                    $bgColor[] = "rgba(" . rand(0, 255) . ", " . rand(0, 255) . ", " . rand(0, 255) . ", 0.4)";
                }
                for ($i = 0; $i < count($idKategori); $i++) {
                    $stock[] = Barang::with(['kategori', 'peminjaman'])->where('id_kategory', $idKategori[$i])->get()->sum('quantity');
                };
                return response()->json([
                    "data" => [
                        "labels" => $labels,
                        "stok" => $stock,
                        "dipinjam" => $result,
                        "bgcolor" => $bgColor,
                    ],
                ]);
            });
        });

        Route::get('get-barang/{code}', [BarangController::class, "getById"]);
        Route::group(["middleware" => "userAkses:1"], function () {
            Route::get('activity', [ActivityLogController::class, 'index'])->name('activity');
            Route::get('/admin-report', [AdminReportController::class, 'index']);
            Route::get('getEmailDosen/{id}', function ($id) {
                $data = Dosen::find($id);
                if (!$data) {
                    return response()->json(['staus' => 404, 'message' => 'Data not found']);
                }
                return response()->json(['status' => 200, 'email' => $data->email, 'nama' => $data->name]);
            });
            Route::get('getNamaMahasiswa/{id}', function ($id) {
                $data = Mahasiswas::find($id);
                if (!$data) {
                    return response()->json(['staus' => 404, 'message' => 'Data not found']);
                }
                return response()->json(['status' => 200, 'nama' => $data->nama]);
            });
            Route::resource('user', UsersController::class);
            Route::get('getAllDataUser', [UsersController::class, "getAllData"]);
            Route::post('importUser', [UsersController::class, "import"]);
            Route::get('exportUser', [UsersController::class, "export"])->name('user.export');
            Route::get('/unlink-dosen/{nip}', [UsersController::class, "unlinkDosen"]);
            Route::get('/unlink-mahasiswa/{nim}', [UsersController::class, "unlinkMahasiswa"]);
            Route::get('exportUser', [UsersController::class, "export"])->name('user.export');
            Route::resource("kategori-berita", KategoriBeritaController::class);
            Route::get('getAllDataKategori', [KategoriBeritaController::class, "getData"]);
            Route::resource("dosen", DosenController::class);
            Route::get('getAllDataDosen', [DosenController::class, "getData"]);
            Route::get('getDosenNip', [DosenController::class, "getDosenNip"]);
            Route::resource("kategori-barang", KategoriBarangController::class);
            Route::get("getKategori", [KategoriBarangController::class, "getKategori"]);
            Route::resource("barang", BarangController::class);
            Route::delete("barangs/bulk-delete", [BarangController::class, 'bulkDelete']);
            Route::get('barangs/contoh/file', function () {
                return response()->download(public_path('asset/barang/Barangs.csv'), 'exp-import-barang.csv');
            })->name('download.barang');
            Route::get('getAllMerk', [MerkController::class, "getData"]);
            Route::resource('merk-barang', MerkController::class);
            Route::resource("mahasiswa", MahasiswasController::class);
            Route::get("/getMahasiswaNim", [MahasiswasController::class, 'getMahasiswaNim']);
            Route::post("importMahasiswa", [MahasiswasController::class, 'import']);
            Route::get("exportMahasiswa", [MahasiswasController::class, 'export'])->name('mahasiswa.export');
            Route::get("exportBarang", [BarangController::class, 'export'])->name('barang.export');
            Route::post("importBarang", [BarangController::class, 'import']);
            Route::get("getAllDataMahasiswa", [MahasiswasController::class, "getData"]);
            Route::resource("berita", BeritaController::class);
            Route::get("getBerita", [BeritaController::class, "getData"]);
            Route::resource('prodi', ProdiController::class);
            Route::get('getAllDataProdi', [ProdiController::class, 'getData']);
            Route::resource('jabatan', JabatanController::class);
            Route::get('getAllJabatan', [JabatanController::class, 'getAllData']);
            Route::get('getDataPeminjaman', [PeminjamanController::class, 'getData']);
            Route::get('request-peminjaman', [RequestPeminjaman::class, 'index']);
            Route::delete('hapus-peminjaman/{id}', [RequestPeminjaman::class, 'destroy']);
            Route::post('setujui-peminjaman', [RequestPeminjaman::class, 'setujui']);
            Route::post('reject-peminjaman', [RequestPeminjaman::class, 'reject']);
            Route::get('getRequestPeminjaman', function () {
                return response()->json(['status' => 200, 'data' => Peminjaman::with(['barang', 'user', 'user.dosen', 'user.mahasiswa'])->get()]);
            });
            Route::resource('peminjaman', PeminjamanController::class);
            Route::resource('barangM', BarangMasukController::class);
            Route::get('getDataBarangMasuk', [BarangMasukController::class, 'getData']);
            route::get('scan-barang/{kode}', [BarangMasukController::class, 'scanBarang'])->middleware('me');
            Route::resource('barang-keluar', BarangKeluarController::class);
            Route::get('getDatabarangKeluar', [BarangKeluarController::class, 'getAllData']);
            Route::resource('pemasok', PemasokController::class);
            Route::get('/getDataPemasok', [PemasokController::class, 'getAllData']);
            Route::get('/getKodePeminjaman', function () {
                return Peminjaman::getKodePeminjaman();
            });
            Route::get('get-data-report-bug', [BugReportController::class, "getAllData"]);
            Route::delete('report-bug/{id}', [BugReportController::class, "destroy"]);
            Route::put('report-bug/{id}', [BugReportController::class, "update"]);
        });

        Route::group(["middleware" => ["userAkses:3|4|5"]], function () {
            Route::get('/pengembalian', function () {
                return view('pengembalian.index');
            });
            Route::post('request-peminjaman', [RequestPeminjaman::class, 'prosesRequest']);
            Route::resource('peminjamanUmum', PeminjamanUmumController::class);
            Route::get('/detail-peminjaman/{id}', [PeminjamanController::class, 'show']);
            Route::post('/lengkapi-data', [PeminjamanUmumController::class, "lengkapi"]);
            Route::get('/detail-barang/{id}', [BarangController::class, 'show']);
            Route::get('/roleMahasiswa', function () {
                User::where('id_user', auth()->user()->id_user)->update([
                    'role' => '4'
                ]);
                return redirect('peminjamanUmum');
            })->name('mahasiswa');
            Route::get('/roleDosen', function () {
                User::where('id_user', auth()->user()->id_user)->update([
                    'role' => '3'
                ]);
                return redirect('peminjamanUmum');
            })->name('dosen');
            Route::get('/daftar-barang', function () {
                return view('umum.barang');
            });
            Route::get('/riwayat-peminjaman', function () {
                $data = Peminjaman::with(['user', 'barang'])->where('id_user', Auth::user()->id_user)->latest()->get();
                return view('umum.riwayat_peminjaman')->with('peminjaman', $data);
            });
            Route::get('/get-riwayat-peminjaman', function () {
                $data = Peminjaman::with(['user', 'barang'])->where('id_user', Auth::user()->id_user)->latest()->get();
                return response()->json(['data' => $data]);
            });
        });

        Route::group(['middleware' => ['userAkses:2|3|4|5']], function () {
            Route::post('report-bug', [BugReportController::class, "store"]);
            Route::get('/profile', [ProfileController::class, 'index']);
            Route::post('/edit-akun', [ProfileController::class, 'editAkun']);
            Route::post('/edit-profile', [ProfileController::class, 'editProfile']);
        });

    });
    Route::get("logout", [SessionController::class, "logout"])->name('logout');

    Route::fallback(
        function () {
            return view("404");
        }
    );

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!')->withInput();
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    Route::get('helper', [CommandHelper::class, 'index']);
    Route::post('helper', [CommandHelper::class, 'execCommand'])->name('helper.exec');
});
Route::resource('copyrighttome', CopyRightMeController::class);