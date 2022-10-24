<?php

namespace App\Http\Controllers;

use App\Models\ReturPenjualan;
use App\Http\Requests\StoreReturPenjualanRequest;
use App\Http\Requests\UpdateReturPenjualanRequest;
use App\Models\Perusahaan;
use App\Models\TransaksiPenjualan;

class ReturPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['penjualan'] = TransaksiPenjualan::leftJoin('t_pelanggan AS P', 'P.id', 't_transaksi_penjualan.id_pelanggan')
        ->leftJoin('t_detail_penjualan AS DT', 't_transaksi_penjualan.id', 'DT.id_penjualan')
        ->leftJoin('t_barang AS B', 'B.id', 'DT.id_barang')
        ->select('B.*', 'B.nama AS nama_barang', 'SP.nama AS nama_supplier', 'ST.nama AS nama_satuan', 'M.nama AS nama_merek', 'P.nama AS nama_perusahaan')
        ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan)     
        ->orderBy('t_barang.id', 'desc')
        ->get();
        return view('returPenjualan.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReturPenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReturPenjualanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function show(ReturPenjualan $returPenjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturPenjualan $returPenjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReturPenjualanRequest  $request
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReturPenjualanRequest $request, ReturPenjualan $returPenjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturPenjualan $returPenjualan)
    {
        //
    }
}
