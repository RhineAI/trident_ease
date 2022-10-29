<?php

namespace App\Http\Controllers;

use App\Models\Penyesuaian;
use App\Http\Requests\StorePenyesuaianRequest;
use App\Http\Requests\UpdatePenyesuaianRequest;

class PenyesuaianController extends Controller
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
     * @param  \App\Http\Requests\StorePenyesuaianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePenyesuaianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penyesuaian  $penyesuaian
     * @return \Illuminate\Http\Response
     */
    public function show(Penyesuaian $penyesuaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penyesuaian  $penyesuaian
     * @return \Illuminate\Http\Response
     */
    public function edit(Penyesuaian $penyesuaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenyesuaianRequest  $request
     * @param  \App\Models\Penyesuaian  $penyesuaian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenyesuaianRequest $request, Penyesuaian $penyesuaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penyesuaian  $penyesuaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penyesuaian $penyesuaian)
    {
        //
    }
}
