<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanUmumController extends Controller
{
    public function index()
    {
        return view("umum.peminjaman.index");
    }
}