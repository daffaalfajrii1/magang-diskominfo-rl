<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // pastikan login & role admin
        if (!$request->user() || $request->user()->role !== 'admin') {
            // kalau belum login, arahkan ke form login admin
            if (!$request->user()) {
                return redirect()->route('admin.login')->withErrors('Silakan login sebagai admin.');
            }
            // kalau login tapi bukan admin, tolak
            abort(403, 'Akses khusus admin.');
        }
        return $next($request);
    }
}
