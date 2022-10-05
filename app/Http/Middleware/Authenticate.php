<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if (!Auth::guard('admin')->check() || !Auth::guard('pelanggan')->check()) {
                session()->flash('info', 'Silahkan login terlebih dahulu !');
                return route('login.member');
            } else {
                if (Auth::guard('admin')->user()->role == 'admin') {
                    return $this->redirectTo = route('login');
                } elseif (Auth::guard('admin')->user()->role == 'pelanggan') {
                    return $this->redirectTo = route('login.member');
                }
            }
        }
    }
}
