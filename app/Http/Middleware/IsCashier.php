<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        if (!auth()->check() || !auth()->user()->hak_akses == 'kasir' 
        && auth()->user()->hak_akses != 'admin' && auth()->user()->hak_akses != 'owner'
        && auth()->user()->hak_akses != 'super_admin') {
            return redirect('404');
        }
        return $next($request);
    }
}
