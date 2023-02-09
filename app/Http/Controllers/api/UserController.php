<?php

namespace App\Http\Controllers\api;


use App\Models\user;
use App\Models\Pegawai;
use App\Models\Perusahaan;
use App\Helpers\ApiFormatter;
use Illuminate\Routing\Controller;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreuserRequest;
use App\Http\Requests\UpdateuserRequest;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;




class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();

        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }

    public function indexLogin() {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['pegawai'] = User::get();
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
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
     * @param  \App\Http\Requests\StoreuserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreuserRequest $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tlp' => 'required',
            'username' => 'required',
            'password' => 'required|confirmed',
            'hak_akses' => 'required'
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tlp' => $request->tlp,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'hak_akses' => $request->hak_akses,
            'id_perusahaan' => auth()->user()->id_perusahaan
        ]);
    
        $data = User::where('id_perusahaan', auth()->user()->id_perusahaan)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::where('id', '=', $id)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateuserRequest  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateuserRequest $request, $id)
    {
        $data->update($request->all());
    
        $data = User::where('id', '=', $user->id)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $data = $user->delete();
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    // public function Login(Request $request) {
    //     // dd($request->all()); die();
    //     $user = User::where('username', $request->username)->first();

    //     if($user){
    //        if(password_verify($request->password, $user->password)) {
    //             return response()->json([
    //                 'Code' => 200,
    //                 'Message' => 'Welcome '.$user->password,
    //                 'data' => $user
    //             ]);
    //         }
    //          return $this->error($user);
    //     }
    //      return $this->error('Username tidak ditemukan');
    // }

     public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }


    public function login(Request $request) {
        // dd($request->all());


        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('username', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'code' => 200,
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

        // $userLogin = User::where('username', $request->username)->first();

        // if($Login) {

        //     if(password_verify($request->password, $userLogin->password)) {
        //         return response()->json([
        //             'code' => 200,
        //             'message' => 'Selamat Datang '.$userLogin->nama,
        //             'User' => $userLogin
        //         ]);
        //     }

        //     return $this->error('Username atau Password Salah');
        // }

        // return $this->error('Username Tidak ditemukan');
        }



     public function error($message) {
         return response()->json([
             'Code' => 500,
             'Message' => $message
         ]);
      }

      public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

      public function profile() {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
      }

      public function profileUpdate(Request $request){
        if(Hash::check($request->password, auth()->user()->password) == true) {
           $data = User::where('id', auth()->user()->id)->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'tlp' => $request->tlp,
                'username' => $request->username,
            ]);
            if($data) {
                return ApiFormatter::createApi(200, 'success', $data);
            } else{
                return ApiFormatter::createApi(400,'Failed');
            }
        }

    }

    public function changePW(){
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
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