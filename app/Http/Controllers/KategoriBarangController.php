<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriBarangRequest;
use App\Http\Requests\UpdateKategoriBarangRequest;
use App\Models\ActivityLog;
use App\Models\KategoriBarang;

class KategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.barang.kategori");
    }

    public function getKategori()
    {
        $data = KategoriBarang::all();

        return response()->json(
            ["data" => $data]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //jj
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriBarangRequest $request)
    {
        $data = [
            "nama_kategori_barang" => $request->name_kategori
        ];
        KategoriBarang::create($data);
        ActivityLog::createLog('add', 'menambahkan data kategori barang');
        return response()->json([
            "status" => 200,
            "message" => "Berhasil Menambahkan kategorid."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriBarang $kategoriBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = KategoriBarang::where("id", $id)->get(["id", "nama_kategori_barang"]);
        return response()->json([
            "status" => 200,
            "message" => "berhasil mendapatkan data.",
            "data" => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriBarangRequest $request, $id)
    {
        $kategori = KategoriBarang::findOrFail($id);
        $kategori->nama_kategori_barang = $request->name_kategori;
        $kategori->save();
        ActivityLog::createLog('update', 'mengupdate data kategori barang');
        return response()->json([
            "status" => 200,
            "message" => "Berhasil mengupdate kategori."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = KategoriBarang::findOrFail($id);
        $kategori->delete();
        ActivityLog::createLog('delete', 'menghapus data kategori barang');
        return response()->json([
            "status" => 200,
            "message" => "Berhasil menghapus kategori."
        ]);
    }
}