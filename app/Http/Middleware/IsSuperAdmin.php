<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CekSuperAdmin
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

        if(Auth::check() && Auth::user()->hak_akses == 1) {
            return $next($request);
        } else {
            return redirect()->route('login');
        }

        return redirect()->route('dashboard');
    }


        // return response()->json(["You Don't have permission to access this page"]);
    
}
