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
use PDOException;

class TransaksiPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ambil semua data barang perusahaan yang sedang login dari database
        $data['barang'] = Barang::orderBy('nama')->where('id', auth()->user()->id_perusahaan)->get();

        // ambil semua data pelanggan perusahaan yang sedang login dari database
        $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();
        
        // ambil pelanggan pertama sebagai default customer 
        $data['pelangganUmum'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->first();    
        // ambil barang dengan stock lebih dari 0 dan sama dengan 1 untuk keperluan pengecekan   
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();    

        // ambil data perusahaan yang sedang login
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
   
        // return tampilan halaman form transaksi
        return view('transaksi-penjualan.index', $data);
    }

    // function untuk menentukan id dari transaksi yang akan diinput
    public function NextId($tgl){
        // Ubah format parameter tanggal menjadi tanpa tanda - 
        $pieces = explode("-",$tgl);
        $yy=$pieces[0]; 
        $mm=$pieces[1]; 
        $dd=$pieces[2]; 
        $tgl=$yy.$mm.$dd;
        
        // ambil id terakhir + 1 transaksi penjualan dari perusahaan yang sedang login
        $result= TransaksiPenjualan::where('tgl', $tgl)->select(DB::raw('max(id)+1 AS nextid'))->orderBy('id', 'DESC')->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->first();
        // return $result;
        // dd($tgl, substr($result->nextid, 0, 8));
        if($tgl==substr($result->nextid,0,8)){
            // jika tanggal parameter sama dengan tanggal yang ada pada id maka atur variabel nextid dengan properti nextid
            $nextid=$result->nextid; 
        } else{
            // if($tgl == $result->nextid) {

            // } else {
                // jika tidak sama maka ubah digit terakhir id dengan 001
                $nextid=$tgl.auth()->user()->id_perusahaan.'001';
            // }
        }

        // kembalikan nextid
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
        // ambil data barang dari database dengan kondisi sama dengan input barcode dari user
        $barang = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->where('barcode', $request->barcode)->first();
        if($barang != null){
            // hitung keuntungan abarang yang di input kemudian hitung harga_jual
            $margin=$barang->harga_beli*$barang->keuntungan/100;
            $harga_jual=$barang->harga_beli+$margin;
            if($harga_jual<10000){
                // jika harga jual kurang dari 10000 bulatkan harga jual keatas sebanyak 2 digit terakhir angka
                $harga_jual=round($harga_jual,-2);
            }else{
                // jika harga jual >= 10000 bulatkan harga jual keatas sebanyak 3 digit terakhir angka
                $harga_jual=round($harga_jual,-3);
            }
            // atur properti harga jual dengan harga jual yang sudah dibulatkan 
            $barang['harga_jual'] = $harga_jual;
        }
        
        return $barang;
    }

    public function store(Request $request)
    {
        // Set foreign key check menjadi 0 (tidak ada pengecekan)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::beginTransaction();
        try {
            // Pengecekan jika kembalian kurang dari 0
            if($request->kembali < 0){
                return back()->withInput($request->only('id_pelanggan', 'bayar', 'kembali'))->with('error', 'Uang Bayar Kurang');
            } else {
                // Membuat objek baru : TransaksiPenjualan
                $penjualanBaru = new TransaksiPenjualan();

                // Set invoice transaksi penjualan agar sesuai dengan tanggal di hari transaksi dilakukan
                $id = $this->NextId($request->tgl_transaksi);

                // Isi dari objek Transaksi Penjualan
                $penjualanBaru->id = $id;
                // $penjualanBaru->tgl = date('Y-m-d');
		        $penjualanBaru->tgl = $request->tgl_transaksi;
                $penjualanBaru->id_pelanggan = $request->id_pelanggan ? $request->id_pelanggan : 1;
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
                        if($limit < 10 ) {
                            $penjualanBaru->save();
                        }else {
                            return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Hubungi 08987554567']);
                        }
                    } elseif($perusahaan->grade == 2) {
                        // Mengecek apabila transaksi dari perusahaan tersebut sudah melebihi 50
                        if($limit < 200 ) {
                            $penjualanBaru->save();
                        }else {
                            return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Hubungi 08987554567']);
                        }
                    } elseif($perusahaan->grade == 3) {
                        $penjualanBaru->save();
                    } else{
                        return view('dashboard')->with(['error' => 'Laku kah?']);
                    }
                    // Mendeklarasikan variabel baru yang nantinya diisi oleh pembuatan objek baru
                    $detPenjualanBaru = new DetailPenjualan(); 
                    // $detPenjualanBaru->tgl = date('Y-m-d');
		            $detPenjualanBaru->tgl = $request->tgl_transaksi;
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
                    // $kasMasuk->tgl = now();
		            $kasMasuk->tgl = $request->tgl_transaksi;
                    $kasMasuk->jumlah = $this->checkPrice($request->total_harga); 
                    $kasMasuk->id_user = auth()->user()->id;
                    $kasMasuk->id_perusahaan = auth()->user()->id_perusahaan;
                    $kasMasuk->keterangan = 'Transaksi Penjualan';
                    $kasMasuk->save();
                } else if ($request->jenis_pembayaran == 2){
                    // Jika DP maka total uang pembayaran masuk akan terlebih dahulu masuk ke data Piutang
                    $pembayaranBaru = new Piutang();
                    $pembayaranBaru->id_penjualan = $id;
                    // $pembayaranBaru->tgl = date('Ymd');
		            $pembayaranBaru->tgl = $request->tgl_transaksi;
                    $pembayaranBaru->total_bayar = $this->checkPrice($request->dp);
                    $pembayaranBaru->id_user = auth()->user()->id;
                    $pembayaranBaru->id_perusahaan = auth()->user()->id_perusahaan;
                    $pembayaranBaru->save();

                    // Lalu total DP masuk akan masuk ke Kas Masuk 
                    $kasMasuk = new KasMasuk();
                    // $kasMasuk->tgl = now();
		            $kasMasuk->tgl = $request->tgl_transaksi;
                    $kasMasuk->jumlah = $this->checkPrice($request->dp); 
                    $kasMasuk->id_user = auth()->user()->id;
                    $kasMasuk->id_perusahaan = auth()->user()->id_perusahaan;
                    $kasMasuk->keterangan = 'DP Transaksi Penjualan';
                    $kasMasuk->save();
                }
                DB::commit();

                // return sesuai hak akses admin ataupun kasir
                if(auth()->user()->hak_akses == 'admin') {
                    return redirect()->route('admin.list-transaksi.print_nota', $penjualanBaru->id)->with(['success' => 'Transaksi Berhasil!']);
                }elseif(auth()->user()->hak_akses == 'kasir') {
                    return redirect()->route('kasir.list-transaksi.print_nota', $penjualanBaru->id)->with(['success' => 'Transaksi Berhasil!']);
                }
            }   
        } catch (QueryException | PDOException | Exception $error){
            DB::rollBack();
            return back()->with('error', 'Terjadi Kesalahan Server!'. $error->getMessage());
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
