<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportBarang()
    {
        $data = Barang::with('kategori')->latest()->get();
        return view("reports.barang")->with("barangs", $data);
    }
    public function reportBarangMasuk()
    {
        $data = BarangMasuk::with(['barang', 'pemasok'])->latest()->get();
        return view("reports.barang-masuk")->with("barangs", $data);
    }
    public function reportBarangKeluar()
    {
        $data = Barang::latest()->get();
        return view("reports.barang")->with("barangs", $data);
    }
    public function reportPeminjaman()
    {
        $data = Peminjaman::with('barang')->latest()->get();
        return view("reports.peminjaman")->with("peminjamans", $data);
    }
    public function reportStok()
    {
        $data = Barang::with([
            'peminjaman' => function ($query) {
                $query->whereNull('tgl_pengembalian');
            }
        ])->latest()->get();
        return view("reports.stok")->with("barangs", $data);
    }
}