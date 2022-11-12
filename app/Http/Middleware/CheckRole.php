<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next , $userType)
    {
        dd($userType);
        if(auth()->user()->type == $userType){
            return $next($request);
        }
          
        return response()->json(['You do not have permission to access for this page.']);
        /* return response()->view('errors.check-permission'); */
        // $roles = ['1', '2', '3', '4'];
        // $roles = array_slice(func_get_args(), 2);

        // foreach($roles as $role) {
            // $user = Auth::user()->hak_akses;
            // if($user == $roles) {
            //     return $next($request);
            // }
        // }

        // if(auth()->user() && $roles == auth()->user()->hak_akses) {
        //     return $next($request);
        // }
        // $hak_akses = auth()->user()->hak_akses;
        // dd($roles);
        // $listRoles = explode('|', $roles);
        //     if (checkPermission($listRoles)) {
        //         return $next($request);
        //     }

        //     return redirect('/login')->with(['errors', 'gagal']);
        }
        //  dd($role);
        // dd($listRoles);juh
}
