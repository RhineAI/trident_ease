<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsCashier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd(Auth::user());
        // dd(Auth::check());
        // dd(Auth::user());

        if(Auth::check() && Auth::user()->hak_akses == 4) {
            return $next($request);
        } else {
            return redirect()->route('login');
        }



        // if (Auth::check() && $role == Auth::user()->hak_akses) {
        //     return $next($request);
        // }
        return redirect()->route('dashboard');

    }
}
