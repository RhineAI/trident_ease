<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsOwner
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
        dd(Auth::check());

        dd($request);

        if(Auth::check() && Auth::user()->hak_akses == 2) {
            return $next($request);
        } else {
            return redirect()->route('login');
        }

        return redirect()->route('dashboard');
    }

        // if (Auth::check() && $role == Auth::user()->hak_akses ) {
        //     return $next($request);
        // }

    
}
