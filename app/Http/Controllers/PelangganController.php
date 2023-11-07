<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PDOException;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->perusahaan->grade >= 2) {
                // User has super access, allow all actions
                return $next($request);
            } else {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses');
            }
        });
    }
    public function index()
    {
        $data['pelanggan'] = Pelanggan::leftJoin('t_perusahaan AS P', 'P.id', 't_pelanggan.id_perusahaan')
        ->select('t_pelanggan.*', 'P.nama AS nama_perusahaan')     
        ->where('t_pelanggan.id_perusahaan', auth()->user()->id_perusahaan)     
        ->orderBy('t_pelanggan.id', 'desc')
        ->get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('pelanggan.index', $data);
    }

    public function index2()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('pelanggan.tambah', $data);
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
     * @param  \App\Http\Requests\StorePelangganRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tlp' => 'required',
            'jenis_kelamin' => 'required',
            'id_perusahaan' => 'required'
        ]);

        // return $request;
        DB::beginTransaction();
        try {
            Pelanggan::create($request->all());
            return redirect()->route('admin.pelanggan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } catch(QueryException | Exception | PDOException $e) {
            DB::rollBack();
            return redirect()->route('admin.pelanggan.index')->with(['error' => 'Terjadi Kesalahan Server!']);
        }
        DB::commit();

        // $input = Pelanggan::create($request->all());
        // return redirect()->route('admin.pelanggan.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePelangganRequest  $request
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePelangganRequest $request, Pelanggan $pelanggan)
    {
        $pelanggan->update($request->all());
        // return redirect('/pelanggan')->with('success', 'Update Data berhasil');
        return redirect()->route('admin.pelanggan.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        // return redirect('/pelanggan')->with('delete', 'Delete Data berhasil');
        return redirect()->route('admin.pelanggan.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
