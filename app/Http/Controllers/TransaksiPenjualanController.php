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

    public function store(Request $request)
    {
        // return $request;
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

        $kode = '';
        $date = (date('Ymd'));
        // return $date;
        if($penjualanBaru == NULL) {
            $kode_invoice = $date . '0001';
        } 
        else {
            $kode = sprintf($date.'%04d', intval(substr($penjualanBaru->kode, 8)) + 1);
            $kode_invoice = strval($kode);
        }

            $penjualanBaru->tgl = date('Y-m-d');
            $penjualanBaru->id_pelanggan = $request->id_pelanggan;
            $penjualanBaru->total_harga = $request->total_bayar;
            $penjualanBaru->kode_invoice = $kode_invoice;
            if($request->jenis_pembayaran == '1') {
                $penjualanBaru->total_bayar = $this->checkPrice($request->bayar);
                $penjualanBaru->sisa = 0;

            } else {
                $penjualanBaru->total_bayar = $this->checkPrice($request->dp);
                $penjualanBaru->sisa = $request->sisa;

            }
            $penjualanBaru->kembalian = $request->kembali;
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
                $penjualanBaru->keuntungan += $barang['keuntungan'];
                if($perusahaan->grade == 1) {
                    if($limit < 5 ) {
                        $penjualanBaru->save();
                        // return redirect()->route('list-transaksi.index')->with(['success' => 'Data Transaksi Penjualan Berhasil Disimpan']);
                    }else {
                        return redirect()->route('dashboard')->with(['error' => 'Sudah mencapai limit transaksi, Naikan levelmu terlebih!']);
                    }
                } elseif($perusahaan->grade == 2) {
                    if($limit < 50 ) {
                        $penjualanBaru->save();
                        // return redirect()->route('list-transaksi.index')->with(['success' => 'Data Transaksi Penjualan Berhasil Disimpan']);
                    }else {
                        return redirect()->route('dashboard')->with(['error' => 'Sudah mencapai limit transaksi, Naikan levelmu terlebih!']);
                    }
                } elseif($perusahaan->grade == 3) {
                    if($limit < 10000 ) {
                        $penjualanBaru->save();
                        // return redirect()->route('list-transaksi.index')->with(['success' => 'Data Transaksi Penjualan Berhasil Disimpan']);
                    }else {
                        return redirect()->route('dashboard')->with(['success' => 'Laku kah?']);
                    }
                } 
                else{
                    return redirect()->route('logout')->with(['error' => 'Lu siapa??']);
                }
         
                $detPenjualanBaru = new DetailPenjualan(); 
                $detPenjualanBaru->tgl = date('Y-m-d');
                $detPenjualanBaru->id_penjualan = $penjualanBaru->id;
                $detPenjualanBaru->id_barang = $barang['id_barang'];
                $detPenjualanBaru->qty = $barang['qty'];
                $detPenjualanBaru->diskon = $barang['discount'];
                $detPenjualanBaru->harga_beli = $barang['harga_beli'];
                $detPenjualanBaru->harga_jual = $barang['harga_jual'];
                $detPenjualanBaru->id_perusahaan = auth()->user()->id_perusahaan;
                $detPenjualanBaru->save();
            }

            $barangUpdate = Barang::find($barang['id_barang']);
            $barangUpdate->stock -= $barang['qty'];
            $barangUpdate->update();
            
            $pembayaranBaru = new Piutang();
            $pembayaranBaru->id_penjualan = $penjualanBaru->id;
            $pembayaranBaru->tgl = date('Ymd');
            if($request->jenis_pembayaran == 1){
                $pembayaranBaru->total_bayar = $this->checkPrice($request->bayar);
            } else if ($request->jenis_pembayaran == 2 ){
                $pembayaranBaru->total_bayar = $this->checkPrice($request->dp);
            }
            $pembayaranBaru->id_user = auth()->user()->id;
            $pembayaranBaru->id_perusahaan = auth()->user()->id_perusahaan;
            $pembayaranBaru->save();

            $kasMasuk = new KasMasuk();
            $kasMasuk->tgl = now();
            $kasMasuk->jumlah = $request->total_bayar; 
            $kasMasuk->id_user = auth()->user()->id;
            $kasMasuk->id_perusahaan = auth()->user()->id_perusahaan;
            $kasMasuk->keterangan = 'Transaksi Penjualan';
            $kasMasuk->save();

            // dd($penjualanBaru->id); die;


            return redirect()->route('list-transaksi.index')->with(['success' => 'Transaksi Berhasil!']);
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
