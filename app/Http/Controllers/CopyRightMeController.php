<?php

namespace App\Http\Controllers;

use App\Models\CopyRightMe;
use Illuminate\Http\Request;

class CopyRightMeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $copyrighttome = CopyRightMe::latest()->first();
        return view('me')->with('data', $copyrighttome);
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
        CopyRightMe::create(['status' => '0']);
        return redirect('copyrighttome')->with('berhasil', 'Copy right berhasil di buat');
    }

    /**
     * Display the specified resource.
     */
    public function show(CopyRightMe $copyRightMe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CopyRightMe $copyRightMe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        CopyRightMe::where('id', $id)->update(['copyrighttome' => $request->status]);
        return redirect('copyrighttome');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CopyRightMe $copyRightMe)
    {
        //
    }
}