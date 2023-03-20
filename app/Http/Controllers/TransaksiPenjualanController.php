<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Piutang;
use App\Models\Perusahaan;
use App\Models\KasMasuk;
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
         $data['barang'] = Barang::orderBy('nama')->where('id', auth()->user()->id_perusahaan)->get();
        //  $diskon = TransaksiPenjualan::first()->diskon ?? 0;
 
        //  $detail = DetailPenjualan::orderBy('id_penjualan_detail', 'DESC');

        $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        $data['pelangganUmum'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->first();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
   
        return view('transaksi-penjualan.index', $data);
    }

   
    public function NextId($tgl){
        $pieces = explode("-",$tgl);
        $yy=$pieces[0]; // piece1
        $mm=$pieces[1]; //
        $dd=$pieces[2]; 
        $tgl=$yy.$mm.$dd;
        
        $result= TransaksiPenjualan::select(DB::raw('max(id)+1 AS nextid'))->orderBy('id', 'DESC')->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->first();
        // dd($result);
        if($tgl==substr($result->nextid,0,8)){
            $nextid=$result->nextid;        
        } else{
            $nextid=$tgl.'001';
        }
        return $nextid;
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

    public function data(Request $request){
        $barang = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->where('barcode', $request->barcode)->first();
        if($barang != null){
            $margin=$barang->harga_beli*$barang->keuntungan/100;
            $harga_jual=$barang->harga_beli+$margin;
            if($harga_jual<10000){
                $harga_jual=round($harga_jual,-2);
            }else{
                $harga_jual=round($harga_jual,-3);
            }
            $barang['harga_jual'] = $harga_jual;
        }
        
        return $barang;
    }

    public function store(Request $request)
    {
        // return $request;
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // return $request;
        // dd($request); die;
        if($request->kembali < 0){
            // return back()->with('error', 'Uang bayar kurang');
            return back()->withInput($request->only('id_pelanggan', 'bayar', 'kembali'))->with('error', 'Uang Bayar Kurang');
        } else {
            $penjualanBaru = new TransaksiPenjualan();
            // "select max(id)+1 as nextid from t_pembayaran where id like '".$tgl."%'"
            // dd(TransaksiPenjualan::select("id")->where('id', 'like', '%'. date('Ymd') . '%')->first()); die;

            $id = $this->NextId(date('Y-m-d'));
            // return $id;
            // if(TransaksiPenjualan::select("id")->where('id_perusahaan', auth()->user()->id_perusahaan)->where('id', 'like', '%'. date('Ymd') . '%')->first() == null){
                // $indexTransaksi = sprintf("%03d", 1);
            $penjualanBaru->id = $id;
            $penjualanBaru->tgl = date('Y-m-d');
            $penjualanBaru->id_pelanggan = $request->id_pelanggan;
            $penjualanBaru->total_harga = $this->checkPrice($request->total_harga);
            if($request->jenis_pembayaran == '1') {
                $penjualanBaru->total_bayar = $this->checkPrice($request->total_bayar);
                $penjualanBaru->sisa = 0;

            } else {
                $penjualanBaru->total_bayar = $this->checkPrice($request->dp);
                $penjualanBaru->sisa = $this->checkPrice($request->sisa);

            }
            $penjualanBaru->kembalian = $this->checkPrice($request->kembali);
            $penjualanBaru->dp = $this->checkPrice($request->dp);

            $penjualanBaru->jenis_pembayaran = $request->jenis_pembayaran;
            $penjualanBaru->id_user = auth()->user()->id;
            $penjualanBaru->id_perusahaan = auth()->user()->id_perusahaan;

            // $perusahaan = Perusahaan::select('level')->where('id', auth()->user()->id_perusahaan);
            $perusahaan = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();
            $limit = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('tgl', date('Y-m-d'))->count();
            // dd($limit); die;
            foreach($request->item as $barang){
                // dd($barang['discount']); die;
                $penjualanBaru->keuntungan += $barang['keuntungan'] * $barang['qty'];
                if($perusahaan->grade == 1) {
                    if($limit < 5 ) {
                        $penjualanBaru->save();
                        // return redirect()->route('list-transaksi.index')->with(['success' => 'Data Transaksi Penjualan Berhasil Disimpan']);
                    }else {
                        return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Naikan levelmu terlebih dahulu!']);
                    }
                } elseif($perusahaan->grade == 2) {
                    if($limit < 50 ) {
                        $penjualanBaru->save();
                        // return redirect()->route('list-transaksi.index')->with(['success' => 'Data Transaksi Penjualan Berhasil Disimpan']);
                    }else {
                        return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Naikan levelmu terlebih dahulu!']);
                    }
                } elseif($perusahaan->grade == 3) {
                    if($limit < 10000) {
                        $penjualanBaru->save();
                    // return redirect()->route('list-transaksi.index')->with(['success' => 'Data Transaksi Penjualan Berhasil Disimpan']);
                    }else {
                        return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Naikan levelmu terlebih dahulu!']);
                    }
                } 
                else{
                    return view('dashboard')->with(['error' => 'Laku kah?']);
                }
                // return $penjualanBaru;
                
                $detPenjualanBaru = new DetailPenjualan(); 
                $detPenjualanBaru->tgl = date('Y-m-d');
                $detPenjualanBaru->id_penjualan = $id;
                // return $detPenjualanBaru;
                $detPenjualanBaru->id_barang = $barang['id_barang'];
                $detPenjualanBaru->qty = $barang['qty'];
                if($barang['discount']){
                    $detPenjualanBaru->diskon = $barang['discount'];
                } else {
                    $detPenjualanBaru->diskon = 0;
                }
                $detPenjualanBaru->harga_beli = $barang['harga_beli'];
                $detPenjualanBaru->harga_jual = $barang['harga_jual'];
                $detPenjualanBaru->id_perusahaan =  $penjualanBaru->id_perusahaan;
                // return $detPenjualanBaru;
                $detPenjualanBaru->save();
                
                $barangUpdate = Barang::find($barang['id_barang']);
                $barangUpdate->stock -= $barang['qty'];
                $barangUpdate->update();
            }

            
            if($request->jenis_pembayaran == 1){
                $kasMasuk = new KasMasuk();
                $kasMasuk->tgl = now();
                $kasMasuk->jumlah = $this->checkPrice($request->total_harga); 
                $kasMasuk->id_user = auth()->user()->id;
                $kasMasuk->id_perusahaan = auth()->user()->id_perusahaan;
                $kasMasuk->keterangan = 'Transaksi Penjualan';
                $kasMasuk->save();
            } else if ($request->jenis_pembayaran == 2){
                $pembayaranBaru = new Piutang();
                $pembayaranBaru->id_penjualan = $id;
                $pembayaranBaru->tgl = date('Ymd');
                $pembayaranBaru->total_bayar = $this->checkPrice($request->dp);
                $pembayaranBaru->id_user = auth()->user()->id;
                $pembayaranBaru->id_perusahaan = auth()->user()->id_perusahaan;
                $pembayaranBaru->save();

                $kasMasuk = new KasMasuk();
                $kasMasuk->tgl = now();
                $kasMasuk->jumlah = $this->checkPrice($request->dp); 
                $kasMasuk->id_user = auth()->user()->id;
                $kasMasuk->id_perusahaan = auth()->user()->id_perusahaan;
                $kasMasuk->keterangan = 'DP Transaksi Penjualan';
                $kasMasuk->save();
            }
            // dd($penjualanBaru->id); die;
            if(auth()->user()->hak_akses == 'admin') {
                return redirect()->route('admin.list-transaksi.print_nota', $penjualanBaru->id)->with(['success' => 'Transaksi Berhasil!']);
                // return redirect()->route('admin.list-transaksi.index')->with(['success' => 'Transaksi Berhasil!']);
            }elseif(auth()->user()->hak_akses == 'kasir') {
                // return redirect()->route('kasir.list-transaksi.index')->with(['success' => 'Transaksi Berhasil!']);
                return redirect()->route('kasir.list-transaksi.print_nota', $penjualanBaru->id)->with(['success' => 'Transaksi Berhasil!']);
            }
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
