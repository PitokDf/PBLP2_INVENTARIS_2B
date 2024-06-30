<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReportController extends Controller
{
    public function index()
    {
        return view('admin.adminreport');
    }
    

    
   

    public function destroy(string $id)
    {
       
       
    }
}