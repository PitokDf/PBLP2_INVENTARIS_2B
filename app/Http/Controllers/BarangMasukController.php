<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangMasukRequest;
use App\Http\Requests\UpdateBarangMasukRequest;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Pemasok;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::orderByRaw('nama_barang')->get();
        $pemasok = Pemasok::orderByRaw('nama')->get();
        return view("admin.barang_masuk.index")->with(['pemasoks' => $pemasok, 'barangs' => $barang]);
    }

    public function getData()
    {
        $data = BarangMasuk::with(['barang', 'pemasok'])->latest('tanggal_masuk')->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangMasukRequest $request)
    {
        $barangMasuk = BarangMasuk::create([
            "barang_id" => $request->barang,
            "pemasok_id" => $request->pemasok,
            "quantity" => $request->quantity,
            "penerima" => $request->penerima,
            "tanggal_masuk" => $request->tanggal_masuk ?? now(),
            "keterangan" => $request->keterangan
        ]);

        if ($barangMasuk) {
            Barang::where("id_barang", $request->barang)->increment("quantity", $request->quantity);
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menambahkan barang masuk."
            ]);
        }
        return response()->json([
            "status" => 202,
            "message" => "Terjadi masalah saat menambahkan barang masuk."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BarangMasuk::with([
            'barang' => function ($query) {
                $query->select('id_barang', 'code_barang', 'nama_barang');
            },
            'pemasok'
        ])->where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BarangMasuk::find($id);
        return response()->json([
            "data" => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangMasukRequest $request, string $id)
    {
        $data = BarangMasuk::find($id);
        $barang = Barang::where('id_barang', $request->barang)->increment('quantity', $request->quantity);
        if ($barang) {
            $data->update([
                "barang_id" => $request->barang,
                "pemasok" => $request->pemasok,
                "quantity" => $request->quantity
            ]);
            return response()->json([
                "status" => 200,
                'message' => "Berhasil Mengupdata Data."
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barangM = BarangMasuk::findOrFail($id);
        $barangM->delete();

        return response()->json([
            "status" => 200,
            "message" => "Berhasil menghapus data."
        ]);
    }
}