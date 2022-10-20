<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPenjualan;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Perusahaan;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;
use App\Models\DetailPenjualan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

class TransaksiPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  $barang = Barang::orderBy('nama')->get();
        //  $diskon = TransaksiPenjualan::first()->diskon ?? 0;
 
        //  $detail = DetailPenjualan::orderBy('id_penjualan_detail', 'DESC');

        $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
   
        return view('transaksi-penjualan.index', $data);
         
    }

    public function listTransaksi()
    {
        //  $barang = Barang::orderBy('nama')->get();
        //  $diskon = TransaksiPenjualan::first()->diskon ?? 0;
 
        //  $detail = DetailPenjualan::orderBy('id_penjualan_detail', 'DESC');

        $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['transaksi'] = TransaksiPenjualan::select('*')->where('id', auth()->user()->id_perusahaan)->get();
   
       return view('transaksi-penjualan.listTransaksi', $data);
    }

    public function dataTransaksi()
    {
        $penjualan = TransaksiPenjualan::leftJoin('t_pelanggan AS P', 'P.id', 't_transaksi_penjualan.id_pelanggan')
                                        ->select('t_transaksi_penjualan.*', 'P.nama AS nama_pelanggan')
                                        ->orderBy('id', 'desc')->get();

        return datatables()
        ->of($penjualan)
        ->addIndexColumn()
        ->addColumn('invoice', function($penjualan) {
            return '<span class="badge badge-info">'. $penjualan->id .'</span>';
        })
        ->addColumn('total_bayar', function($penjualan) {
            return 'RP. '. format_uang($penjualan->total_harga);
        })
        ->addColumn('action', function ($penjualan) {
            return '
                <button class="btn btn-xs btn-danger rounded delete"><i class="fa-solid fa-file-pdf"></i></button>
            ';
        })
        ->rawColumns(['action', 'invoice'])
        ->make(true);
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
     * @param  \App\Http\Requests\StorePenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePenjualanRequest $request)
    {
        // dd($request); die;
        if($request->kembali < 0){
            return back()->with('error', 'Uang bayar kurang');
        } else {
            $penjualanBaru = new TransaksiPenjualan();
            // "select max(id)+1 as nextid from t_pembayaran where id like '".$tgl."%'"
            // dd(TransaksiPenjualan::select("id")->where('id', 'like', '%'. date('Ymd') . '%')->first()); die;
            if(TransaksiPenjualan::select("id")->where('id', 'like', '%'. date('Ymd') . '%')->first() == null){
                $indexTransaksi = sprintf("%05d", 1);
                $penjualanBaru->id = date('Ymd'). $indexTransaksi;
            }

            $penjualanBaru->tgl = date('Y-m-d');
            $penjualanBaru->id_pelanggan = $request->id_pelanggan;
            $penjualanBaru->total_harga = $request->total_bayar;
            if($request->jenis_pembayaran == '1') {
                $penjualanBaru->total_bayar = $request->bayar;
            } else {
                $penjualanBaru->total_bayar = $request->dp;
            }
            $penjualanBaru->kembalian = $request->kembali;
            $penjualanBaru->id_user = auth()->user()->id;
            $penjualanBaru->id_perusahaan = auth()->user()->id_perusahaan;
            $penjualanBaru->save();

            $pembayaranBaru = new Pembayaran();
            $pembayaranBaru->id_penjualan = $penjualanBaru->id;
            $pembayaranBaru->tgl = date('Ymd');
            $pembayaranBaru->total_bayar = $request->total_bayar;
            $pembayaranBaru->id_user = auth()->user()->id;
            $pembayaranBaru->save();
            // dd($penjualanBaru->id); die;
            foreach($request->item as $barang){
                // dd($barang['discount']); die;
                $detPenjualanBaru = new DetailPenjualan(); 
                $detPenjualanBaru->id_penjualan = $penjualanBaru->id;
                $detPenjualanBaru->id_barang = $barang['id_barang'];
                $detPenjualanBaru->qty = $barang['qty'];
                $detPenjualanBaru->diskon = $barang['discount'];
                $detPenjualanBaru->harga_beli = $barang['harga_beli'];
                $detPenjualanBaru->harga_jual = $barang['harga_jual'];
                $detPenjualanBaru->id_perusahaan = auth()->user()->id_perusahaan;
                $detPenjualanBaru->save();
                
                $barangUpdate = Barang::find($barang['id_barang']);
                $barangUpdate->stock -= $barang['qty'];
                $barangUpdate->update();
                
                // $barangUpdate = Barang::select('stock')->where('id', $barang->id_barang)->first();
                // $kurangiStok = $barangUpdate - $barang->qty;
                // Barang::update([
                //     'stock' => $kurangiStok
                // ]);
            }

            return redirect('/list-transaksi')->with(['success' => 'Input data Transaksi Berhasil!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiPenjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiPenjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenjualanRequest  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenjualanRequest $request, TransaksiPenjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiPenjualan $penjualan)
    {
        //
    }
}
