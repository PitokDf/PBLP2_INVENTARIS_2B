<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDosenRequest;
use App\Http\Requests\UpdateDosenRequest;
use App\Models\ActivityLog;
use App\Models\Dosen;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jabatan = Jabatan::all();
        return view("dosen.index")->with('jabatans', $jabatan);
    }

    public function getDosenNip()
    {
        $dosen = Dosen::whereDoesntHave('user')->get();
        return response()->json([
            'status' => 200,
            'data' => $dosen
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getData()
    {
        $data = Dosen::with('jabatan')->latest()->get();
        return response()->json([
            "status" => 200,
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDosenRequest $request)
    {
        $filename = "";
        if ($request->hasFile('dir_foto')) {
            $file = $request->file('dir_foto');
            // Lakukan operasi yang diperlukan, seperti menyimpan file
            $filename = time() . "_" . uniqid() . "." . $file->getClientOriginalExtension();
            $file->storeAs('public/dosen', $filename); // Simpan file dengan nama tertentu
        }


        $data = [
            "name" => $request->name,
            "nip" => $request->nip,
            "jabatan_id" => $request->jabatan,
            "phone_number" => $request->no_telpn,
            "email" => $request->email,
            "photo_dir" => $filename
        ];

        Dosen::create($data);
        ActivityLog::create([
            'id_user' => auth()->user()->id_user,
            'activity' => 'add',
            'deskripsi' => 'menambahkan data dosen pada ' . date('Y-F-d H:i'),
            'time' => now()
        ]);
        return response()->json([
            "status" => 200,
            "message" => "Berhasil manambahkan data dosen."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Dosen::with("jabatan")->where("id_dosen", $id)->first();
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDosenRequest $request, $id)
    {
        try {
            $dosen = Dosen::findOrFail($id);

            $rules = [
                'email' => 'required|email|' . Rule::unique('dosen')->ignore($dosen),
                // "no_telpn" => Rule::unique('dosen')->ignore($dosen),
                "nip" => Rule::unique('dosen')->ignore($dosen)
            ];

            if ($request->hasFile('dir_foto')) {
                if ($dosen->photo_dir) {
                    Storage::delete('public/dosen/' . $dosen->photo_dir);
                }
                $rules["dir_foto"] = [
                    'image',
                    'mimes:jpeg,png,jpg',
                    'max:2048'
                ];


                $file = $request->file('dir_foto');
                // Lakukan operasi yang diperlukan, seperti menyimpan file
                $filename = time() . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                $file->storeAs('public/dosen', $filename); // Simpan file dengan nama tertentu
                $dosen->photo_dir = $filename;
            }

            $validator = Validator::make($request->all(), $rules, [
                "email.unique" => "Email sudah pernah digunakan",
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $dosen->name = $request->name;
            $dosen->nip = $request->nip;
            $dosen->jabatan_id = $request->jabatan;
            $dosen->phone_number = $request->no_telpn;
            $dosen->email = $request->email;

            $dosen->save();

            $log = new ActivityLog();
            $log->createLog('update', 'Mengupdate data dosen');

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
        $dosen = Dosen::findOrFail($id);

        if ($dosen->photo_dir) {
            Storage::delete('public/dosen/' . $dosen->photo_dir);
        }
        $dosen->delete();
        ActivityLog::create([
            'id_user' => auth()->user()->id_user,
            'activity' => 'delete',
            'deskripsi' => 'menghapus data dosen pada ' . date('Y-F-d H:i'),
            'time' => now()
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Menghapus data dosen.'
        ]);
    }
}