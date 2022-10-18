<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;
use App\Models\Perusahaan;
use App\Models\Supplier;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['supplier'] = Supplier::get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('pembelian.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pembelian = new Pembelian();
        // $pembelian->kode_pembelian = 0;

        $generateKode = Pembelian::select('kode_invoice')->orderBy('created_at', 'DESC')->first();

       
        $kode = '';

        if($generateKode == NULL) {
            $kode = 'INV-202205001';
        } else {
            $kode = sprintf('INV-202205%03d', substr($generateKode->kode_invoice, 10) + 1);
        }

        $pembelian->kode_invoice = $kode;


        $pembelian->id_supplier = $id;
        $pembelian->total_pembelian  = 0;
        $pembelian->jenis_pembayaran = 1;
        $pembelian->tgl = now();
        $pembelian->id_user = auth()->user()->id;
        $pembelian->save();

        session(['id_pembelian'=> $pembelian->id]);  
        session(['id_supplier'=> $pembelian->id_supplier]);

        return redirect()->route('pembelian_detail.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembelianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePembelianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembelianRequest  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePembelianRequest $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembelian $pembelian)
    {
        //
    }
}
