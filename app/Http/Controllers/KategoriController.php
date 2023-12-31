<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = Kategori::where('id_perusahaan', auth()->user()->id_perusahaan)->get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('kategori.index', $data);
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
        // $request['nama'] = ucfirst($request->nama);
        // return $request;
        $input = Kategori::create($request->all());
        // return redirect('/kategori')->with('success', 'Input data Kategori berhasil!');
        return redirect()->back()->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $kategori->update($request->all());
        // return redirect('/kategori')->with('success', 'Update Data berhasil');
        return redirect()->back()->with(['success' => 'Data Berhasil Diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        // if (response()->json(500)){
        //     return redirect()->route('admin.kategori.index')->with(['error' => 'Data Gagal Dihapus!']);
        // } else {
        //     return redirect()->route('admin.kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);
        // }
        return response(null, 204);
        // return redirect('/kategori')->with('delete', 'Delete Data berhasil');
    }
}
