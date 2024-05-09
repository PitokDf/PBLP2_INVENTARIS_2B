<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

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

    public function forgotSend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Token reset password berhasil terkirim, silahkan periksa email anda!'])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPass(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil direset, silahkan login.')
            : back()->withErrors(['email' => [__($status)]])->onlyInput('password');
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