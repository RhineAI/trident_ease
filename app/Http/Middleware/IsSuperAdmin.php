<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSuperAdmin
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
        if (!auth()->check() || !auth()->user()->hak_akses == 'super_admin' 
        && auth()->user()->hak_akses != 'admin' && auth()->user()->hak_akses != 'owner'
        && auth()->user()->hak_akses != 'kasir') {
            return redirect('404');
        }
        return $next($request);
    }
}
