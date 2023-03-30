<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use App\Models\Perusahaan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PDOException;

class MerekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['merek'] = Merek::where('id_perusahaan', auth()->user()->id_perusahaan)->get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('merek.index', $data);
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
        // DB::beginTransaction();
        // try {
            Merek::create($request->all());
            return redirect()->back()->with(['success' => 'Data Berhasil Disimpan!']);
        // } catch(QueryException | Exception | PDOException $e) {
            // DB::rollBack();
            // return redirect()->back()->with(['error' => 'Terjadi Kesalahan Server']);
        // }
        // DB::commit();
        // return redirect('/merek')->with('success', 'Input data Merek berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merek  $merek
     * @return \Illuminate\Http\Response
     */
    public function show(Merek $merek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Merek  $merek
     * @return \Illuminate\Http\Response
     */
    public function edit(Merek $merek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Merek  $merek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merek $merek)
    {
        if($request->nama){
            $merek->update(['nama' => $request->nama]);
            return redirect()->back()->with(['success' => 'Data Berhasil Diupdate!']);
        }
        return redirect()->back()->with(['error' => 'Data Berhasil Gagal Diupdate!']);
        // return redirect('/merek')->with('success', 'Update Data berhasil');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Merek  $merek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merek $merek)
    {
        $merek->delete();
        return response(null, 204);

        // return redirect('/merek')->with('delete', 'Delete Data berhasil');
        // return redirect()->route('admin.merek.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
