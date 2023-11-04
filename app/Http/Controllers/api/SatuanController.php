<?php

namespace App\Http\Controllers\Api;
use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\Satuan;
use App\Http\Requests\StoreSatuanRequest;
use App\Http\Requests\UpdateSatuanRequest;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Satuan::all();

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
     * @param  \App\Http\Requests\StoreSatuanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSatuanRequest $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'id_perusahaan' => 'required'
            ]);
        $satuan = Satuan::create([
            'nama' => $request->nama,
            'id_perusahaan' => $request->id_perusahaan
        ]);
    
        $data = Satuan::where('id', '=', $satuan->id)->get();
    
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
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Satuan::where('id','=',$id)->get();
        // $data = Mahasiswa::where('id', '=', $id)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSatuanRequest  $request
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSatuanRequest $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'id_perusahaan' => 'required'
            ]);

            $satuan = Satuan::findOrFail($id);

        $satuan->update([
            'nama' => $request->nama,
            'id_perusahaan' => $request->id_perusahaan
        ]);
    
        $data = Satuan::where('id', '=', $satuan->id)->get();
    
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
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $satuan = Satuan::findOrFail($id);

        $data = $satuan->delete();
        
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }
}
