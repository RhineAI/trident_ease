<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index(){
        return view('login.login');
    }

    public function login(Request $request){
        $user = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        
        if(Auth::attempt($user)){
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Login Success');
        }

        throw ValidationException::withMessages([
            'username' => 'Your provide credentials does not match our records',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout Berhasil');
   }
}
