<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\Perusahaan;
use App\Helpers\ApiFormatter;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePerusahaanRequest;
use App\Http\Requests\UpdatePerusahaanRequest;



class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data = Perusahaan::all();

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
     * @param  \App\Http\Requests\StorePerusahaanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerusahaanRequest $request)
    {
           $validasi = Validator::make($request->all(), [
                'nama' =>'required',
                'alamat' => 'required',
                'tlp' => 'required|min:11',
                'pemilik' => 'required',
                'bank' => 'required',
                'no_rekening' => 'required|min:10',
                'npwp' => 'required',
                'slogan' => 'required',
                'email' => 'required',
            ]);


        $perusahaan = Perusahaan::create([
            'nama' =>$request->nama,
            'alamat' => $request->alamat,
            'tlp' =>$request->tlp,
            'pemilik' => $request->pemilik,
            'bank' => $request->bank,
            'no_rekening' => $request->no_rekening,
            'npwp' =>$request->npwp,
            'slogan' => $request->slogan,
            'email' =>$request->email,
            'logo' => $request->logo,
            'grade' => $request->grade,
        ]);

        $User = User::create([
            'nama' =>$perusahaan->nama,
            'alamat' => $perusahaan->alamat,
            'tlp' =>  $perusahaan->tlp,
            'jenis_kelamin' => 'Other',
            'id_perusahaan' => $perusahaan->id,
            'username' => str_replace(' ', '', $perusahaan->nama),
            'password' => bcrypt(str_replace(' ', '', strtolower($perusahaan->pemilik).'123')),
            'hak_akses' => "owner"
        ]);
    
        $data = User::where('id_perusahaan', '=', $perusahaan->id)->get();

        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    
        }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Perusahaan::where('id', '=', $id)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePerusahaanRequest  $request
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerusahaanRequest $request, $id)
    {
         try {
            $request->validate([
                'nama' =>'required',
                'alamat' => 'required',
                'tlp' => 'required',
                'pemilik' => 'required',
                'bank' => 'required',
                'no_rekening' => 'required',
                'npwp' => 'required',
                'slogan' => 'required',
                'email' => 'required',
                'logo' => 'required',
                'grade' => 'required'
            ]);

            $perusahaan = Perusahaan::findOrFail($id);

            $perusahaan->update([
                'nama' =>$request->nama,
                'alamat' => $request->alamat,
                'tlp' =>$request->tlp,
                'pemilik' => $request->pemilik,
                'bank' => $request->bank,
                'no_rekening' => $request->no_rekening,
                'npwp' =>$request->npwp,
                'slogan' => $request->slogan,
                'email' =>$request->email,
                'logo' => $request->logo,
                'grade' => $request->grade,
        ]);
    
        $data = Perusahaan::where('id', '=', $perusahaan->id)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    
           }catch (Exception $error) {
                 return ApiFormatter::createApi(400,'Failed');
           }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        $data = $perusahaan->delete();
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }

    public function error($message) {
        return response()->json([
            'Code' => 500,
            'Message' => $message
        ]);
     }

    
}
