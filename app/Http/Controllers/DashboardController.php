<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Mahasiswa;
use App\Models\Mahasiswas;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $dataBarang = Barang::sum('quantity');
        $dataKategori = KategoriBarang::count();
        $mahasiswa = Mahasiswas::count();
        $userVeirfied = User::where("email_verified_at", '!=', null);
        $pinjaman = Peminjaman::where("tgl_pengembalian", "=", null)->sum('jumlah');
        return view("dashboard.index")->with([
            "barang" => $dataBarang,
            'kategoriB' => $dataKategori,
            'user' => $userVeirfied,
            'pinjaman' => $pinjaman,
            'mahasiswa' => $mahasiswa,
        ]);
    }
    public function getTopThreeBarang()
    {
        $barang = Barang::select(['nama_barang', 'quantity'])->orderBy('quantity', 'desc')->take(3)->get();

        return response()->json([
            'status' => 200,
            'message' => 'data berhasil didapatkan, gunakan dengan hati-hati.',
            'data' => $barang
        ]);
    }
}