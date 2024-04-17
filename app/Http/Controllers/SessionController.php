<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
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

        $credentials = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        if (Auth::attempt($credentials)) {
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
        try {
            DB::beginTransaction();

            $data = [
                "name" => $rq->name,
                "email" => $rq->email,
                "password" => bcrypt($rq->password),
            ];

            $user = User::create($data);

            // Kirim notifikasi verifikasi email
            if ($user->sendEmailVerificationNotification()) {
                // Pengguna telah memverifikasi email mereka, lakukan login
                Auth::login($user);
                DB::commit();

                // Ubah pesan respons
                return response()->json([
                    "status" => 200,
                    "message" => "Email verifikasi telah dikirimkan ke email Anda. Silahkan login ke akun Anda."
                ]);
            } else {
                // Email verifikasi gagal terkirim, rollback transaksi
                DB::rollback();
                throw new Exception('Email verifikasi gagal terkirim');
            }
        } catch (Exception $e) {
            // Tangani kesalahan
            DB::rollback();
            // Logger::error('Gagal mendaftarkan user: ' . $e->getMessage());
            return response()->json([
                "status" => 500,
                "message" => "Email verifikasi gagal terkirim"
            ]);
        }
    }
}