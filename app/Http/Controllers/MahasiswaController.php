<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
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
        $data = Mahasiswa::all();

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
    public function store(StoreMahasiswaRequest $request)
    {
        $data = [
            "nama" => $request->nama_mahasiswa,
            "nim" => $request->nim,
            "program_studi" => $request->prodi,
            "angkatan" => $request->angkatan,
            "ipk" => $request->ipk
        ];

        Mahasiswa::create($data);
        return response()->json([
            "status" => 200,
            "message" => "Berhasil menambahkan data Mahasiswa."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Mahasiswa::where("id_mahasiswa", $id)->get([
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
    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        // $mahasiswa = Mahasiswa::findOrFail($mahasiswa->id);
        // $mahasiswa->nama = $request->nama_mahasiswa;

        return response()->json([
            "status" => 200,
            "message" => "Berhasil mengupdate data mahasiswa.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }
}