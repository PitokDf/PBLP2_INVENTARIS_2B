<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("barang.index");
    }

    public function getData()
    {
        $data = Barang::with('kategori')->get();
        // foreach ($data as $item) {
        //     echo $item->kategori->nama_kategori_barang;
        // }
        // dd($data);
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
    public function store(StoreBarangRequest $request)
    {
        $data = [];

        if ($request->hasFile("foto")) {
            $file = $request->file("foto");
            $filename = time() . "_" . uniqid() . "." . $file->getClientOriginalName();
            if ($file->storeAs("public/barang", $filename)) {
                $data = [
                    "code_barang" => $request->kode_barang,
                    "nama_barang" => $request->nama_barang,
                    "quantity" => $request->jumlah,
                    "id_kategory" => $request->kategori,
                    "posisi" => $request->posisi,
                    "photo" => $filename
                ];
            } else {
                return response()->json([
                    "status" => 408,
                    "message" => "Terjadi masalah saat menyimpan gambar."
                ]);
            }
        }

        Barang::create($data);
        return response()->json([
            "status" => 200,
            "message" => "Berhasil menambahkan data."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barang = Barang::select([
            "id_barang",
            "code_barang",
            "nama_barang",
            "quantity",
            "id_kategory",
            "posisi",
            "photo"
        ])->where('id_barang', $id)->get();

        return response()->json([
            "status" => 200,
            "message" => "Berhasil mendapatkan data",
            "data" => $barang
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, $id)
    {
        $data = [];
        $barang = Barang::findOrFail($id);

        if ($request->hasFile("foto")) {
            if ($barang->photo != "") {
                Storage::delete('public/barang/' . $barang->photo);
            }
            $file = $request->file("foto");
            $filename = time() . "_" . uniqid() . "." . $file->getClientOriginalName();
            if ($file->storeAs("public/barang/", $filename)) {
                $data = [
                    "code_barang" => $request->kode_barang,
                    "nama_barang" => $request->nama_barang,
                    "quantity" => $request->jumlah,
                    "id_kategory" => $request->kategori,
                    "posisi" => $request->posisi,
                    "photo" => $filename
                ];
            }
        } else {
            $data = [
                "code_barang" => $request->kode_barang,
                "nama_barang" => $request->nama_barang,
                "quantity" => $request->jumlah,
                "id_kategory" => $request->kategori,
                "posisi" => $request->posisi,
            ];
        }

        $barang->update($data);
        return response()->json([
            "status" => 200,
            "message" => "Berhasil mengupdate data.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->photo != "") {
            Storage::delete("public/barang/" . $barang->photo);
        }

        $barang->delete();

        return response()->json([
            "status" => 200,
            "message" => "Berhasil menghapus data."
        ]);
    }
}