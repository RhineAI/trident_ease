<?php

namespace App\Http\Controllers\Api;

use App\Models\kasMasuk;
use App\Http\Requests\StoreKasMasukControllerRequest;
use App\Http\Requests\UpdateKasMasukControllerRequest;

class KasMasukControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = kasMasuk::all();

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
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKasMasukControllerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKasMasukControllerRequest $request)
    {
        try {
            $request->validate([
                'tgl' => 'required',
                'jumlah' => 'required',
                'id_user' => 'required',
                'id_perusahaan' => 'required',
            ]);
        $merek = kasMasuk::create([
            'tgl' => $request->tgl,
            'jumlah' => $request->jumlah,
            'id_user' => $request->id_user,
            'id_perusahaan' => $request->id_perusahaan,
        ]);
    
        $data = kasMerek::where('id', '=', $kasMasuk->id)->get();
    
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
     * @param  \App\Models\KasMasukController  $kasMasukController
     * @return \Illuminate\Http\Response
     */
    public function show(KasMasukController $kasMasukController)
    {
        $data = kasMasuk::where('id', '=', $id)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KasMasukController  $kasMasukController
     * @return \Illuminate\Http\Response
     */
    public function edit(KasMasukController $kasMasukController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKasMasukControllerRequest  $request
     * @param  \App\Models\KasMasukController  $kasMasukController
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKasMasukControllerRequest $request, KasMasukController $kasMasukController)
    {
        try {
            $request->validate([
                'tgl' => 'required',
                'jumlah' => 'required',
                'id_user' => 'required',
                'id_perusahaan' => 'required',
            ]);

            $kasMasuk = kasMasuk::findOrFail($id);

            $kasMasuku->update([
                'tgl' => $request->tgl,
                'jumlah' => $request->jumlah,
                'id_user' => $request->id_user,
                'id_perusahaan' => $request->id_perusahaan,
        ]);
    
        $data = kasMasuk::where('id', '=', $supplier->id)->get();
    
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
     * @param  \App\Models\KasMasukController  $kasMasukController
     * @return \Illuminate\Http\Response
     */
    public function destroy(KasMasukController $kasMasukController)
    {
        $kasMasuk = kasMasuk::findOrFail($id);

        $data = $kasMasuk->delete();
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }
}
