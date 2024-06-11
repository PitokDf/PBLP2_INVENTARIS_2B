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

    private function printPdf($view, $header, $data, $fileName)
    {
        Carbon::setLocale('id');
        $pdf = Pdf::loadView($view, [
            'header' => $header,
            'data' => $data,
            'time' => Carbon::create(date('Y'), date('m'), date('d'))->translatedFormat('l, j F Y'),
            'title' => $header
        ]);
        return $pdf->stream($fileName);
    }

    public function cetakStok()
    {
        return $this->printPdf(
            'reports.pdf.report_stok',
            'Laporan Stok Barang',
            Barang::with([
                'peminjaman' => function ($query) {
                    $query->whereNull('tgl_pengembalian');
                }
            ])->latest()->get(),
            'laporan-stok.pdf'
        );
    }
    public function cetakBarang()
    {
        return $this->printPdf(
            'reports.pdf.report_barang',
            'Laporan Data Barang',
            Barang::with('kategori')->latest()->get(),
            'laporan-barang.pdf'
        );
    }
    public function cetakBarangMasuk()
    {
        return $this->printPdf(
            'reports.pdf.report_barang_masuk',
            'Laporan Barang Masuk',
            BarangMasuk::with(['barang', 'pemasok'])->latest()->get(),
            'laporan-barang-masuk.pdf'
        );
    }
    public function cetakBarangKeluar()
    {
        return $this->printPdf(
            'reports.pdf.report_stok',
            'Laporan Stok Barang',
            BarangMasuk::with(['barang', 'pemasok'])->latest()->get(),
            'laporan-barang-keluar.pdf'
        );
    }
    public function cetakPeminjaman()
    {
        return $this->printPdf(
            'reports.pdf.report_peminjaman',
            'Laporan Peminjaman Barang',
            Peminjaman::with(['barang', 'user'])->where('status', '=', true)->orderBy('kode_peminjaman')->get(),
            'laporan-peminjaman.pdf'
        );
    }
}