<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("berita.index");
    }

    public function getData()
    {
        $data = Berita::with('kategori')->get();
        return response()->json([
            "status" => 200,
            "message" => "Berhasil mendapatkan data.",
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
    public function store(Request $request)
    {
        $validate = $request->validate([
            "title" => "required",
            "content" => "required",
            "kategori" => "required|exists:kategori_berita,id_kategori",
            "publikasi" => "required|date",
        ]);

        Berita::create([
            'title' => $request->title,
            'content' => $request->content,
            'tgl_publikasi' => $request->publikasi,
            'id_kategori' => $request->kategori
        ]);
        ActivityLog::create([
            'id_user' => auth()->user()->id_user,
            'activity' => 'add',
            'deskripsi' => 'menambahkan data berita pada ' . date('Y-F-d H:i'),
            'time' => now()
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Ditambahkan!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $berita = Berita::findOrFail($id);
        if ($berita) {
            return response()->json([
                'status' => 200,
                'message' => 'data ditemukan',
                'data' => $berita
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'data tidak dapat ditemukan'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "title" => "required",
            "content" => "required",
            "kategori" => "required|exists:kategori_berita,id_kategori",
            "publikasi" => "required|date",
        ]);

        Berita::findOrFail($id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'tgl_publikasi' => $request->publikasi,
            'id_kategori' => $request->kategori,
        ]);
        ActivityLog::create([
            'id_user' => auth()->user()->id_user,
            'activity' => 'update',
            'deskripsi' => 'mengupdate data berita pada ' . date('Y-F-d H:i'),
            'time' => now()
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Berita Berhasil diupdate!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();
        ActivityLog::create([
            'id_user' => auth()->user()->id_user,
            'activity' => 'delete',
            'deskripsi' => 'menghapus data berita pada ' . date('Y-F-d H:i'),
            'time' => now()
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Dihapus'
        ]);
    }
}