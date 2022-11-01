<?php

namespace App\Http\Controllers;

use App\Models\DetailReturPembelian;
use App\Http\Requests\StoreDetailReturPembelianRequest;
use App\Http\Requests\UpdateDetailReturPembelianRequest;
use App\Models\Pembelian;
use App\Models\Perusahaan;

class DetailReturPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
     * @param  \App\Http\Requests\StoreDetailReturPembelianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDetailReturPembelianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailReturPembelian  $detailReturPembelian
     * @return \Illuminate\Http\Response
     */
    public function show(DetailReturPembelian $detailReturPembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailReturPembelian  $detailReturPembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailReturPembelian $detailReturPembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDetailReturPembelianRequest  $request
     * @param  \App\Models\DetailReturPembelian  $detailReturPembelian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetailReturPembelianRequest $request, DetailReturPembelian $detailReturPembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailReturPembelian  $detailReturPembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailReturPembelian $detailReturPembelian)
    {
        //
    }
}
