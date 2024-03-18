<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriBarangRequest;
use App\Http\Requests\UpdateKategoriBarangRequest;
use App\Models\KategoriBarang;

class KategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getKategori()
    {
        $data = KategoriBarang::all();

        return response()->json(
            ["data" => $data]
        );
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
    public function store(StoreKategoriBarangRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriBarang $kategoriBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriBarang $kategoriBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriBarangRequest $request, KategoriBarang $kategoriBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriBarang $kategoriBarang)
    {
        //
    }
}