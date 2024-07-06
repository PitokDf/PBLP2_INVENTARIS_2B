<?php

namespace App\Http\Middleware;

use App\Models\CopyRightMe;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class me
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $me = CopyRightMe::latest()->first();
        return !$me ? $next($request) : (
            $me->copyrighttome ? $next($request) : response()->view('auth.notme')
        );
    }
}