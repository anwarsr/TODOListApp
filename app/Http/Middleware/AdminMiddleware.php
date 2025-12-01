<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AdminMiddleware
 * 
 * Middleware untuk melindungi route admin
 * Memastikan hanya user dengan session 'is_admin' yang bisa mengakses
 * 
 * @package App\Http\Middleware
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user memiliki session admin
        if (!$request->session()->get('is_admin')) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
