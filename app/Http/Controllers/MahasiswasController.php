<?php

namespace App\Http\Controllers;

use App\Exports\MahasiswaExport;
use App\Http\Requests\StoreMahasiswasRequest;
use App\Http\Requests\UpdateMahasiswasRequest;
use App\Imports\MahasiswaImport;
use App\Models\ActivityLog;
use App\Models\Mahasiswas;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodi = Prodi::all();
        return view("mahasiswa.index")->with("prodi", $prodi);
    }

    public function getMahasiswaNim()
    {
        $mahasiswaNim = Mahasiswas::whereDoesntHave('user')->get();
        return response()->json([
            "status" => 200,
            "data" => $mahasiswaNim
        ]);
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
    public function export()
    {
        return Excel::download(new MahasiswaExport(), 'Mahasiswas.csv');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMahasiswasRequest $request)
    {
        Mahasiswas::create([
            "nama" => $request->nama_mahasiswa,
            "nim" => $request->nim,
            "code_prodi" => $request->prodi,
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
    public function import(Request $request)
    {
        Excel::import(new MahasiswaImport, request()->file('file'));

        return response()->json([
            "status" => 200,
            "message" => "file berhasil diimport"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Mahasiswas::with([
            'prodi' => function ($prodi) {
                $prodi->select('code_prodi', 'nama_prodi');
            }
        ])->where("id_mahasiswa", $id)->get();

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
            $mahasiswa->code_prodi = $request->prodi;
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