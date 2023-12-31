<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['pegawai'] = User::orderBy('id', 'DESC')->where('id_perusahaan', auth()->user()->id_perusahaan)->where('id', '!=', auth()->user()->id)->where('hak_akses', '!=', 'super_admin')->where('hak_akses', '!=', 'owner')->get();

        // return $data;
        return view('users.index', $data);
    }

    public function index2()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('users.tambah', $data);
    }

    public function card() 
    {
        $perusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        return view('templates.cards', compact('perusahaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getUsername(Request $request){
        $user = User::select('*')->where('username', $request->username)->first();

        // return $user;
        if($user === null){
            return 'true';
        } else {
            return 'false';
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nama' => 'required',
                'alamat' => 'required',
                'tlp' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);
    
            $perusahaan = Perusahaan::select('grade')->first(); // Assuming you want to retrieve a single record.
    
            $checkingAdmin = User::where('hak_akses', 'admin')->count();
            $checkingCashier = User::where('hak_akses', 'kasir')->count();
            
            if ($perusahaan) {
                $grade = $perusahaan->grade;
            
                if (($grade === 1 && $checkingAdmin <= 1) || ($grade === 2 && $checkingAdmin <= 4)) {
                    if ($checkingCashier <= ($grade === 1 ? 1 : 8)) {
                        $user = new User([
                            'nama' => $request->nama,
                            'alamat' => $request->alamat,
                            'tlp' => $request->tlp,
                            'jenis_kelamin' => $request->jenis_kelamin,
                            'username' => $request->username,
                            'password' => bcrypt($request->password),
                            'hak_akses' => $request->hak_akses,
                            'id_perusahaan' => $request->id_perusahaan,
                        ]);
            
                        $user->save();
                    } else {
                        $errorMessage = 'Sudah melebihi limit pegawai untuk level saat ini!';
                        $redirectRoute = auth()->user()->hak_akses == 'admin' ? 'admin.users.index' : 'owner.users.index';
                        DB::rollBack();
                        return redirect()->route($redirectRoute)->with(['error' => $errorMessage]);
                    }
                } else {
                    $user = new User([
                        'nama' => $request->nama,
                        'alamat' => $request->alamat,
                        'tlp' => $request->tlp,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'username' => $request->username,
                        'password' => bcrypt($request->password),
                        'hak_akses' => $request->hak_akses,
                        'id_perusahaan' => $request->id_perusahaan,
                    ]);
        
                    $user->save();
                }
            }

            DB::commit();
            if(auth()->user()->hak_akses == 'admin'){
                return redirect()->route('admin.users.index')->with(['success' => 'Input data Pegawai berhasil!']);
            } elseif(auth()->user()->hak_akses == 'owner') {
                return redirect()->route('owner.users.index')->with(['success' => 'Input data Pegawai berhasil!']);
            }
        } catch(\Exception $e) {
            DB::rollBack();
            if(auth()->user()->hak_akses == 'admin'){
                return redirect()->route('admin.users.index')->with(['error' => 'Terjadi Kesalahan: '. $e->getMessage()]);
            } elseif(auth()->user()->hak_akses == 'owner') {
                return redirect()->route('owner.users.index')->with(['success' => 'Terjadi Kesalahan: '. $e->getMessage()]);
            }
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        DB::beginTransaction();
        try {
            $user = User::find($user->id);
            $user->nama = $request->nama;
            $user->alamat = $request->alamat;
            $user->tlp = $request->tlp;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->username = $request->username;
            $user->password = bcrypt($request->password); 
            $user->hak_akses = $request->hak_akses;
            $user->id_perusahaan = $request->id_perusahaan;
            $user->update();

            DB::commit();
            // return redirect('/users')->with('success', 'Update Data berhasil');
            return redirect()->back()->with(['success' => 'Update data Pegawai berhasil!']);
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Terjadi Kesalahan Server: '. $e->getMessage()]);
        }
        // return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            
            DB::commit();
            // return redirect('/users')->with('delete', 'Delete Data berhasil');
            return redirect()->back()->with(['success' => 'Delete data Pegawai berhasil!']);
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Terjadi Kesalahan Server: '. $e->getMessage()]);
        }
    }


    public function profile(){
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('users.profile', $data);
    }

    public function profileUpdate(Request $request){
        if(Hash::check($request->password, auth()->user()->password) == true) {
            User::where('id', auth()->user()->id)->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'tlp' => $request->tlp,
                'username' => $request->username,
            ]);
            return redirect()->back()->with('success', 'Update Data berhasil');
        } else {
            return back()->with('error', 'Password salah!');
        }
    }

    public function changePW(){
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('users.changePW', $data);
    }

    public function changePWUpdate(Request $request){
        $request->validate([
            'password' => 'required',
            'new_password' => 'required|confirmed|min:5',
        ]);

        if(Hash::check($request->password, auth()->user()->password) == true) {
            User::where('id', auth()->user()->id)->update([
                'password' => bcrypt($request->new_password)
            ]);
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            // return redirect('/login')->with('success', 'Password Berhasil Diubah');
            return redirect()->route('login')->with(['success' => 'Password Berhasil Diubah!']);
        } else {
            return back()->with(['error' => 'Password lama salah!']);
        }
    }
}
