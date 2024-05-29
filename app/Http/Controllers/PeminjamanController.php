<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::latest()->where('quantity', '>', '0')->get();
        $user = User::where('role', '!=', '1')->where('email_verified_at', '!=', null)->latest()->get();
        return view('peminjaman.index')->with(['barangs' => $barang, 'users' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getData()
    {
        $data = Peminjaman::with(['user', 'barang'])->latest()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil ditemukan',
            'data' => $data
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaBarang' => 'required|exists:barang,code_barang',
            'namaUser' => 'required|exists:users,id_user',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required'
        ], [
            'namaBarang.required' => 'kode harus diisi.',
            'namaBarang.exists' => 'Kode barang tidak terdaftar.',
            'namaUser.required' => 'Pilih Peminjam.',
            'namaUser.exists' => 'User tidak tersedia.',
            'quantity.integer' => 'Jumlah harus numeric.',
            'quantity.min' => 'Jumlah minimal :min.',
            'reason.required' => 'Alasan Peminjaman harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $barang = Barang::where('code_barang', $request->namaBarang)->first();
        $user = User::where('id_user', $request->namaUser)->first();

        // $barang = Barang::where('code_barang', $request->namaBarang)->first();
        $existingPeminjaman = Peminjaman::where('id_barang', $barang->id_barang)
            ->where('id_user', $request->namaUser)
            ->whereNull('tgl_pengembalian')
            ->exists();

        if ($existingPeminjaman == true) {
            return response()->json([
                'status' => 202,
                'message' => 'Tidak bisa melakukan peminjaman untuk barang yang belum dikembalikan.'
            ]);
        }

        if ($request->quantity > $barang->quantity) {
            return response()->json([
                'status' => 202,
                'message' => 'Stok tidak mencukupi.'
            ]);
        }

        if ($barang->quantity > 0) {
            Peminjaman::create([
                'id_barang' => $barang->id_barang,
                'id_user' => $request->namaUser,
                'tgl_peminjaman' => now(),
                'jumlah' => $request->quantity,
                'keterangan' => $request->reason,
                'kode_peminjaman' => Peminjaman::getKodePeminjaman(),
                'batas_pengembalian' => date('Y-m-d', strtotime('+7 days'))
            ]);

            $barang->decrement('quantity', $request->quantity);
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil Melakukan Peminjaman.'
            ]);
        } else {
            return response()->json([
                'status' => 202,
                'message' => 'Barang yang ingin anda pinjam baru saja tidak tersedia.'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $peminjaman = Peminjaman::with([
            'user' => function ($query) {
                $query->select('id_user', 'username');
            },
            'barang' => function ($query) {
                $query->select('id_barang', 'code_barang', 'nama_barang');
            }
        ])->where('id', $id)->first();

        if ($peminjaman) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil mendapatkan data.',
                'data' => $peminjaman
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kondisi' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $peminjaman = Peminjaman::findOrFail($id);
        $dataPeminjam = Peminjaman::with(['user', 'barang'])->where('id', $id)->first();
        $peminjaman->update(
            [
                'tgl_pengembalian' => now(),
                'status' => true,
                "kondisi" => $request->kondisi
            ]
        );
        Barang::findOrFail($dataPeminjam->barang->id_barang)->increment('quantity', $peminjaman->jumlah);
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Mengembalikan Barang.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::find($id);
        if ($peminjaman->tgl_pengembalian === null) {
            return response()->json([
                'status' => 202,
                'message' => 'Gagal menghapus peminjaman, barang harus dikembalikan.'
            ]);
        }
        Peminjaman::findOrFail($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Menghapus Peminjaman'
        ]);
    }
}