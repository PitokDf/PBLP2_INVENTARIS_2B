<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function download()
    {
        $data = ['title' => 'Laporan Stok'];
        $pdf = Pdf::loadView('pdf_view', compact('data'));
        return $pdf->download('laporan-stok');
    }
}