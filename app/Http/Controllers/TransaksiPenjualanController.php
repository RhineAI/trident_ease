<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use Barryvdh\DomPDF\PDF as pdf;
use App\Models\TransaksiPenjualan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
// use Symfony\Component\Console\Input\Input;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;

class TransaksiPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data['barang'] = Barang::orderBy('nama')->get();
        //  $diskon = TransaksiPenjualan::first()->diskon ?? 0;
 
        //  $detail = DetailPenjualan::orderBy('id_penjualan_detail', 'DESC');

        $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
   
        return view('transaksi-penjualan.index', $data);
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

    public function store(StorePenjualanRequest $request)
    {
        return $request;
        // dd($request); die;
        if($request->kembali < 0){
            // return back()->with('error', 'Uang bayar kurang');
            return back()->withInput($request->only('id_pelanggan', 'bayar', 'kembali'))->with('error', 'Uang Bayar Kurang');
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
            if($request->jenis_pembayaran == 1) {
                $penjualanBaru->total_bayar = $this->checkPrice($request->bayar);
            } else {
                $penjualanBaru->total_bayar = $this->checkPrice($request->dp);
            }
            $penjualanBaru->kembalian = $request->kembali;
            $penjualanBaru->dp = $this->checkPrice($request->dp);
            $penjualanBaru->sisa = $request->sisa;
            $penjualanBaru->jenis_pembayaran = $request->jenis_pembayaran;
            $penjualanBaru->id_user = auth()->user()->id;
            $penjualanBaru->id_perusahaan = auth()->user()->id_perusahaan;
            
            foreach($request->item as $barang){
                // dd($barang['discount']); die;
                $penjualanBaru->keuntungan += $barang['keuntungan'];
                $penjualanBaru->save();
                
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

            $pembayaranBaru = new Pembayaran();
            $pembayaranBaru->id_penjualan = $penjualanBaru->id;
            $pembayaranBaru->tgl = date('Ymd');
            $pembayaranBaru->total_bayar = $request->total_bayar;
            $pembayaranBaru->id_user = auth()->user()->id;
            $pembayaranBaru->id_perusahaan = auth()->user()->id_perusahaan;
            $pembayaranBaru->save();
            // dd($penjualanBaru->id); die;
            

            return redirect()->route('list-transaksi.index')->with(['success' => 'Input data Transaksi Berhasil!']);
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

    public function exportPDF($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);
        $pdf  = pdf::loadView('reportpembelian.export_pdf', compact('awal', 'akhir', 'data'));
        $pdf->setPaper('a4', 'potrait');
        
        return $pdf->stream('Laporan-pendapatan-'. date('Y-m-d-his') .'.pdf');
    }
}
