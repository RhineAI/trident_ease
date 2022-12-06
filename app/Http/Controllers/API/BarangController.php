<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Perusahaan;
use App\Models\User;
use App\Helpers\ApiFormatter;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;



class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Barang::all();

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
     * @param  \App\Http\Requests\StoreBarangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBarangRequest $request)
    {
        try {
            $request->validate([
                'kode'=>'required',
                'nama'=>'required',
                'barcode'=>'required', 
                'id_kategori'=>'required',
                'id_supplier'=>'required',
                'id_satuan'=>'required',
                'id_merek'=>'required',
                'id_perusahaan'=>'required',
                'stock'=>'required',
                'stock_minimal'=>'required',
                'harga_beli'=>'required',
                'keuntungan'=>'required',
                'keterangan'=>'required',
                'status'=>'required'
            ]);
        $barang = Barang::create([
            'kode' => $request->kode,
            'nama'=> $request->nama,
            'barcode'=> $request->barcode, 
            'id_kategori'=> $request->id_kategori,
            'id_supplier'=> $request->id_supplier,
            'id_satuan'=> $request->id_satuan,
            'id_merek'=> $request->id_merek,
            'id_perusahaan'=> $request->id_perusahaan,
            'stock'=> $request->stock,
            'stock_minimal'=> $request->stock_minimal,
            'harga_beli'=> $request->harga_beli,
            'keuntungan'=> $request->keuntungan,
            'keterangan'=> $request->keterangan,
            'status' => $request->status
        ]);
        
    
        $data = Barang::where('id', '=', $barang->id)->get();
    
        $perusahaan = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();
        $limit = Barang::whereDate('created_at', $now)->where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        
        // $c = Barang::all();
        // return $limit;
            if($perusahaan->grade == 1) {
                if($limit < 10 ) {
                    $barang->save();
                    return ApiFormatter::createApi(200, 'success', $data);
                }else {
                    return ApiFormatter::createApi(400,'Failed');
                }
            } elseif($perusahaan->grade == 2) {
                if($limit < 50 ) {
                    $barang->save();
                    return ApiFormatter::createApi(200, 'success', $data);
                }else {
                    return ApiFormatter::createApi(400,'Failed');
                }
            } elseif($perusahaan->grade == 3) {
                if($limit < 10000 ) {
                    $barang->save();
                    return ApiFormatter::createApi(200, 'success', $data);
                }else {
                    return ApiFormatter::createApi(400,'Failed');
                }
            } else{
                return redirect()->route('logout')->with(['error' => 'Lu siapa??']);
            }
        
            
       
        // if($data) {
        //     return ApiFormatter::createApi(200, 'success', $data);
        // } else{
        //     return ApiFormatter::createApi(400,'Failed');
        // }
    
           }catch (Exception $error) {
                  return ApiFormatter::createApi(400,'Failed');
    }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Barang::where('id', '=', $id)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBarangRequest  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBarangRequest $request,$id)
    {
        try {
            $request->validate([
                'kode'=>'required',
                'nama'=>'required',
                'barcode'=>'required', 
                'id_kategori'=>'required',
                'id_supplier'=>'required',
                'id_satuan'=>'required',
                'id_merek'=>'required',
                'id_perusahaan'=>'required',
                'stock'=>'required',
                'stock_minimal'=>'required',
                'harga_beli'=>'required',
                'keuntungan'=>'required',
                'keterangan'=>'required',
                'status'=>'required'
            ]);

        $barang = Barang::findOrFail($id);

        $barang->update([
            'kode' => $request->kode,
            'nama'=> $request->nama,
            'barcode'=> $request->barcode, 
            'id_kategori'=> $request->id_kategori,
            'id_supplier'=> $request->id_supplier,
            'id_satuan'=> $request->id_satuan,
            'id_merek'=> $request->id_merek,
            'id_perusahaan'=> $request->id_perusahaan,
            'stock'=> $request->stock,
            'stock_minimal'=> $request->stock_minimal,
            'harga_beli'=> $request->harga_beli,
            'keuntungan'=> $request->keuntungan,
            'keterangan'=> $request->keterangan,
            'status' => $request->status
        ]);
    
        $data = Barang::where('id', '=', $barang->id)->get();
    
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
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        $data = $barang->delete();
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }
}
