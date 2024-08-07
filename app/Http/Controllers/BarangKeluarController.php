<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangKeluarRequest;
use App\Http\Requests\UpdateBarangKeluarRequest;
use App\Models\ActivityLog;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\User;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::latest()->where('quantity', '>', 0)->get();
        $user = User::with(['mahasiswa', 'dosen'])
            ->whereNotNull('email_verified_at') // Email sudah terverifikasi
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->whereIn('role', ['3', '5'])
                        ->whereNotNull('dosen_id'); // Role 3 dan 5 dengan dosen_id tidak kosong
                });
            })
            ->orWhere(function ($query) {
                $query->where(function ($query) {
                    $query->whereIn('role', ['4'])
                        ->whereNotNull('mahasiswa_id');
                });
            })
            ->whereNotIn('role', ['1', '2'])
            ->latest()
            ->get();
        return view("admin.barang_keluar.index")->with(['barangs' => $barang, 'users' => $user]);


    }

    public function getAllData()
    {
        $data = BarangKeluar::with(['barang', 'user'])->latest()->get();
        return response()->json([
            'data' => $data,
            'message' => "Data Berhasil didapatkan."
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangKeluarRequest $request)
    {
        $barang = Barang::find($request->barang);

        $data = [
            "barang_id" => $request->barang,
            "tgl_keluar" => $request->tgl_keluar,
            "quantity" => $request->quantity,
            "keterangan" => $request->keterangan,
            "user_id" => $request->user
        ];

        if ($request->quantity > $barang->quantity) {
            return response()->json([
                'status' => 400,
                'message' => "Quantiy tersedia kurang dari " . $request->quantity . "."
            ]);
        }
        if (BarangKeluar::create($data)) {
            $barang->update([
                'quantity' => $barang->quantity -= $request->quantity
            ]);
        }
        ActivityLog::createLog('add', 'menambahkan data barang keluar');
        return response()->json([
            "status" => 200,
            "message" => "Barang keluar berhasil dicatat."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barangKeluar = BarangKeluar::with(['barang', 'user', 'user.mahasiswa', 'user.dosen'])->findOrFail($id);
        if (!$barangKeluar) {
            return response()->json([
                "status" => 404,
                "message" => "Data tidak tersedia."
            ]);
        }
        return response()->json([
            "status" => 200,
            "data" => $barangKeluar,
            "message" => "Berhasil mendapatkan data."
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangKeluar $barangKeluar)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangKeluarRequest $request, BarangKeluar $barangKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangKeluar $barangKeluar)
    {
        if ($barangKeluar->delete()) {
            ActivityLog::createLog('delete', 'menghapus data barang keluar');
            return response()->json([
                'status' => 200,
                'message' => 'Record barang keluar berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Something went wrong.'
            ]);
        }
    }
}