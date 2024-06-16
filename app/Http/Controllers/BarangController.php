<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\ActivityLog;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;
use App\Imports\BarangImport;
use App\Models\Merk;
use App\Models\Pemasok;
use Illuminate\Http\Request;



class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $merk = Merk::orderByRaw('merk')->get();
        $pemasok = Pemasok::orderByRaw('nama')->get();
        return view("barang.index")->with(['merk' => $merk, 'pemasoks' => $pemasok]);
    }

    public function getData()
    {
        $data = Barang::with(['kategori', 'merek', 'pemasok'])->latest()->get();
        return response()->json([
            "status" => 200,
            "message" => "Berhasil mendapatkan data.",
            "data" => $data
        ]);
    }

    public function getById(string $code)
    {
        $barang = Barang::with(['kategori', 'merek'])->where('code_barang', $code)->first();
        if (!$barang) {
            return response()->json([
                'status' => 404,
                'message' => 'code tidak terdaftar'
            ]);
        }

        return response()->json([
            "status" => 200,
            "message" => "Berhasil mendapatkan data.",
            "data" => $barang
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
                    "photo" => '/storage/barang/' . $filename,
                    "merk_id" => $request->merk,
                    "tanggal_masuk" => $request->tanggal_masuk,
                    "supplier_id" => $request->pemasok,
                    "deskripsi" => $request->deskripsi
                ];
            } else {
                return response()->json([
                    "status" => 408,
                    "message" => "Terjadi masalah saat menyimpan gambar."
                ]);
            }
        }

        Barang::create($data);
        ActivityLog::createLog('add', 'Menambahkan data barang');
        return response()->json([
            "status" => 200,
            "message" => "Berhasil menambahkan data."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(['status' => 200, 'data' => Barang::with(['merek', 'kategori'])->find($id)]);
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
            "photo",
            "merk_id",
            "supplier_id",
            "deskripsi",
            "tanggal_masuk"
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
                    "photo" => '/storage/barang/' . $filename
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
        ActivityLog::createLog('update', 'mengupdate data barang');
        return response()->json([
            "status" => 200,
            "message" => "Berhasil mengupdate data.",
        ]);
    }

    public function export()
    {
        return Excel::download(new BarangExport(), 'Barangs.csv');
    }

    public function import(Request $request)
    {
        Excel::import(new BarangImport, request()->file('file'));

        return response()->json([
            "status" => 200,
            "message" => "file berhasil diimport"
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
        ActivityLog::create([
            'id_user' => auth()->user()->id_user,
            'activity' => 'delete',
            'deskripsi' => 'menghapus data barang pada ' . date('Y-F-d H:i'),
            'time' => now()
        ]);

        return response()->json([
            "status" => 200,
            "message" => "Berhasil menghapus data."
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!empty($ids)) {
            Barang::whereIn('id_barang', $ids)->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menghapus data terpilih.'
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => 'Tidak ada item yang dipilih.'
        ]);
    }
}