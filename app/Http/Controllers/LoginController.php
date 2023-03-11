<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perusahaan;
use App\Models\Pelanggan;
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

        $getUser = User::where('username', $request->username)->first();
        $getPerusahaan = Perusahaan::where('id', $getUser->id_perusahaan)->first();
        // return (strtotime($getPerusahaan->expiredDate) < strtotime(date('Y-m-d')));
        if(Auth::attempt($user)){
            if($getPerusahaan->expiredDate === '0000-00-00'){
                $request->session()->regenerate();
                return redirect()->intended('/'.$getUser->hak_akses)->with('success', 'Anda telah login sebagai '.$getUser->hak_akses);
            } elseif($getPerusahaan->expiredDate !== '0000-00-00') {
                if(strtotime($getPerusahaan->expiredDate) < strtotime(date('Y-m-d'))){
                    $data['perusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
    
                    Auth::logout();
    
                    $request->session()->invalidate();
    
                    $request->session()->regenerateToken();
                    return $this->contactUs($data['perusahaan']);
                } else {
                    $request->session()->regenerate();
                    return redirect()->intended('/'.$getUser->hak_akses)->with('success', 'Anda telah login sebagai '.$getUser->hak_akses);
                }
            }

            
            // if (Auth::user()->hak_akses == 'super_admin') {
            // } elseif(Auth::user()->hak_akses == 'admin') {
                // return redirect()->intended('/'.$getUser->hak_akses)->with('success', 'Login Success');
            // }
        } else {
            return back()->with(['error' => 'Username atau Password tidak sesuai']);
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

   public function contactUs($perusahaan){
    return view('auth.contactUs', compact('perusahaan'));
   }

    // Register
    public function reg() {
        return view('auth.register');
    }

    public function regSuccess() {
        $data['perusahaan'] = Perusahaan::select('*')->orderBy('id', 'DESC')->first();
        $data['user'] = User::select('*')->orderBy('id', 'DESC')->first();
        return view('auth.success')->with($data);
    }

    public function register(Request $request) {
        // $replace = array(' ', '.', ',', 'PT', 'Pt', 'pt', 'pT', 'CV', 'Cv', 'cv', 'cV');

        // $user= str_replace($replace, '', $request->nama);
        // return $user;
        $validate = $request->validate([
            'email' => 'required|max:50|email:dns',
        ]);
        
        $perusahaan = new Perusahaan();

        if($request->logo){
            $request->validate([
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:4096',
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
        if($request->bank == 'Other'){
            $perusahaan->bank = $request->other;
        } else {
            $perusahaan->bank = $request->bank;
        }
        $perusahaan->no_rekening = $request->no_rekening;
        $perusahaan->slogan = $request->slogan;
        $perusahaan->grade = 1;
        $perusahaan->startDate = date('Y-m-d');
        // $perusahaan->expiredDate = date('Y-m-d');
        $perusahaan->save();
        
        // $id = Perusahaan::latest()->first();
        // return $id;
        // $withoutspace = str_replace(' ', '', $perusahaan->nama);
        $replace = array(' ', '.', ',', 'PT', 'Pt', 'pt', 'pT', 'CV', 'Cv', 'cv', 'cV');
        $user = new User();
        $user->id_perusahaan = $perusahaan->id;
        $user->nama = $perusahaan->pemilik;
        $user->username = str_replace($replace, '', $perusahaan->nama);
        $user->password = bcrypt(str_replace(' ', '', strtolower($perusahaan->pemilik).'123'));
        $user->tlp = $perusahaan->tlp;
        $user->hak_akses = 'owner';
        $user->save();

        $pelangganUmum = new Pelanggan();
        $pelangganUmum->nama = 'Pelanggan Umum';
        $pelangganUmum->alamat = '-';
        $pelangganUmum->jenis_kelamin = 'L';
        $pelangganUmum->id_perusahaan = $perusahaan->id;
        $pelangganUmum->save();

        $data['perusahaan'] = $perusahaan;
        $data['user'] = $user;
        $random = Str::random(20);
        $random2 = Str::random(20);
        $randomToken = $random . 'ZiePOS?' . $perusahaan->nama . '?kN7l' . $random2;

        // \Mail::to($perusahaan->email)->send(new NotifikasiRegisterPerusahaan);
         
        // return $user;

        return redirect()->route('regSuccess', ['id' => $perusahaan->id, 'token' => $randomToken])->with(['success' => 'Registrasi Berhasil!']);

    }
}
