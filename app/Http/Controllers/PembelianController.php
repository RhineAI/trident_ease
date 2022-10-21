<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;
use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\Pembayaran;
use App\Models\Perusahaan;
use App\Models\Supplier;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['supplier'] = Supplier::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        return view('transaksi-pembelian.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $data['supplier'] = Supplier::get();
        $data['produk'] = Barang::get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('pembelian.tambah', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembelianRequest  $request
     * @return \Illuminate\Http\Response
     */
    // old store (mungkin masih berguna)
    // public function store(StorePembelianRequest $request)
    // {
    //     $pembelian = new Pembelian();
    //     $generateKode = Pembelian::select('kode_invoice')->orderBy('created_at', 'DESC')->first();

    //     $kode = '';

    //     if($generateKode == NULL) {
    //         $kode = 'INV-202205001';
    //     } else {
    //         $kode = sprintf('INV-202205%03d', substr($generateKode->kode_pembelian, 10) + 1);
    //         // $kode = sprintf('BRC-202205%03d' + 1);
    //     }

    //     $pembelian->tgl = now();
    //     $pembelian->kode_invoice = $kode;
    //     $pembelian->id_supplier = $request->id_supplier;
    //     $pembelian->total_pembelian = $request->total_pembelian;
    //     $pembelian->jenis_pembayaran = $request->jenis_pembayaran;
    //     $pembelian->id_user = $request->id_user;
    //     $pembelian->save();

    //     $detail = DetailPembelian::Where('id_pembelian', $pembelian->id)->get();
    //     foreach ($detail as $item) {
    //         $produk = Barang::find($item->id_produk);
    //         $produk->stok += $item->jumlah;
    //         $produk->update();
    //     }

    //     return redirect()->route('pembelian.index');
    // }

    public function store(StorePembelianRequest $request)
    {
        // dd($request); die;
            $pembelianBaru = new Pembelian();
            // "select max(id)+1 as nextid from t_pembayaran where id like '".$tgl."%'"
            // dd(Pembelian::select("id")->where('id', 'like', '%'. date('Ymd') . '%')->first()); die;
            if(Pembelian::select("id")->where('id', 'like', '%'. date('Ymd') . '%')->first() == null){
                $indexTransaksi = sprintf("%05d", 1);
                $pembelianBaru->id = date('Ymd'). $indexTransaksi;
            }

            $pembelianBaru->tgl = date('Y-m-d');
            $pembelianBaru->kode_invoice = 'kode invoice simpak';
            $pembelianBaru->id_supplier = $request->id_supplier;
            $pembelianBaru->total_pembelian = $request->total_pembelian;
            $pembelianBaru->jenis_pembayaran = $request->jenis_pembayaran;
            $pembelianBaru->id_user = auth()->user()->id;
            $pembelianBaru->id_perusahaan = auth()->user()->id_perusahaan;
            $pembelianBaru->save();
            
            foreach($request->item as $barang){
                // dd($barang['discount']); die;
                $detPembelianBaru = new DetailPembelian(); 
                $detPembelianBaru->id_pembelian = $pembelianBaru->id;
                $detPembelianBaru->tgl = date('Ymd');
                $detPembelianBaru->id_barang = $barang['id_barang'];
                $detPembelianBaru->harga_beli = $barang['harga_beli'];
                $detPembelianBaru->qty = $barang['qty'];
                $detPembelianBaru->diskon = $barang['discount'];
                $detPembelianBaru->id_perusahaan = auth()->user()->id_perusahaan;
                $detPembelianBaru->save();
                
                $barangUpdate = Barang::find($barang['id_barang']);
                $barangUpdate->stock += $barang['qty'];
                $barangUpdate->harga_beli += $barang['harga_beli'];
                $barangUpdate->update();
                
                // $barangUpdate = Barang::select('stock')->where('id', $barang->id_barang)->first();
                // $kurangiStok = $barangUpdate - $barang->qty;
                // Barang::update([
                //     'stock' => $kurangiStok
                // ]);
            }

            return redirect('/list-transaksi')->with(['success' => 'Input data Transaksi Berhasil!']);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembelianRequest  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePembelianRequest $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembelian $pembelian)
    {
        //
    }

    public function listPembelian()
    {
        //  $barang = Barang::orderBy('nama')->get();
        //  $diskon = TransaksiPenjualan::first()->diskon ?? 0;
 
        //  $detail = DetailPenjualan::orderBy('id_penjualan_detail', 'DESC');

        $data['supplier'] = Supplier::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['transaksi'] = Pembelian::select('*')->where('id', auth()->user()->id_perusahaan)->get();
   
       return view('transaksi-pembelian.listTransaksi', $data);
    }


    
    public function dataPembelian()
    {
        $pembelian = Pembelian::leftJoin('t_supplier AS P', 'P.id', 't_transaksi_pembelian.id_supplier')
                                        ->select('t_transaksi_pembelian.*', 'P.nama AS nama_supplier')
                                        ->orderBy('id', 'desc')->get();

        return datatables()
        ->of($pembelian)
        ->addIndexColumn()
        ->addColumn('invoice', function($pembelian) {
            return '<span class="badge badge-info">'. $pembelian->id .'</span>';
        })
        ->addColumn('total_pembelian', function($pembelian) {
            return 'RP. '. format_uang($pembelian->total_pembelian);
        })
        ->addColumn('action', function ($pembelian) {
            return '
                <button class="btn btn-xs btn-danger rounded delete"><i class="fa-solid fa-file-pdf"></i></button>
            ';
        })
        ->rawColumns(['action', 'invoice'])
        ->make(true);
    }

}
