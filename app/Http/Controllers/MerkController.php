<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MerkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.merk.index');
    }

    public function getData()
    {
        $data = Merk::orderByRaw('merk')->get();
        return response()->json([
            'status' => 200,
            'data' => $data
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
        $request->validate([
            'merk' => 'required|unique:merks'
        ], ['merk.unique' => 'Merk sudah ada.']);

        Merk::create(['merk' => $request->merk]);
        return response()->json(['status' => 200, 'message' => 'Berhasil menambahkan merk.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $merk = Merk::where('id', $id)->first();
        if (!$merk) {
            return response()->json(['status' => 404, 'message' => 'Data not found']);
        }
        return response()->json(['status' => 200, 'data' => $merk]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $merk = Merk::where('id', $id)->first();

        $request->validate(['merk' => 'required|' . Rule::unique('merks')->ignore($merk)], ['merk.unique' => 'Merk sudah ada.']);
        $merk->update(['merk' => $request->merk]);
        return response()->json(['status' => 200, 'message' => 'Berhasil mengupdate merk.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $merk = Merk::where('id', $id)->first();
        if (!$merk) {
            return response()->json(['status' => 404, 'message' => 'Data not found.']);
        }
        $merk->delete();
        return response()->json(['status' => 200, 'message' => 'Berhasil menghapus merk.']);
    }
}