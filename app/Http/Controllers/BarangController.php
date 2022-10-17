<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Perusahaan;
use App\Models\Satuan;
use App\Models\Supplier;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = Kategori::get();
        $data['supplier'] = Supplier::get();
        $data['merek'] = Merek::get();
        $data['satuan'] = Satuan::get();
        $data['perusahaan'] = Perusahaan::get();
        // $data['barang'] = Barang::get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['barang'] = Barang::leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')
        ->leftJoin('t_supplier AS SP', 'SP.id', 't_barang.id_supplier')
        ->leftJoin('t_satuan AS ST', 'ST.id', 't_barang.id_satuan')
        ->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')
        ->leftJoin('t_perusahaan AS P', 'P.id', 't_barang.id_perusahaan')
        ->select('t_barang.*', 'K.nama AS nama_kategori', 'SP.nama AS nama_supplier', 'ST.nama AS nama_satuan', 'M.nama AS nama_merek', 'P.nama AS nama_perusahaan')
        ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan)     
        ->orderBy('t_barang.id', 'desc')
        ->get();
        
        // dd($data['barang']); die;
        return view('barang.index', $data);
    }

    public function index2(){
        $data['categories'] = Kategori::get();
        $data['supplier'] = Supplier::get();
        $data['merek'] = Merek::get();
        $data['satuan'] = Satuan::get();
        $data['perusahaan'] = Perusahaan::get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('barang.tambah', $data);
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
        // dd($request); die;
        $input = Barang::create($request->all());
        return redirect('/barang')->with('success', 'Input data Barang berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
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
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $barang->update($request->all());
        return redirect('/barang')->with('success', 'Update Data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect('/barang')->with('delete', 'Delete Data berhasil');
    }
}
