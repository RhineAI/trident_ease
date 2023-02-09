<?php

namespace App\Http\Controllers\Api;

use App\Models\Penjualan;
use App\Models\Perusahaan;
use App\Models\Supplier;
use App\Models\User;
use App\Helpers\ApiFormatter;
use Illuminate\Routing\Controller;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;



class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Penjualan::all();
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
     * @param  \App\Http\Requests\StorePenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePenjualanRequest $request)
    {
        try {
            $request->validate([
                'tgl' => 'required',
                'id_pelanggan' => 'required',
                'kode_invoice'  => 'required',
                'total_harga' => 'required',
                'total_bayar' => 'required',
                'keuntungan' => 'required',
                'jenis_pembayaran' => 'required',
                'kembalian' => 'required',
                'dp' => 'required',
                'sisa' => 'required',
                'id_user' => 'required',
                'id_perusahaan' => 'required'
            ]);
        $penjualan = Penjualan::create([
            'tgl' => $request->tgl,
            'id_pelanggan' => $request->id_pelanggan,
            'kode_invoice' => $request->kode_invoice,
            'total_harga' => $request->total_harga,
            'total_bayar' => $request->total_bayar,
            'keuntungan' => $request->keuntungan,
            'kembalian' => $request->kembalian,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'dp' => $request->dp,
            'sisa' => $request->sisa,
            'id_user' => $request->id_user,
            'id_perusahaan' => $request->id_perusahaan
        ]);
    
        $data = Penjualan::where('id', '=', $penjualan->id)->get();
    
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
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenjualanRequest  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenjualanRequest $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }
}
