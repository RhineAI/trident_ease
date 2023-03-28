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
use Illuminate\Support\Facades\Redirect;
// use Symfony\Component\Console\Input\Input;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;


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
        // Set foreign key check menjadi 0 (tidak ada pengecekan)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // try {
         
            // Pengecekan jika kembalian kurang dari 0
            if($request->kembali < 0){
                return back()->withInput($request->only('id_pelanggan', 'bayar', 'kembali'))->with('error', 'Uang Bayar Kurang');
            } else {
                // Membuat variabel baru yang diiisi dengan pembuatan object baru
                $penjualanBaru = new TransaksiPenjualan();

                // Set invoice transaksi penjualan agar sesuai dengan tanggal di hari transaksi dilakukan
                $id = $this->NextId(date('Y-m-d'));

                $penjualanBaru->id = $id;
                $penjualanBaru->tgl = date('Y-m-d');
                $penjualanBaru->id_pelanggan = $request->id_pelanggan;
                $penjualanBaru->total_harga = $this->checkPrice($request->total_harga);
                // Pengecekan apabila jenis pembayaran Cash / DP
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

                // Mengambil id perusahaan berdasarkan user yang sedang login
                $perusahaan = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();

                // Menghitung semua transaksi penjualan pada hari itu berdasarkan perusahaan yang sedang login
                $limit = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('tgl', date('Y-m-d'))->count();

                // Menyimpan data barang ke tabel detail barang
                foreach($request->item as $barang){
                    $penjualanBaru->keuntungan += $barang['keuntungan'] * $barang['qty'];

                    // Mengecek level perusahaan yang sedang login 
                    if($perusahaan->grade == 1) {
                        // Mengecek apabila transaksi dari perusahaan tersebut sudah melebihi 5
                        if($limit < 5 ) {
                            $penjualanBaru->save();
                        }else {
                            return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Naikan levelmu terlebih dahulu!']);
                        }
                    } elseif($perusahaan->grade == 2) {
                        // Mengecek apabila transaksi dari perusahaan tersebut sudah melebihi 50
                        if($limit < 50 ) {
                            $penjualanBaru->save();
                        }else {
                            return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Naikan levelmu terlebih dahulu!']);
                        }
                    } elseif($perusahaan->grade == 3) {
                        $penjualanBaru->save();
                    } else{
                        return view('dashboard')->with(['error' => 'Laku kah?']);
                    }
                    // Mendeklarasikan variabel baru yang nantinya diisi oleh pembuatan objek baru
                    $detPenjualanBaru = new DetailPenjualan(); 
                    $detPenjualanBaru->tgl = date('Y-m-d');
                    $detPenjualanBaru->id_penjualan = $id;
                    $detPenjualanBaru->id_barang = $barang['id_barang'];
                    $detPenjualanBaru->qty = $barang['qty'];
                    // Mengecek apakah ada diskon dari barang 
                    if($barang['discount']){
                        $detPenjualanBaru->diskon = $barang['discount'];
                    } else {
                        $detPenjualanBaru->diskon = 0;
                    }
                    $detPenjualanBaru->harga_beli = $barang['harga_beli'];
                    $detPenjualanBaru->harga_jual = $barang['harga_jual'];
                    $detPenjualanBaru->id_perusahaan =  $penjualanBaru->id_perusahaan;
                    $detPenjualanBaru->save();
                    
                    // Update stok di sistem sesuai barang yang dibeli
                    $barangUpdate = Barang::find($barang['id_barang']);
                    $barangUpdate->stock -= $barang['qty'];
                    $barangUpdate->update();
                }

                // Mengecek apakah jenis pembayaran merupakan Cash / DP
                if($request->jenis_pembayaran == 1){
                    // Jika Cash maka total uang pembayaran akan masuk ke Kas Masuk
                    $kasMasuk = new KasMasuk();
                    $kasMasuk->tgl = now();
                    $kasMasuk->jumlah = $this->checkPrice($request->total_harga); 
                    $kasMasuk->id_user = auth()->user()->id;
                    $kasMasuk->id_perusahaan = auth()->user()->id_perusahaan;
                    $kasMasuk->keterangan = 'Transaksi Penjualan';
                    $kasMasuk->save();
                } else if ($request->jenis_pembayaran == 2){
                    // Jika DP maka total uang pembayaran masuk akan terlebih dahulu masuk ke data Piutang
                    $pembayaranBaru = new Piutang();
                    $pembayaranBaru->id_penjualan = $id;
                    $pembayaranBaru->tgl = date('Ymd');
                    $pembayaranBaru->total_bayar = $this->checkPrice($request->dp);
                    $pembayaranBaru->id_user = auth()->user()->id;
                    $pembayaranBaru->id_perusahaan = auth()->user()->id_perusahaan;
                    $pembayaranBaru->save();

                    // Lalu total DP masuk akan masuk ke Kas Masuk 
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
            
        // } catch(QueryException | Exception | PDOException $e) {
        //     return redirect('/admin/list-pembelian')->with(['error' => ' data Transaksi ggagl!']);
        //     DB::rollBack();
        // }
        // DB::commit();     
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
