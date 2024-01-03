<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use App\Models\User;
use App\Models\Pelanggan;

use App\Models\Perusahaan;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\AuthRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Database\QueryException;
use App\Mail\NotifikasiRegisterPerusahaan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        try {
            // Memvalidasi inputan apakah sudah diisi apa belum
            $user = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);
            // Mengambil data User yang sedang login
            $getUser = User::where('username', $request->username)->first();
            // Mengambil data Perusahaan dari user yang sedang login
            $getPerusahaan = Perusahaan::where('id', $getUser->id_perusahaan)->first();
            // Pengecekan apakah validasi sudah lolos
            if(Auth::attempt($user)){
                // Pengecekan apakah masa waktu sewa sudah habis
                if($getPerusahaan->expiredDate === '0000-00-00'){
                    $request->session()->regenerate();
                    return redirect()->intended('/'.$getUser->hak_akses)->with('success', 'Anda telah login sebagai '.$getUser->hak_akses);
                } elseif($getPerusahaan->expiredDate !== '0000-00-00') {
                    $expiredDate = strtotime($getPerusahaan->expiredDate);
                    $oneDayBeforeExpired = strtotime('-1 day', $expiredDate);
                    $currentDate = strtotime(date('Y-m-d'));

                    if($currentDate >= $expiredDate){
                        $data['perusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        
                        Auth::logout();
        
                        $request->session()->invalidate();
        
                        $request->session()->regenerateToken();
                        return $this->contactUs($data['perusahaan']);
                    } else if($currentDate >= $oneDayBeforeExpired && $currentDate < $expiredDate){
                        // return 'tes';
                        $request->session()->regenerate();
                        return redirect()->intended('/'.$getUser->hak_akses)->with('warning', 'Masa sewa akan berakhir besok, Silahkan Hubungi Kami Untuk Memperpanjang Masa Sewa');
                    } else {
                        $request->session()->regenerate();
                        return redirect()->intended('/'.$getUser->hak_akses)->with('success', 'Anda telah login sebagai '.$getUser->hak_akses);
                    }
                }
            } else {
                return back()->with(['error' => 'Username atau Password tidak sesuai']);
            }
            // Jika tidak lolos validasi akan dikembalikan ke halaman login
            throw ValidationException::withMessages([
                'username' => 'Your provide credentials does not match our records',
            ]);
        } catch(\Exception | PDOException | QueryException){
            return back()->with(['error' => 'Username atau Password tidak sesuai']);
        }
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
        DB::beginTransaction();
        try {
            // Memvalidasi inputan apakah sudah diisi apa belum
            $validate = $request->validate([
                'email' => 'required|max:50|email:dns',
            ]);
            $check = Perusahaan::where('nama', $request->nama)->first();
            if(!empty($check)){
                return redirect()->back()->with(['error' => 'Nama Perusahaan Sudah Digunakan, Silahkan Tambahkan Karakter Unik']);
            }

            // Pembuatan Objek Baru : Perusahaan
            $perusahaan = new Perusahaan();
            // Jika ada inputan berupa img maka akan terlebih dahulu di cek dan img akan dimasukan kedalam aplikasi
            if($request->logo){
                $request->validate([
                    'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:4096',
                ]);

                $logoFile = $request->file('logo');

                // Create an instance of the Intervention Image class
                $convertion = Image::make($logoFile->getRealPath())->resize(750, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                // Generate a unique filename
                $logoFileName = uniqid() . '_' . time() . '.' . $logoFile->getClientOriginalExtension();

                // Save the image to the storage directory
                Storage::put('public/img/' . $logoFileName, (string)$convertion->encode());

                // Get the full path to the saved image
                $imagePath = 'public/img/' . $logoFileName;

                // Optionally, you can create a symbolic link to make the image accessible from the public directory
                // Note: Run php artisan storage:link if the symbolic link doesn't exist yet
                // This creates a symbolic link from public/storage to storage/app/public
                // Only needed once or whenever the storage structure changes
                $linkPath = storage_path('app/public/img/' . $logoFileName);

                // $logoFile = $request->file('logo');
                // $convertion = Image::make($logoFile->getRealPath())->resize(750, null, function ($constraint) {
                //                 $constraint->aspectRatio();
                // });

                // $logoFileName = $logoFile->hashName();
                // $oriPath = storage_patsh('app/public/img/'. $logoFileName);
                Image::make($convertion)->save($linkPath);

                $perusahaan->logo = $logoFileName;
            } else {
                $perusahaan->logo = $perusahaan->logo;
            }
            // Isi dari Objek Perusahaan
            $perusahaan->nama = $request->nama;
            $perusahaan->alamat = $request->alamat;
            $perusahaan->email = $request->email;
            $perusahaan->npwp = $request->npwp;
            $perusahaan->pemilik = $request->pemilik;
            $perusahaan->tlp = $request->telepon;
            // Pengecekan jika user memilih bank yang tidak ada dalam aplikasi
            if($request->bank == 'Other'){
                $perusahaan->bank = $request->other;
            } else {
                $perusahaan->bank = $request->bank;
            }
            $perusahaan->no_rekening = $request->no_rekening;
            $perusahaan->slogan = $request->slogan;
            $perusahaan->grade = 1;
            $perusahaan->startDate = date('Y-m-d');// Calculate the expiredDate by adding 7 days to the startDate
            $perusahaan->expiredDate = Carbon::parse($perusahaan->startDate)->addDays(30)->format('Y-m-d');

            // Menyimpan objek Perusahaan kedalam database
            $perusahaan->save();
            
            // Array dari beberapa string
            $replace = array(' ', '.', ',', 'PT', 'Pt', 'pt', 'pT', 'CV', 'Cv', 'cv', 'cV');
            // Pembuatan objek baru : User
            $user = new User();
            // Isi dari objek User
            $user->id_perusahaan = $perusahaan->id;
            $user->nama = $perusahaan->pemilik;
            $user->username = str_replace($replace, '', $perusahaan->nama);
            $user->password = bcrypt(str_replace(' ', '', strtolower($perusahaan->pemilik).'123'));
            $user->tlp = $perusahaan->tlp;
            $user->hak_akses = 'owner';
            // Menyimpan objek User kedalam database
            $user->save();

            // Pembuatan objek baru : Pelanggan
            $pelangganUmum = new Pelanggan();
            // Isi dari objek Pelanggan
            $pelangganUmum->nama = 'Pelanggan Umum';
            $pelangganUmum->alamat = '-';
            $pelangganUmum->jenis_kelamin = 'L';
            $pelangganUmum->id_perusahaan = $perusahaan->id;
            // Menyimpan objek Pelanggan kedalam database
            $pelangganUmum->save();

            // Membuat Link/Excerpt Random
            $data['perusahaan'] = $perusahaan;
            $data['user'] = $user;
            $random = Str::random(19);
            $random2 = Str::random(10);
            $randomToken = $random . 'TridentTech.Id?' . $perusahaan->nama . '?kN7l' . $random2;
            
            DB::commit();
            return redirect()->route('regSuccess', ['id' => $perusahaan->id, 'token' => $randomToken])->with(['success' => 'Registrasi Berhasil!']);
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Terjadi Kesalahan Server: '. $e->getMessage()]);
        }
    }
}
