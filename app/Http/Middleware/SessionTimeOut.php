<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeOut
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && empty(Auth::user()->email_verified_at)) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Email tidak terverikasi.');
        }
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Sesi Anda berakhir, silahkan login kembali.'], 401);
            } else {
                return redirect()->route('login')->with('error', 'Sesi Anda berakhir, silahkan login kembali.');
            }
        }
        return $next($request);
    }
}