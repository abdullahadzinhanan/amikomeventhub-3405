<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Hanya izinkan user dengan role 'admin' yang bisa lewat.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Bukan admin → tendang kembali ke login
            return redirect()->route('admin.login')
                             ->with('error', 'Akses ditolak. Silakan login sebagai Admin.');
        }

        return $next($request);
    }
}