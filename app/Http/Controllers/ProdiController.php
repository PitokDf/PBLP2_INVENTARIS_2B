<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("prodi.index");
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
        $validator = Validator::make($request->all(), [
            'kode' => 'required',
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Prodi::create([
            'code_prodi' => $request->kode,
            'nama_prodi' => $request->nama
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Menambahkan Prodi.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function getData()
    {
        $prodi = Prodi::latest()->get();
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil diambil',
            'data' => $prodi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prodi = Prodi::findOrFail($id)->get([
            'id',
            'code_prodi',
            'nama_prodi'
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Mendapatkan data',
            'data' => $prodi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required',
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Prodi::findOrFail($id)->update([
            'code_prodi' => $request->kode,
            'nama_prodi' => $request->nama
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Mengupdate Prodi.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Prodi::findOrFail($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Prodi Berhasil dihapus!'
        ]);
    }
}