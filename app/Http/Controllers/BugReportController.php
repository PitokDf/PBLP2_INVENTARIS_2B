<?php

namespace App\Http\Controllers;

use App\Mail\BugReportMail;
use App\Models\BugReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BugReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getAllData()
    {
        Carbon::setLocale('id');
        $bugReports = BugReport::latest()->get();
        $roles = ['Pimpinan', 'Dosen', 'Mahasiswa', 'Staff'];

        foreach ($bugReports as $bugReport) {
            $bugReport->role = $roles[(int) $bugReport->user->role - 2];
            $bugReport->tanggal_report = Carbon::parse($bugReport->created_at)->translatedFormat('l, j F Y');
        }

        return response()->json([
            'status' => 200,
            'data' => $bugReports
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|min:10',
            'captcha' => 'required|captcha'
        ], ['captcha.captcha' => 'captcha tidak sesuai']);

        $bugReport = BugReport::create([
            'pelapor' => auth()->user()->mahasiswa ? auth()->user()->mahasiswa->nama : auth()->user()->dosen->name,
            'email' => auth()->user()->email,
            'description' => $request->description
        ]);

        $adminEmail = User::where('role', 1)->pluck('email')->toArray();
        foreach ($adminEmail as $admin) {
            Mail::to($admin)->send(new BugReportMail($bugReport));
        }
        return response()->json(['status' => 200, 'message' => 'Berhasil melaporakan bug.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(BugReport $bugReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BugReport $bugReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        $bugReport = BugReport::where('id', $id)->first();
        if (!$bugReport) {
            return response()->json(['status' => 404, 'message' => 'Data not found.']);
        }

        $bugReport->update(['status' => 1]);
        return response()->json(['status' => 200, 'message' => 'Bug Resolved.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bugReport = BugReport::where('id', $id)->first();
        if (!$bugReport) {
            return response()->json(['status' => 404, 'message' => 'Data not found.']);
        }
        $bugReport->delete();
        return response()->json(['status' => 200, 'message' => 'Record berhasil dihapus.']);
    }
}