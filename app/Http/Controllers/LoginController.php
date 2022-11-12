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

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $user = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        
        if(Auth::attempt($user)){
            $request->session()->regenerate();
            if(auth()->user()->type == 'super-admin') {
                return redirect()->intended('/')->with('success', 'Login as Super Admin Success');
            } elseif(auth()->user()->type == 'owner') {
                return redirect()->intended('/')->with('success', 'Login as Owner Success');
            } elseif(auth()->user()->type == 'admin') {
                return redirect()->intended('/')->with('success', 'Login as Admin Success');
            } elseif(auth()->user()->type == 'cashier') {
                return redirect()->intended('/')->with('success', 'Login as Cashier Success');
            } else {
                return redirect()->route('login');
            }
        }

        throw ValidationException::withMessages([
            'username' => 'Your provide credentials does not match our records',
        ]);
    }

    public function logout(Request $request) {
        // return $request;
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout Berhasil');
   }


    // Register
    public function reg() {
        return view('auth.register');
    }

    public function regSuccess() {
        $data['perusahaan'] = Perusahaan::select('*')->orderBy('id', 'DESC')->first();
        $data['user'] = User::select('*')->orderBy('id', 'DESC')->first();
        // return $kontol;
        return view('auth.success')->with($data);
    }

    public function register(Request $request) {
        // dd($request);
        $validate = $request->validate([
            'email' => 'required|max:50|email:dns',
        ]);
        
        $perusahaan = new Perusahaan();

        if($request->logo){
            $request->validate([
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg',
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
        $perusahaan->grade = 1;
        $perusahaan->save();
        
        // $id = Perusahaan::latest()->first();
        // return $id;

        $user = new User();
        $user->id_perusahaan = $perusahaan->id;
        $user->nama = $perusahaan->pemilik;
        $user->username = $perusahaan->nama;
        $user->password = bcrypt('12345');
        $user->tlp = $perusahaan->tlp;
        $user->hak_akses = 1;
        $user->save();

        $data['perusahaan'] = $perusahaan;
        $data['user'] = $user;

        \Mail::to($perusahaan->email)->send(new NotifikasiRegisterPerusahaan);
         
        // return $user;

        return redirect()->route('regSuccess')->with(['success' => 'Registrasi Berhasil!']);

    }
}
