<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMahasiswasRequest;
use App\Http\Requests\UpdateMahasiswasRequest;
use App\Models\ActivityLog;
use App\Models\Mahasiswas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        ActivityLog::create([
            'id_user' => auth()->user()->id_user,
            'activity' => 'add',
            'deskripsi' => 'menambahkan data mahasiswa pada ' . date('Y-F-d H:i'),
            'time' => now()
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
        try {
            $mahasiswa = Mahasiswas::findOrFail($id);

            $rules = [
                "nim" => "required|numeric|digits:10|" . Rule::unique('mahasiswa')->ignore($mahasiswa),
            ];

            $validator = Validator::make($request->all(), $rules, [
                "email.unique" => "Email sudah pernah digunakan",
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $mahasiswa->nama = $request->nama_mahasiswa;
            $mahasiswa->nim = $request->nim;
            $mahasiswa->program_studi = $request->prodi;
            $mahasiswa->angkatan = $request->angkatan;
            $mahasiswa->ipk = $request->ipk;

            $mahasiswa->save();
            ActivityLog::create([
                'id_user' => auth()->user()->id_user,
                'activity' => 'update',
                'deskripsi' => 'mengupdate data mahasiswa pada ' . date('Y-F-d H:i'),
                'time' => now()
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Berhasil mengupdate data."
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Mahasiswas::where("id_mahasiswa", $id)->delete();
        ActivityLog::create([
            'id_user' => auth()->user()->id_user,
            'activity' => 'delete',
            'deskripsi' => 'menghapus data mahasiswa pada ' . date('Y-F-d H:i'),
            'time' => now()
        ]);
        return response()->json([
            "status" => 200,
            "message" => "Berhasil menghapus data."
        ]);
    }
}