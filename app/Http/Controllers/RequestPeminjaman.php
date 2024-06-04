<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestPeminjaman extends Controller
{
    public function index()
    {
        return view('admin.request_peminjaman');
    }
    public function setujui(Request $request)
    {
        $peminjaman = Peminjaman::where('kode_peminjaman', $request->kode_peminjaman)->where('status', false)->first();
        if (!$peminjaman) {
            return response()->json([
                'status' => 404,
                'message' => 'Kode Peminjaman Tidak Ditemukan.'
            ]);
        }

        Barang::find($peminjaman->id_barang)->decrement('quantity', $peminjaman->jumlah);
        $peminjaman->update([
            'status' => true
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Peminjaman disetujui.'
        ]);
    }

    public function prosesRequest(Request $request)
    {
        $barang = Barang::where('code_barang', $request->code_barang)->first();
        $existingPeminjaman = Peminjaman::where('id_user', '=', Auth::user()->id_user)
            ->where('id_barang', '=', $barang->id_barang)
            ->whereNull('tgl_pengembalian')->exists();

        if ($existingPeminjaman) {
            return response()->json([
                'status' => 203,
                'message' => 'Silahkan kembalikan/tunggu request peminjaman disetujui admin'
            ]);
        }
        if ($barang->quantity < $request->jumlah) {
            return response()->json([
                'status' => 203,
                'message' => 'Stok tidak cukup.'
            ]);
        }
        $request->validate([
            'code_barang' => 'required|exists:barang,code_barang',
            'jumlah' => 'required|numeric|min:1',
            'reason' => 'required|min:5'
        ]);

        $data = [
            'kode_peminjaman' => Peminjaman::getKodePeminjaman(),
            'id_barang' => $barang->id_barang,
            'id_user' => Auth::user()->id_user,
            'tgl_peminjaman' => now(),
            'batas_pengembalian' => date('Y-m-d', strtotime('+7 days')),
            'jumlah' => $request->jumlah,
            'keterangan' => $request->reason
        ];

        if (Peminjaman::create($data)) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil mengirim request, silahkan cek riwayat peminjaman untuk men-cek status request'
            ]);
        }
        return response()->json([
            'status' => 203,
            'message' => 'Something went wrong.'
        ]);
    }
}