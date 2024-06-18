<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePemasokRequest;
use App\Http\Requests\UpdatePemasokRequest;
use App\Models\Pemasok;

class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pemasok.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getAllData()
    {
        $data = Pemasok::latest()->get();
        return response()->json([
            "status" => 200,
            "data" => $data,
            "type" => gettype($data)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePemasokRequest $request)
    {
        $data = [
            "nama" => $request->nama_pemasok,
            "alamat" => $request->alamat,
            "kode_pos" => $request->kode_pos,
            "kota" => $request->kota,
            "no_hp" => $request->no_hp
        ];

        if (!Pemasok::create($data)) {
            return response()->json([
                "status" => 400,
                "message" => "Something went wrong."
            ]);
        }

        return response()->json([
            "status" => 200,
            "message" => "Berhasil menambahkan data pemasok."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemasok $pemasok)
    {
        return response()->json([
            "status" => 200,
            "message" => "data berhasil diambil",
            "data" => $pemasok
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemasok $pemasok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePemasokRequest $request, Pemasok $pemasok)
    {
        $data = [
            "nama" => $request->nama_pemasok,
            "alamat" => $request->alamat,
            "kode_pos" => $request->kode_pos,
            "kota" => $request->kota,
            "no_hp" => $request->no_hp
        ];

        $pemasok->update($data);
        return response()->json([
            'status' => 200,
            'message' => 'Data pemasok berhasil di update.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemasok $pemasok)
    {
        $pemasok->delete();
        return response()->json([
            "status" => 200,
            "message" => "Data berhasil dihapus"
        ]);
    }
}