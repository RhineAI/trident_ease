<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(auth()->user()->hak_akses == 'admin'){
                    return redirect()->route('admin.dashboard');
                } elseif(auth()->user()->hak_akses == 'kasir'){
                    return redirect()->route('kasir.dashboard');
                } elseif(auth()->user()->hak_akses == 'owner'){
                    return redirect()->route('owner.dashboard');
                } elseif(auth()->user()->hak_akses == 'super_admin'){
                    return redirect()->route('super_admin.dashboardSuperAdmin');
                }
            }
        }

        return $next($request);
    }
}
