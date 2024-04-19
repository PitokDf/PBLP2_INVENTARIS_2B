<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommandHelper extends Controller
{
    public function index()
    {
        return view('pages.command-helper');
    }

    public function execCommand(Request $request)
    {
        $artisanPath = "../artisan";
        $exec = shell_exec("php " . $artisanPath . " " . $request->command);

        return view('pages.command-helper')->with('response', $exec);
    }
}