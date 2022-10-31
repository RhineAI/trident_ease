<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekHakAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $hak_akses)
    {   
        if(auth()->user() && $hak_akses == auth()->user()->hak_akses) {
            return $next($request);
        }

        return redirect()->route('dashboard');
    }
}
