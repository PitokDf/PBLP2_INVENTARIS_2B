<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.jabatan.index");
    }

    public function getAllData()
    {
        $data = Jabatan::latest()->get();
        return response()->json([
            "status" => 200,
            "message" => 'data berhasil diambil',
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
        $validator = Validator::make($request->all(), [
            "jabatan" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Jabatan::create([
            "jabatan" => $request->jabatan
        ]);

        ActivityLog::createLog('add', 'menambahkan data jabatan');
        return response()->json([
            "status" => 200,
            "message" => "Jabatan Berhasil Ditambahkan."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return response()->json([
            "status" => 200,
            "message" => "data berhasil diambil",
            "data" => $jabatan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            "jabatan" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Jabatan::where('id', $id)->update([
            "jabatan" => $request->jabatan
        ]);
        ActivityLog::createLog('update', 'mengupdate data jabatan');
        return response()->json([
            "status" => 200,
            "message" => "Jabatan Berhasil Diupdate."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Jabatan::destroy($id);
        ActivityLog::createLog('delete', 'menghapus data jabatan');
        return response()->json([
            "status" => 200,
            "message" => "Jabatan Berhasil Dihapus."
        ]);
    }
}