<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('user', UsersController::class);
Route::get('getAllDataUser', [UsersController::class, "getAllData"]);