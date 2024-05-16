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
        $data = Peminjaman::with(['user', 'barang'])->get();

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
            'namaBarang' => 'required|exists:barang,id_barang',
            'namaUser' => 'required|exists:users,id_user',
            'tglPeminjaman' => 'required|date|date_equals:' . date('Y-m-d'),
            'batasPengembalian' => 'required|date|date_equals:' . date('Y-m-d', strtotime('+7 days'))
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $quantity = Barang::find($request->namaBarang);
        if ($quantity->quantity > 0) {
            Peminjaman::create([
                'id_barang' => $request->namaBarang,
                'id_user' => $request->namaUser,
                'tgl_peminjaman' => $request->tglPeminjaman,
                'batas_pengembalian' => $request->batasPengembalian
            ]);

            Barang::findOrFail($request->namaBarang)->decrement('quantity', 1);
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil Melakukan Peminjaman.'
            ]);
        } else {
            return response()->json([
                'status' => 202,
                'message' => 'Barang yang ingin anda pinjam barus aja tidak tersedia.'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        //
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
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Peminjaman::findOrFail($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Menghapus Peminjaman'
        ]);
    }
}