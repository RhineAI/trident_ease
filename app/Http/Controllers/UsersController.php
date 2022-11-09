<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $data['pegawai'] = User::orderBy('id', 'DESC')->get();

        // return $data;
        return view('users.index', $data);
    }

    public function index2()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('users.tambah', $data);
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
    public function store(Request $request)
    {
        // dd($request); die;
        // return $request;
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tlp' => 'required',
            'username' => 'required',
            'password' => 'required',
            'hak_akses' => 'required'
        ]);

        // $user = User::create([
        //     'nama' => $request->nama,
        //     'alamat' => $request->alamat,
        //     'tlp' => $request->tlp,
        //     'username' => $request->username,
        //     'password' => bcrypt($request->password),
        //     'hak_akses' => $request->hak_akses,
        //     'id_perusahaan' => $request->id_perusahaan
        // ]);

        $user = new User();
        $user->nama = $request->nama;
        $user->alamat = $request->alamat;
        $user->tlp = $request->tlp;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->username = $request->username;
        $user->password = bcrypt($request->password); 
        $user->hak_akses = $request->hak_akses;
        $user->id_perusahaan = $request->id_perusahaan;
        // return $user;
        $user->save();


        // dd($user);
        
        // return redirect('/users')->with('success', 'Input data Pegawai berhasil!');
        return redirect()->route('users.index')->with(['success' => 'Input data Pegawai berhasil!']);
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
        $user->update($request->all());
        // return redirect('/users')->with('success', 'Update Data berhasil');
        return redirect()->route('users.index')->with(['success' => 'Update data Pegawai berhasil!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        // return redirect('/users')->with('delete', 'Delete Data berhasil');
        return redirect()->route('users.index')->with(['success' => 'Delete data Pegawai berhasil!']);
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
            return redirect('/profile')->with('success', 'Update Data berhasil');
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
            'new_password' => 'required|confirmed',
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
            return back()->with('error', 'Password lama salah!');
        }
    }
}
