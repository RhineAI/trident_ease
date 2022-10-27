<?php

namespace App\Http\Controllers;

use App\Models\KasKeluar;
use App\Models\PembayaranPembelian;
use App\Models\Pembelian;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PembayaranPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['pembayaran'] = PembayaranPembelian::leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_pembayaran_pembelian.id_pembelian')
        ->leftJoin('t_supplier as S', 'S.id', 'TP.id_supplier')
        ->select('S.nama AS nama_supplier', 'S.tlp', 'S.id as id_supplier', 't_pembayaran_pembelian.*', 'TP.dp', 'TP.total_pembelian', 'TP.sisa', 'TP.jenis_pembayaran')
        // ->where('TP.jenis_pembayaran', 2)
        ->where('TP.id_perusahaan', auth()->user()->id_perusahaan)    
        ->orderBy('jenis_pembayaran', 'desc')
        ->get();
        // $data['total_bayar'] = Pembayaran::where('id_pembelian', 'id_pembelian')->sum('total_bayar');
        $data['cDate'] = date('d-m-Y');
        // $data['totalBayar'] = Pembayaran::select('id_pembelian', DB::raw('ceiling(sum(t_pembayaran_pembelian.total_bayar)) AS totalBayar'))->groupBy('id_pembelian')->get();
        // DB::raw('sum(t_pembayaran_pembelian.total_bayar) AS total')
        // return $data['totalBayar'];
        return view('pembayaran-pembelian.index', $data);
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

    public function checkPrice($value)
    {
        if (gettype($value) == "string") {
            $temp = 0;
            for ($i = 0; $i < strlen($value); $i++) {
                if ((isset($value[$i]) == true && $value[$i] != ".") && $value[$i] != ",") {
                    $temp = ($temp * 10) + (int)$value[$i];
                }
            }
            return $temp;
        } else {
            return $value;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $pembayaran = new PembayaranPembelian();
        $pembayaran->id_pembelian = $request->id_pembelian;
        $pembayaran->tgl = date('Y-m-d');
        $pembayaran->total_bayar = $request->bayar;
        $pembayaran->id_user = auth()->user()->id;
        $pembayaran->id_perusahaan = auth()->user()->id_perusahaan;
        $pembayaran->save();
        $updateSisa = Pembelian::find($request->id_pembelian);
        if(($updateSisa->sisa - $request->bayar) >= 0){
            $updateSisa->sisa -= $request->bayar;
        } else {
            $updateSisa->sisa = 0;
            $updateSisa->kembalian = $request->kembalian;
        }
        $updateSisa->update();

        $kasMasuk = new KasKeluar();
        $kasMasuk->tgl = date('Y-m-d');
        $kasMasuk->jumlah = $request->bayar;
        $kasMasuk->keperluan = 'Pembayaran Utang Terhadap Supplier';
        $kasMasuk->id_perusahaan = auth()->user()->id_perusahaan;
        $kasMasuk->id_user = auth()->user()->id;
        $kasMasuk->save();

        return back()->with(['success', 'Pembayaran berhasil']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PembayaranPembelian  $pembayaranPembelian
     * @return \Illuminate\Http\Response
     */
    public function show(PembayaranPembelian $pembayaranPembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PembayaranPembelian  $pembayaranPembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(PembayaranPembelian $pembayaranPembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PembayaranPembelian  $pembayaranPembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PembayaranPembelian $pembayaranPembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PembayaranPembelian  $pembayaranPembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(PembayaranPembelian $pembayaranPembelian)
    {
        //
    }
}
