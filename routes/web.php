<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\MahasiswasController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UsersController;
use App\Models\Barang;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Telescope\Telescope;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::middleware(['guest'])->group(function () {
    Route::get("login", [SessionController::class, "index"]);
    Route::post("login", [SessionController::class, "login"])->name('login');
    Route::get("forgot", [SessionController::class, "forgotShow"])->name('forgotpass');
    Route::get("register", [SessionController::class, "register"])->name('register');
    Route::post("register", [SessionController::class, "prosesRegister"])->name('register.proses');
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    if (Auth::user()->role == 3 || Auth::user()->role == 4 || Auth::user()->role == 5) {
        return redirect('umum');
    } elseif (Auth::user()->role == 1 || Auth::user()->role == 2) {
        return redirect('/');
    }
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('editData/{id}', [UsersController::class, "edit"]);
Route::middleware(['auth', 'verified'])->group(function () {
    Route::group(["middleware" => "userAkses:1|2"], function () {
        Route::get('/', function () {
            $userCount = Barang::count();
            return view("dashboard.index")->with("count", $userCount);
        })->name('dashboard');
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
        Route::get("getAllDataMahasiswa", [MahasiswasController::class, "getData"]);
        Route::resource("berita", BeritaController::class);
        Route::get("getBerita", [BeritaController::class, "getData"]);

        // // Telescope API routes
        // Route::get('telescope/telescope-api/batches', 'QueueBatchesController@index');
        // Route::get('telescope/telescope-api/batches/{telescopeEntryId}', 'QueueBatchesController@show');
        // Route::post('telescope/telescope-api/cache', 'CacheController@index');
        // Route::get('telescope/telescope-api/cache/{telescopeEntryId}', 'CacheController@show');
        // Route::post('telescope/telescope-api/client-requests', 'ClientRequestController@index');
        // Route::get('telescope/telescope-api/client-requests/{telescopeEntryId}', 'ClientRequestController@show');
        // Route::post('telescope/telescope-api/commands', 'CommandsController@index');
        // Route::get('telescope/telescope-api/commands/{telescopeEntryId}', 'CommandsController@show');
        // Route::post('telescope/telescope-api/dumps', 'DumpController@index');
        // Route::delete('telescope/telescope-api/entries', 'EntriesController@destroy');
        // Route::post('telescope/telescope-api/events', 'EventsController@index');
        // Route::get('telescope/telescope-api/events/{telescopeEntryId}', 'EventsController@show');
        // Route::post('telescope/telescope-api/exceptions', 'ExceptionController@index');
        // Route::get('telescope/telescope-api/exceptions/{telescopeEntryId}', 'ExceptionController@show');
        // Route::put('telescope/telescope-api/exceptions/{telescopeEntryId}', 'ExceptionController@update');
        // Route::post('telescope/telescope-api/gates', 'GatesController@index');
        // Route::get('telescope/telescope-api/gates/{telescopeEntryId}', 'GatesController@show');
        // Route::post('telescope/telescope-api/jobs', 'QueueController@index');
        // Route::get('telescope/telescope-api/jobs/{telescopeEntryId}', 'QueueController@show');
        // Route::post('telescope/telescope-api/logs', 'LogController@index');
        // Route::get('telescope/telescope-api/logs/{telescopeEntryId}', 'LogController@show');
        // Route::post('telescope/telescope-api/mail', 'MailController@index');
        // Route::get('telescope/telescope-api/mail/{telescopeEntryId}', 'MailController@show');
        // Route::get('telescope/telescope-api/mail/{telescopeEntryId}/download', 'MailEmlController@show');
        // Route::get('telescope/telescope-api/mail/{telescopeEntryId}/preview', 'MailHtmlController@show');
        // Route::post('telescope/telescope-api/models', 'ModelsController@index');
        // Route::get('telescope/telescope-api/models/{telescopeEntryId}', 'ModelsController@show');
        // Route::get('telescope/telescope-api/monitored-tags', 'MonitoredTagController@index');
        // Route::post('telescope/telescope-api/monitored-tags', 'MonitoredTagController@store');
        // Route::post('telescope/telescope-api/monitored-tags/delete', 'MonitoredTagController@destroy');
        // Route::post('telescope/telescope-api/notifications', 'NotificationsController@index');
        // Route::get('telescope/telescope-api/notifications/{telescopeEntryId}', 'NotificationsController@show');
        // Route::post('telescope/telescope-api/queries', 'QueriesController@index');
        // Route::get('telescope/telescope-api/queries/{telescopeEntryId}', 'QueriesController@show');
        // Route::post('telescope/telescope-api/redis', 'RedisController@index');
        // Route::get('telescope/telescope-api/redis/{telescopeEntryId}', 'RedisController@show');
        // Route::post('telescope/telescope-api/requests', 'RequestsController@index');
        // Route::get('telescope/telescope-api/requests/{telescopeEntryId}', 'RequestsController@show');
        // Route::post('telescope/telescope-api/schedule', 'ScheduleController@index');
        // Route::get('telescope/telescope-api/schedule/{telescopeEntryId}', 'ScheduleController@show');
        // Route::post('telescope/telescope-api/toggle-recording', 'RecordingController@toggle');
        // Route::post('telescope/telescope-api/views', 'ViewsController@index');
        // Route::get('telescope/telescope-api/views/{telescopeEntryId}', 'ViewsController@show');

        // // Route untuk Telescope non-API
        // Route::get('telescope/{view?}', '\Laravel\Telescope\Http\Controllers\HomeController@index');

    });

    Route::group(["middleware" => "userAkses:3|4|5"], function () {
        Route::get('umum', function () {
            return "Halaman untuk user umum belum dibuat.<br><a href='logout'>logout</a>";
        });
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