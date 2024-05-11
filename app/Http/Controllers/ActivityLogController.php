<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ActivityLog::with('user')->latest()->orderByDesc('time')->get();
        foreach ($data as $activity) {
            $carbonTime = Carbon::parse($activity->time);

            // Hitung perbedaan antara waktu sekarang dan waktu dari data
            $difference = $carbonTime->diffForHumans();

            // Ubah nilai kolom 'time' menjadi perbedaan waktu dalam format "beberapa waktu yang lalu"
            $activity->time = $difference;
        }
        return response()->json($data);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityLog $activityLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityLog $activityLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityLog $activityLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityLog $activityLog)
    {
        //
    }
}