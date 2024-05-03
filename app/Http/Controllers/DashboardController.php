<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getTopThreeBarang()
    {
        $barang = Barang::select(['nama_barang', 'quantity'])->orderBy('quantity', 'desc')->take(6)->get();

        return response()->json([
            'status' => 200,
            'message' => 'data berhasil didapatkan, gunakan dengan hati-hati.',
            'data' => $barang
        ]);
    }
}