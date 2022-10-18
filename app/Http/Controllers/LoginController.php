<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perusahaan;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Mail\NotifikasiRegisterPerusahaan;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
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
        ]);

        $perusahaan = new Perusahaan();

        if($request->logo){
            $request->validate([
                'logo' => 'image|mimes:jpg,png,jpeg,gif,svg',
            ]);

            $getMime = $request->file('logo')->getMimeType(); 
            $explodedMime = explode('/' ,$getMime);
            $mime = end($explodedMime);
            $name = Str::random(25) . '.' . $mime;
            $request->logo->move('assets/img', $name);

            $perusahaan->logo = ('/assets/img/' . $name);
        } else {
            $perusahaan->logo = $perusahaan->logo;
        }

        $perusahaan->nama = $request->nama;
        $perusahaan->alamat = $request->alamat;
        $perusahaan->email = $request->email;
        $perusahaan->npwp = $request->npwp;
        $perusahaan->pemilik = $request->pemilik;
        $perusahaan->tlp = $request->telepon;
        $perusahaan->bank = $request->bank;
        $perusahaan->no_rekening = $request->no_rekening;
        $perusahaan->slogan = $request->slogan;
        $perusahaan->level = 1;
        $perusahaan->save();
        
        $id = Perusahaan::latest()->take(1);
        return $id;

        $user = new User();
        $user->id_perusahaan = $id->id;
        $user->nama = $id->pemilik;
        $user->username = $id->nama;
        $user->password = bcrypt('12345');
        $user->tlp = $id->tlp;
        $user->hak_akses = 1;
        $user->save();

        $email = Perusahaan::latest();
         
        // return $user;
        \Mail::to($email->email)->send(new NotifikasiRegisterPerusahaan);

        return redirect()->route('regSuccess')->with(['success' => 'Registrasi Berhasil!']);

    }
}
