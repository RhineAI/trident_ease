<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\DetailPenjualan;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreDetailPenjualanRequest;
use App\Http\Requests\UpdateDetailPenjualanRequest;

class DetailPenjualanController extends Controller
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
        $transaksi = new TransaksiPenjualan();
        $detail = DetailPenjualan::select('id_penjualan')->orderBy('created_at', 'DESC')->first();

        $kode = '';

        if($detail == NULL) {
            $kode = '202210001';
        } else {
            $kode = sprintf('2022105%03d', substr($produk->barcode, 6) + 1);
            // $kode = sprintf('BRC-202205%03d' + 1);
        }

        $kode_penjualan = $kode;

        $newTransaksi = new DetailPenjualan();
        
        $newTransaksi->id_penjualan = $kode;
        $newTransaksi->id_perusahaan = auth()->user()->id_perusahaan;
        $newTransaksi->save();

        return redirect()->route('transaksi.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDetailPenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDetailPenjualanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailPenjualan  $detailPenjualan
     * @return \Illuminate\Http\Response
     */
    public function show(DetailPenjualan $detailPenjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailPenjualan  $detailPenjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailPenjualan $detailPenjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDetailPenjualanRequest  $request
     * @param  \App\Models\DetailPenjualan  $detailPenjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetailPenjualanRequest $request, DetailPenjualan $detailPenjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailPenjualan  $detailPenjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailPenjualan $detailPenjualan)
    {
        //
    }
}
