<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
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
        return view("admin.reports.barang")->with("barangs", $data);
    }
    public function reportBarangMasuk()
    {
        $data = BarangMasuk::with(['barang', 'pemasok'])->latest('tanggal_masuk')->get();
        return view("admin.reports.barang-masuk")->with("barangs", $data);
    }
    public function reportBarangKeluar()
    {
        $data = BarangKeluar::latest()->get();
        return view("admin.reports.barang-keluar")->with("barangs", $data);
    }
    public function reportPeminjaman()
    {
        $data = Peminjaman::with('barang')->latest()->get();
        return view("admin.reports.peminjaman")->with("peminjamans", $data);
    }


    public function reportStok()
    {
        $data = Barang::with([
            'peminjaman' => function ($query) {
                $query->whereNull('tgl_pengembalian');
            }
        ])->latest()->get();
        return view("admin.reports.stok")->with("barangs", $data);
    }

    private function printPdf($view, $header, $data, $fileName, $time = null)
    {
        Carbon::setLocale('id');
        $pdf = Pdf::loadView($view, [
            'header' => $header,
            'data' => $data,
            'time' => $time ?? Carbon::create(date('Y'), date('m'), date('d'))->translatedFormat('l, j F Y'),
            'title' => $header
        ]);
        return $pdf->stream($fileName);
    }

    public function cetakStok()
    {
        return $this->printPdf(
            'admin.reports.pdf.report_stok',
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
            'admin.reports.pdf.report_barang',
            'Laporan Data Barang',
            Barang::with('kategori')->latest()->get(),
            'laporan-barang.pdf'
        );
    }
    public function cetakBarangMasuk()
    {
        $time = null;
        if (request('awal') || request('akhir')) {
            $data = BarangMasuk::with(['barang', 'pemasok'])->whereBetween('tanggal_masuk', [request('awal'), request('akhir')])->latest('tanggal_masuk')->get();
            $time = 'Dari ' . request('awal') . ' sampai ' . request('akhir');
        } else {
            $data = BarangMasuk::with(['barang', 'pemasok'])->latest('tanggal_masuk')->get();
        }
        return $this->printPdf(
            'admin.reports.pdf.report_barang_masuk',
            'Laporan Barang Masuk',
            $data,
            'laporan-barang-masuk.pdf',
            $time
        );
    }
    public function cetakBarangKeluar()
    {
        $time = null;
        if (request('awal') || request('akhir')) {
            $data = BarangKeluar::with(['barang', 'user'])->whereBetween('tgl_keluar', [request('awal'), request('akhir')])->latest('tgl_keluar')->get();
            $time = 'Dari ' . request('awal') . ' sampai ' . request('akhir');
        } else {
            $data = BarangKeluar::with(['barang', 'user'])->latest('tgl_keluar')->get();
        }

        return $this->printPdf(
            'admin.reports.pdf.report_barang_keluar',
            'Laporan Barang Keluar',
            $data,
            'laporan-barang-keluar.pdf',
            $time
        );
    }
    public function cetakPeminjaman()
    {
        return $this->printPdf(
            'admin.reports.pdf.report_peminjaman',
            'Laporan Peminjaman Barang',
            Peminjaman::with(['barang', 'user'])->where('status', '=', true)->orderBy('kode_peminjaman')->get(),
            'laporan-peminjaman.pdf'
        );
    }
}