<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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

    public function cetakStok()
    {
        Carbon::setLocale('id');
        $pdf = Pdf::loadView('reports.pdf.report_stok', [
            'header' => 'Laporan Stok Barang',
            'data' => Barang::with([
                'peminjaman' => function ($query) {
                    $query->whereNull('tgl_pengembalian');
                }
            ])->latest()->get(),
            'time' => Carbon::create(date('Y'), date('m'), date('d'))->translatedFormat('l, j F Y'),
            'title' => 'Laporan Stok Barang'
        ]);

        return $pdf->stream('laporan-stok.pdf');
    }
    public function cetakBarang()
    {
        Carbon::setLocale('id');
        $pdf = Pdf::loadView('reports.pdf.report_barang', [
            'header' => 'Laporan Ketersedian Barang',
            'data' => Barang::with('kategori')->latest()->get(),
            'time' => Carbon::create(date('Y'), date('m'), date('d'))->translatedFormat('l, j F Y'),
            'title' => 'Laporan Ketersedian Barang'
        ]);

        return $pdf->stream('laporan-barang.pdf');
    }
    public function cetakBarangMasuk()
    {
        Carbon::setLocale('id');
        $pdf = Pdf::loadView('reports.pdf.report_barang_masuk', [
            'header' => 'Laporan Barang Masuk',
            'data' => BarangMasuk::with(['barang', 'pemasok'])->latest()->get(),
            'time' => Carbon::create(date('Y'), date('m'), date('d'))->translatedFormat('l, j F Y'),
            'title' => 'Laporan Barang Masuk'
        ]);

        return $pdf->stream('laporan-barang-masuk.pdf');
    }
    public function cetakBarangKeluar()
    {
        Carbon::setLocale('id');
        $pdf = Pdf::loadView('reports.pdf.report_stok', [
            'header' => 'Laporan Stok Barang',
            'data' => BarangMasuk::with(['barang', 'pemasok'])->latest()->get(),
            'time' => Carbon::create(date('Y'), date('m'), date('d'))->translatedFormat('l, j F Y'),
            'title' => 'Laporan Stok Barang'
        ]);

        return $pdf->stream('laporan-barang-keluar.pdf');
    }
    public function cetakPeminjaman()
    {
        Carbon::setLocale('id');
        $pdf = Pdf::loadView('reports.pdf.report_peminjaman', [
            'header' => 'Laporan Peminjaman Barang',
            'data' => Peminjaman::with(['barang', 'user'])->where('status', '=', true)->latest()->get(),
            'time' => Carbon::create(date('Y'), date('m'), date('d'))->translatedFormat('l, j F Y'),
            'title' => 'Laporan Peminjaman'
        ]);

        return $pdf->stream('laporan-peminjaman.pdf');
    }
}