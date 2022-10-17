<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['supplier'] = Supplier::leftJoin('t_perusahaan AS P', 'P.id', 't_supplier.id_perusahaan')
        ->select('t_supplier.*', 'P.nama AS nama_perusahaan')     
        ->where('t_supplier.id_perusahaan', auth()->user()->id_perusahaan)     
        ->orderBy('t_supplier.id', 'desc')
        ->get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('supplier.index', $data);
    }

    public function index2(){
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('supplier.tambah', $data);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string',
            'tlp' => 'required|string|max:50',
            'salesman' => 'required|string|max:50',
            'bank' => 'required|string|max:50',
            'no_rekening' => 'required|string|max:50',
        ]);
        
        $input = Supplier::create($request->all());
        return redirect('/supplier')->with('success', 'Input data Supplier berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama' => 'string|max:50',
            'alamat' => 'string',
            'tlp' => 'string|max:50',
            'salesman' => 'string|max:50',
            'bank' => 'string|max:50',
            'no_rekening' => 'string|max:50',
        ]);

        $supplier->update($request->all());
        return redirect('/supplier')->with('success', 'Update Data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect('/supplier')->with('delete', 'Delete Data berhasil');
    }
}
