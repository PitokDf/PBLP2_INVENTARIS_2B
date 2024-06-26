<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
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
        $peminjaman = Peminjaman::where('id', $request->kode_peminjaman)->where('status', false)->first();
        if (!$peminjaman) {
            return response()->json([
                'status' => 404,
                'message' => 'Kode Peminjaman Tidak Ditemukan.'
            ]);
        }
        $barang = Barang::find($peminjaman->id_barang);
        if ($peminjaman->jumlah > $barang->quantity) {
            return response()->json([
                'status' => 400,
                'message' => 'Barang yang ingin dipinjam kehabisam stok.'
            ]);
        }
        $barang->decrement('quantity', $peminjaman->jumlah);
        $peminjaman->update([
            'status' => true,
            'kode_peminjaman' => Peminjaman::getKodePeminjaman()
        ]);
        ActivityLog::createLog('update', 'menyetujui request peminjaman');
        return response()->json([
            'status' => 200,
            'message' => 'Peminjaman disetujui.'
        ]);
    }

    public function prosesRequest(Request $request)
    {
        $barang = Barang::where('code_barang', $request->code_barang)->first();
        $peminjaman = Peminjaman::where('id_user', auth()->user()->id_user)->where('id_barang', $barang->id_barang);

        $pending = $peminjaman->whereNull('kode_peminjaman')->where('status', 0)->exists();
        $exists = Peminjaman::where('id_user', auth()->user()->id_user)->where('id_barang', $barang->id_barang)->whereNull('tgl_pengembalian')->where('status', 1)->exists();

        if ($exists) {
            return response()->json([
                'status' => 203,
                'message' => 'Silahkan kembalikan barang.'
            ]);
        }
        if ($pending) {
            return response()->json([
                'status' => 203,
                'message' => 'Silahkan tunggu request peminjaman disetujui admin'
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
            'message' => 'Something went wrong.',
            'peminjaman' => $peminjaman->get(),
            'pending' => $pending,
            'exists' => $exists,
            'kode_barang' => $barang->id_barang,
            'user' => auth()->user()->id_user
        ]);
    }

    public function reject(Request $request)
    {
        Peminjaman::find($request->id)->update(['status' => 2]);
        return response()->json([
            'status' => 200,
            'message' => 'Peminjaman ditolak'
        ]);
    }

    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::where('id', $id)->first();


        if (!$peminjaman) {
            return response()->json([
                'status' => 400,
                'message' => 'Data not found'
            ]);
        }

        $peminjaman->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Record berhasil di hapus.'
        ]);
    }
}