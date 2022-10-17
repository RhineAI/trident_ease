<?php

namespace App\Http\Controllers;

use App\Models\KasKeluar;
use App\Http\Requests\StoreKasKeluarRequest;
use App\Http\Requests\UpdateKasKeluarRequest;

class KasKeluarController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKasKeluarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKasKeluarRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KasKeluar  $kasKeluar
     * @return \Illuminate\Http\Response
     */
    public function show(KasKeluar $kasKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KasKeluar  $kasKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(KasKeluar $kasKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKasKeluarRequest  $request
     * @param  \App\Models\KasKeluar  $kasKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKasKeluarRequest $request, KasKeluar $kasKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KasKeluar  $kasKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(KasKeluar $kasKeluar)
    {
        //
    }
}
