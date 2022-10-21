<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;
use App\Models\Perusahaan;
use App\Models\TransaksiPenjualan;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        // $data['pembayaran'] = TransaksiPenjualan::leftJoin('t_pelanggan AS P', 'P.id', 't_transaksi_penjualan.id_pelanggan')
        // ->select('t_transaksi_penjualan.*', 'P.nama AS nama_pelanggan', 'P.tlp', 'P.id as id_pelanggan')     
        // ->where('t_transaksi_penjualan.total_bayar', 0)
        // ->where('t_transaksi_penjualan.dp', '>', 0)
        // ->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)     
        // ->orderBy('id', 'desc')
        // ->get();
        $data['pembayaran'] = Pembayaran::leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_pembayaran.id_penjualan')
        ->leftJoin('t_pelanggan as P', 'P.id', 'TP.id_pelanggan')
        ->select('TP.*', 'P.nama AS nama_pelanggan', 'P.tlp', 'P.id as id_pelanggan', 't_pembayaran.id as id_pembayaran')     
        ->where('TP.jenis_pembayaran', 2)
        ->where('TP.sisa', '>', 0)
        ->where('TP.id_perusahaan', auth()->user()->id_perusahaan)     
        ->orderBy('id', 'desc')
        ->get();
        $data['cDate'] = date('d-m-Y');
        // return $data['pembayaran'];
        return view('pembayaran.index', $data);
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
     * @param  \App\Http\Requests\StorePembayaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePembayaranRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembayaranRequest  $request
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePembayaranRequest $request, Pembayaran $pembayaran)
    {
        $cPenjualan = TransaksiPenjualan::where('id', $pembayaran->id_penjualan)->first();
        // return $request;
        if($request->sisa <= 0){
            $cPenjualan->dp = $request->total_harga;
            $cPenjualan->sisa = 0;
            $cPenjualan->tgl = $request->tgl;
            $cPenjualan->id_user = auth()->user()->id;
            
            $pembayaran->total_bayar = $request->total_harga;
            $pembayaran->tgl = $request->tgl;
            $pembayaran->id_user = auth()->user()->id;
        } else {
            $cPenjualan->dp += $request->bayar;
            $cPenjualan->sisa += $request->sisa;
            $cPenjualan->tgl = $request->tgl;
            $cPenjualan->id_user = auth()->user()->id;
            
            $pembayaran->total_bayar += $request->bayar;
            $pembayaran->tgl = $request->tgl;
            $pembayaran->id_user = auth()->user()->id;
        }

        $pembayaran->update();
        $cPenjualan->update();
        return back()->with(['success', 'Pembayaran berhasil']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
