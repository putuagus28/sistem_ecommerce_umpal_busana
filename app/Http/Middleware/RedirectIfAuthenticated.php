<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('pelanggan')->check()) {
            if (Auth::guard('pelanggan')->user()->role == 'pelanggan') {
                session()->flash('info', '<strong>Oppss</strong>, Silahkan logout terlebih dahulu !');
                return redirect()->route('pelanggan.dashboard');
            }
        } elseif (Auth::guard('admin')->check()) {
            if (Auth::guard('admin')->user()->role == 'admin') {
                session()->flash('info', '<strong>Oppss</strong>, Silahkan logout terlebih dahulu !');
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
