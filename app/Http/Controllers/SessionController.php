<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {

        if (User::where('email', $request->email)->where('logged', true)->exists()) {
            return redirect('login')->with('logged', 'Login gagal, anda sudah login diperangkat lain!')->withInput();
        }

        $credentials = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        if (Auth::attempt($credentials)) {
            User::where('email', $request->email)->update(['logged' => true]);
            if (Auth::user()->role == 3 || Auth::user()->role == 4 || Auth::user()->role == 5) {
                return redirect('umum');
            } elseif (Auth::user()->role == 1 || Auth::user()->role == 2) {
                return redirect('/');
            }
        } else {
            return redirect('login')->with('gagal', 'Login gagal, email atau password salah')->withInput();
        }
    }

    public function logout()
    {
        User::where('email', auth()->user()->email)->update(['logged' => false]);
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

        $validator = Validator::make($rq->all(), [
            'email' => "unique:users,email"
        ], [
            "email.unique" => "Email sudah tersedia.",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = [
            "name" => $rq->name,
            "email" => $rq->email,
            "password" => bcrypt($rq->password),
        ];

        $user = User::create($data);

        // Kirim notifikasi verifikasi email
        $user->sendEmailVerificationNotification();
        // Pengguna telah memverifikasi email mereka, lakukan login
        Auth::login($user);

        // Ubah pesan respons
        return response()->json([
            "status" => 200,
            "message" => "Email verifikasi telah dikirimkan ke email Anda. Silahkan login ke akun Anda."
        ]);
    }
}