<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangMasukRequest;
use App\Http\Requests\UpdateBarangMasukRequest;
use App\Models\Barang;
use App\Models\BarangMasuk;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BarangMasuk::latest()->get();
        $barang = Barang::all();
        return view("barang_masuk.index")->with(['barangM' => $data, 'barangs' => $barang]);
    }

    public function getData()
    {
        $data = BarangMasuk::with('barang')->latest()->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangMasukRequest $request)
    {
        return response()->json([
            "status" => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangMasuk $barangMasuk)
    {
        //
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