<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiFormatter;
use App\Models\Pelanggan;
use Illuminate\Routing\Controller;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;

// use App\Helpers\ApiFormatter;
// use App\Models\Pelanggan;
// use App\Http\Requests\StorePelangganRequest;
// use App\Http\Requests\UpdatePelangganRequest;



class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pelanggan::all();

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
     * @param  \App\Http\Requests\StorePelangganRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePelangganRequest $request)
    {
        try {
            $request->validate([
                'nama' =>'required',
                'alamat' => 'required',
                'tlp' => 'required',
                'jenis_kelamin' => 'required',
                'id_perusahaan' => 'required'
            ]);
        $pelanggan = Pelanggan::create([
            'nama' =>$request->nama,
            'alamat' => $request->alamat,
            'tlp' =>$request->tlp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'id_perusahaan' => $request->id_perusahaan
        ]);
    
        $data = Pelanggan::where('id', '=', $pelanggan->id)->get();
    
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
     * Display the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pelanggan::where('id', '=', $id)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePelangganRequest  $request
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePelangganRequest $request, $id)
    {
            try {
                $request->validate([
                    'nama' =>'required',
                    'alamat' => 'required',
                    'tlp' => 'required',
                    'jenis_kelamin' => 'required',
                    'id_perusahaan' => 'required'
                ]);
                
                $pelanggan = Pelanggan::findOrFail($id);
                    
                $pelanggan->update([
                    'id' =>$request->id,
                    'nama' =>$request->nama,
                    'alamat' => $request->alamat,
                    'tlp' =>$request->tlp,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'id_perusahaan' => $request->id_perusahaan
                ]);
        
        $data = Pelanggan::where('id', '=', $pelanggan->id)->get();
    
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
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $data = $pelanggan->delete();
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }
}
