<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use App\Models\Mahasiswa;
use App\Helpers\ApiFormatter;
use Illuminate\Routing\Controller;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;


// use App\Helpers\ApiFormatter;
// use App\Models\Perusahaan;
// use App\Models\Supplier;
// use Illuminate\Http\Request;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Supplier::all();

        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
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
        try {
            $request->validate([
                'nama' =>'required',
                'alamat' => 'required',
                'tlp' => 'required',
                'salesman' => 'required',
                'bank' => 'required',
                'no_rekening' => 'required',
                'id_perusahaan' => 'required',
            ]);

        $supplier = Supplier::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tlp' => $request->tlp,
            'salesman' => $request->salesman,
            'bank' => $request->bank,
            'no_rekening' => $request->no_rekening,
            'id_perusahaan' => $request->id_perusahaan,
        ]);
    
        $data = Supplier::where('id', '=', $supplier->id)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    
           }catch (Exception $error) {
                 return ApiFormatter::createApi(400,'Failed');
           }   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Supplier::where('id','=',$id)->get();
        // $data = Mahasiswa::where('id', '=', $id)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
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
    public function update(Request $request, $id)
    { 
        try {
            $request->validate([
                'nama' =>'required',
                'alamat' => 'required',
                'tlp' => 'required',
                'salesman' => 'required',
                'bank' => 'required',
                'no_rekening' => 'required',
                'id_perusahaan' => 'required',
            ]);

            $supplier = Supplier::findOrFail($id);

            $supplier->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'tlp' => $request->tlp,
                'salesman' => $request->salesman,
                'bank' => $request->bank,
                'no_rekening' => $request->no_rekening,
                'id_perusahaan' => $request->id_perusahaan,
        ]);
    
        $data = Supplier::where('id', '=', $supplier->id)->get();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    
           }catch (Exception $error) {
                 return ApiFormatter::createApi(400,'Failed');
           }          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $data = $supplier->delete();
        
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }
}
