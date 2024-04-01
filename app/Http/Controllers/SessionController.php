<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    function index()
    {
        return view('pages.login');
    }

    function login(Request $request)
    {

        $credentials = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 3 || Auth::user()->role == 4 || Auth::user()->role == 5) {
                return redirect('berita');
            } elseif (Auth::user()->role == 1 || Auth::user()->role == 2) {
                return redirect('/');
            }
        } else {
            return redirect('login')->with('gagal', 'Login gagal, email atau password salah')->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('login');
    }

}