<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;
use App\Models\KasMasuk;
use App\Models\Perusahaan;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\DB;

class PiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['pembayaran'] = Piutang::leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
        ->leftJoin('t_pelanggan as P', 'P.id', 'TP.id_pelanggan')
        ->select('P.nama AS nama_pelanggan', 'P.tlp', 'P.id as id_pelanggan', 't_data_piutang.*', 'TP.dp', 'TP.total_harga', 'TP.sisa', 'TP.jenis_pembayaran')
        // ->where('TP.jenis_pembayaran', 2)
        ->where('TP.id_perusahaan', auth()->user()->id_perusahaan)    
        ->orderBy('jenis_pembayaran', 'desc')
        ->get();
        // $data['total_bayar'] = Pembayaran::where('id_penjualan', 'id_penjualan')->sum('total_bayar');
        $data['cDate'] = date('d-m-Y');
        // $data['totalBayar'] = Pembayaran::select('id_penjualan', DB::raw('ceiling(sum(t_pembayaran_penjualan.total_bayar)) AS totalBayar'))->groupBy('id_penjualan')->get();
        // DB::raw('sum(t_pembayaran_penjualan.total_bayar) AS total')
        // return $data['pembayaran'];
        return view('hutang-piutang.piutang.index', $data);
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
     * @param  \App\Http\Requests\StorePembayaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePembayaranRequest $request)
    {
        // return $request;
        $piutang = new Piutang();
        $piutang->id_penjualan = $request->id_penjualan;
        $piutang->tgl = date('Ymd');
        $piutang->total_bayar = $request->bayar;
        $piutang->id_user = auth()->user()->id;
        $piutang->id_perusahaan = auth()->user()->id_perusahaan;
        $piutang->save();
        $updateSisa = TransaksiPenjualan::find($request->id_penjualan);
        if(($updateSisa->sisa - $request->bayar) >= 0){
            $updateSisa->sisa -= $request->bayar;
        } else {
            $updateSisa->sisa = 0;
            $updateSisa->kembalian = $request->kembalian;
        }
        $updateSisa->update();

        $kasMasuk = new KasMasuk();
        $kasMasuk->tgl = date('Y-m-d');
        $kasMasuk->jumlah = $request->bayar;
        $kasMasuk->keterangan = 'Pembayaran Piutang Customer';
        $kasMasuk->id_perusahaan = auth()->user()->id_perusahaan;
        $kasMasuk->id_user = auth()->user()->id;
        $kasMasuk->save();

        return back()->with(['success', 'Pembayaran berhasil']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembayaranRequest  $request
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePembayaranRequest $request, Pembayaran $pembayaran)
    {
        // $cPenjualan = TransaksiPenjualan::where('id', $pembayaran->id_penjualan)->first();
        // // return $request;
        // if($request->sisa <= 0){
        //     $cPenjualan->dp = $request->total_harga;
        //     $cPenjualan->sisa = 0;
        //     $cPenjualan->tgl = $request->tgl;
        //     $cPenjualan->id_user = auth()->user()->id;
            
        //     $pembayaran->total_bayar = $request->total_harga;
        //     $pembayaran->tgl = $request->tgl;
        //     $pembayaran->id_user = auth()->user()->id;
        // } else {
        //     $cPenjualan->dp += $request->bayar;
        //     $cPenjualan->sisa += $request->sisa;
        //     $cPenjualan->tgl = $request->tgl;
        //     $cPenjualan->id_user = auth()->user()->id;
            
        //     $pembayaran->total_bayar += $request->bayar;
        //     $pembayaran->tgl = $request->tgl;
        //     $pembayaran->id_user = auth()->user()->id;
        // }

        // $pembayaran->update();
        // $cPenjualan->update();
        // return back()->with(['success', 'Pembayaran berhasil']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}