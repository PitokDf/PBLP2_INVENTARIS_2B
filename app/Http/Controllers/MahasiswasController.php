<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMahasiswasRequest;
use App\Http\Requests\UpdateMahasiswasRequest;
use App\Models\Mahasiswas;

class MahasiswasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("mahasiswa.index");
    }

    public function getData()
    {
        $data = Mahasiswas::all();

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
    public function store(StoreMahasiswasRequest $request)
    {
        Mahasiswas::create([
            "nama" => $request->nama_mahasiswa,
            "nim" => $request->nim,
            "program_studi" => $request->prodi,
            "angkatan" => $request->angkatan,
            "ipk" => $request->ipk
        ]);
        return response()->json([
            "status" => 200,
            "message" => "Berhasil menambahkan data Mahasiswa."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswas $mahasiswas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Mahasiswas::where("id_mahasiswa", $id)->get([
            "id_mahasiswa",
            "nama",
            "nim",
            "program_studi",
            "angkatan",
            "ipk"
        ]);

        return response()->json([
            "status" => 200,
            "message" => "Berhasil mendapatkan data.",
            "data" => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMahasiswasRequest $request, $id)
    {
        $mahasiswa = Mahasiswas::findOrFail($id);
        $data = [
            "nama" => $request->nama_mahasiswa,
            "nim" => $request->nim,
            "program_studi" => $request->prodi,
            "angkatan" => $request->angkatan,
            "ipk" => $request->ipk
        ];

        $mahasiswa->update($data);
        return response()->json([
            "status" => 200,
            "message" => "Berhasil mengupdate data."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Mahasiswas::where("id_mahasiswa", $id)->delete();
        return response()->json([
            "status" => 200,
            "message" => "Berhasil menghapus data."
        ]);
    }
}