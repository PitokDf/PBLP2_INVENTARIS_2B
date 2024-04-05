<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function login(Request $request)
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

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }

    public function forgotShow()
    {
        return view('pages.forgotpass');
    }

    public function register()
    {
        return view('pages.register');
    }

    public function prosesRegister(Request $rq)
    {
        $nama = $rq->firstname . " " . $rq->lastname;

        if (empty($rq->pass1) || empty($rq->pass2) || $rq->pass1 != $rq->pass2) {
            return redirect('register')->withErrors('error_pass', "Password tidak sesuai.")->withInput();
        } else {
            echo "berhasil";
        }

        $data = [
            "name" => $nama,
            "email" => $rq->email,
        ];
    }
}