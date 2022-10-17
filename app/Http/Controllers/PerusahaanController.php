<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Http\Requests\StorePerusahaanRequest;
use App\Http\Requests\UpdatePerusahaanRequest;
use Illuminate\Support\Str;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('perusahaan.index', $data);
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
     * @param  \App\Http\Requests\StorePerusahaanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerusahaanRequest $request)
    {
        $perusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        if($request->nama){
            $request->validate([
                'nama' => 'string',
            ]);
            $perusahaan->nama = $request->nama;
        } else {
            $perusahaan->nama = $perusahaan->nama;
        }

        if($request->alamat){
            $request->validate([
                'alamat' => 'string',
            ]);
            $perusahaan->alamat = $request->alamat;
        } else {
            $perusahaan->alamat = $perusahaan->alamat;
        }

        if($request->tlp){
            $request->validate([
                'tlp' => 'string',
            ]);
            $perusahaan->tlp = $request->tlp;
        } else {
            $perusahaan->tlp = $perusahaan->tlp;
        }

        if($request->pemilik){
            $request->validate([
                'pemilik' => 'string',
            ]);
            $perusahaan->pemilik = $request->pemilik;
        } else {
            $perusahaan->pemilik = $perusahaan->pemilik;
        }

        if($request->bank){
            $request->validate([
                'bank' => 'string',
            ]);
            $perusahaan->bank = $request->bank;
        } else {
            $perusahaan->bank = $perusahaan->bank;
        }

        if($request->no_rekening){
            $request->validate([
                'no_rekening' => 'string',
            ]);
            $perusahaan->no_rekening = $request->no_rekening;
        } else {
            $perusahaan->no_rekening = $perusahaan->no_rekening;
        }

        if($request->npwp){
            $request->validate([
                'npwp' => 'string',
            ]);
            $perusahaan->npwp = $request->npwp;
        } else {
            $perusahaan->npwp = $perusahaan->npwp;
        }

        if($request->slogan){
            $request->validate([
                'slogan' => 'string',
            ]);
            $perusahaan->slogan = $request->slogan;
        } else {
            $perusahaan->slogan = $perusahaan->slogan;
        }

        if($request->email){
            $request->validate([
                'email' => 'string|email',
            ]);
            $perusahaan->email = $request->email;
        } else {
            $perusahaan->email = $perusahaan->email;
        }

        if($request->logo){
            $request->validate([
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg',
            ]);

            $getMime = $request->file('logo')->getMimeType(); 
            $explodedMime = explode('/' ,$getMime);
            $mime = end($explodedMime);
            $name = Str::random(25) . '.' . $mime;
            $request->logo->move('assets/img', $name);

            $perusahaan->logo = ('/assets/img/' . $name);
        } else {
            $perusahaan->logo = $perusahaan->logo;
        }
        $perusahaan->save();

        return redirect('/perusahaan')->with('success', 'Ubah Data Perusahan berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function show(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePerusahaanRequest  $request
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerusahaanRequest $request, Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perusahaan $perusahaan)
    {
        //
    }
}
