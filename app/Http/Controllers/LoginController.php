<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\Models\Perusahaan;
use App\Models\User;

use App\Mail\NotifikasiRegisterPerusahaan;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){
        $user = $request->validate([
            'password' => ['required'],
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


    // Register
    public function reg() {
        return view('auth.register');
    }

    public function regSuccess() {
        return view('auth.success');
    }

    public function register(Request $request) {
        $validate = $request->validate([
            'email' => 'required|max:50|email:dns',
            'logo' => 'required|max:5040'
        ]);

        if ($request->file('logo')) {
            $validate['logo'] = $request->file('logo')->store('logo');
        }

        $logo = $validate['logo'];

        $perusahaan = new Perusahaan();
        $perusahaan->nama = $request->nama;
        $perusahaan->alamat = $request->alamat;
        $perusahaan->email = $request->email;
        $perusahaan->npwp = $request->npwp;
        $perusahaan->pemilik = $request->pemilik;
        $perusahaan->tlp = $request->telepon;
        $perusahaan->bank = $request->bank;
        $perusahaan->no_rekening = $request->no_rekening;
        $perusahaan->slogan = $request->slogan;
        $perusahaan->logo = $logo;
        $perusahaan->level = 1;
        $perusahaan->save();
        
        $id = Perusahaan::latest()->first();

        $user = new User();
        $user->id_perusahaan = $id->id;
        $user->nama = $id->pemilik;
        $user->username = $id->nama;
        $user->password = bcrypt($id->nama . '123');
        $user->tlp = $id->tlp;
        $user->hak_akses = 'admin';
        $user->save();
        
        
        // return $user;
        \Mail::to($id->email)->send(new NotifikasiRegisterPerusahaan);

        return redirect()->route('regSuccess')->with(['success' => 'Registrasi Berhasil!']);

    }
}
