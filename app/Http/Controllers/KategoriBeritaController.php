<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriBeritaRequest;
use App\Http\Requests\UpdateKategoriBeritaRequest;
use App\Models\ActivityLog;
use App\Models\KategoriBerita;

class KategoriBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.berita.kategori");
    }

    public function getData()
    {
        $data = KategoriBerita::all();
        return response()->json([
            "status" => 200,
            "data" => $data
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
    public function store(StoreKategoriBeritaRequest $request)
    {
        $data = [
            'nama_kategori' => $request->name_kategori
        ];

        KategoriBerita::create($data);

        ActivityLog::createLog('add', 'menambahkan data kategori berita');
        return response()->json([
            "status" => 200,
            "message" => "Berhasil manambahkan kategori."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriBerita $kategoriBerita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = KategoriBerita::where("id_kategori", $id)->get(['nama_kategori', 'id_kategori']);
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriBeritaRequest $request, $id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        $kategori->nama_kategori = $request->name_kategori;
        $kategori->save();
        ActivityLog::create([
            'id_user' => auth()->user()->id_user,
            'activity' => 'update',
            'deskripsi' => 'mengupdate data kategori berita pada ' . date('Y-F-d H:i'),
            'time' => now()
        ]);
        return response()->json([
            'status' => 200,
            "message" => "Berhasil mengupdate data."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete = KategoriBerita::findOrFail($id);
        $delete->delete();
        ActivityLog::create([
            'id_user' => auth()->user()->id_user,
            'activity' => 'delete',
            'deskripsi' => 'menghapus data kategori berita pada ' . date('Y-F-d H:i'),
            'time' => now()
        ]);
        return response()->json([
            "status" => 200,
            'message' => "Berhasil menghapus data."
        ]);
    }
}