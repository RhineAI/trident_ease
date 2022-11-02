<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;
use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\KasKeluar;
use App\Models\Piutang;
use App\Models\Hutang;
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
        return view('transaksi-pembelian.index', $data);
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

            $kode = '';
            $date = (date('Ymd'));
            // return $date;
            if($pembelianBaru == NULL) {
                $kode_invoice = $date . '0001';
            } 
            else {
                $kode = sprintf($date.'%04d', intval(substr($pembelianBaru->kode, 8)) + 1);
                $kode_invoice = strval($kode);
            }

            $pembelianBaru->tgl = date('Y-m-d');
            $pembelianBaru->kode_invoice = $kode_invoice;
            $pembelianBaru->id_supplier = $request->id_supplier;
            $pembelianBaru->total_pembelian = $this->checkPrice($request->total_pembelian);
            $pembelianBaru->jenis_pembayaran = $request->jenis_pembayaran;
            if($request->jenis_pembayaran == 2){
                $pembelianBaru->dp = $this->checkPrice($request->bayar_kredit);
                $pembelianBaru->sisa = $request->total_pembelian - $this->checkPrice($request->bayar_kredit);
            } else {
                $pembelianBaru->dp = 0;
                $pembelianBaru->sisa = 0;
            }
            $pembelianBaru->id_user = auth()->user()->id;
            $pembelianBaru->id_perusahaan = auth()->user()->id_perusahaan;
            $pembelianBaru->save();
            
            foreach($request->item as $barang){
                // dd($barang['discount']); die;
                $detPembelianBaru = new DetailPembelian(); 
                $detPembelianBaru->id_pembelian = $pembelianBaru->id;
                $detPembelianBaru->tgl = date('Y-m-d');
                $detPembelianBaru->id_barang = $barang['id_barang'];
                $detPembelianBaru->harga_beli = $this->checkPrice($barang['harga_beli']);
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

            if($request->jenis_pembayaran == 2){
                $pembayaranBaru = new Hutang();
                $pembayaranBaru->id_pembelian = $pembelianBaru->id;
                $pembayaranBaru->tgl = date('Y-m-d');
                $pembayaranBaru->total_bayar = $this->checkPrice($request->bayar_kredit);
                $pembayaranBaru->id_user = auth()->user()->id;
                $pembayaranBaru->id_perusahaan = auth()->user()->id_perusahaan;
                $pembayaranBaru->save();
                // dd($pembelianBaru->id); die;

                $kasMasuk = new KasKeluar();
                $kasMasuk->tgl = now();
                $kasMasuk->jumlah = $this->checkPrice($request->bayar_kredit);
                $kasMasuk->id_user = auth()->user()->id;
                $kasMasuk->id_perusahaan = auth()->user()->id_perusahaan;
                $kasMasuk->keperluan = 'DP Transaksi Pembelian Produk';
                $kasMasuk->save();
            } else {
                $kasMasuk = new KasKeluar();
                $kasMasuk->tgl = now();
                $kasMasuk->jumlah = $request->total_pembelian;
                $kasMasuk->id_user = auth()->user()->id;
                $kasMasuk->id_perusahaan = auth()->user()->id_perusahaan;
                $kasMasuk->keperluan = 'Transaksi Pembelian Produk';
                $kasMasuk->save();
            }
            
            return redirect('/list-pembelian')->with(['success' => 'Input data Transaksi Berhasil!']);
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
        //  $diskon = Transaksipembelian::first()->diskon ?? 0;
 
        //  $detail = Detailpembelian::orderBy('id_pembelian_detail', 'DESC');

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
