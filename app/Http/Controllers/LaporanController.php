<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use App\Models\Barang;
use App\Models\KasMasuk;
use App\Models\Kategori;
use App\Models\KasKeluar;
use App\Models\Pelanggan;
use App\Models\Perusahaan;
use App\Models\Hutang;
use App\Models\Piutang;
use App\Models\Penyesuaian;
use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use App\Models\DetailReturPenjualan;
// use App\Models\ReturPembelian;
use App\Models\TransaksiPenjualan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    // LAPORAN PELANGGAN TERBAIK
    public function indexBestPelanggan(Request $request){
        // select count(DTP.id) from t_transaksi_penjualan TP right join t_detail_penjualan DTP on TP.id = DTP.id_penjualan group by id_pelanggan;
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');
        $now = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != $now && $request->has('tanggal_akhir') && $request->tanggal_akhir != "") {
            $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
            $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
        } else {
            $tanggalAwal = date('Y-m-d', strtotime($now));
            $tanggalAkhir = date('Y-m-d', strtotime($now));
        }

        $data['bestPelanggan'] = TransaksiPenjualan::leftJoin('t_detail_penjualan AS DTP', 'DTP.id_penjualan', 't_transaksi_penjualan.id')->select('t_transaksi_penjualan.id_pelanggan', DB::raw('sum(qty) as jumlahBeliBarang'))->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->groupBy('t_transaksi_penjualan.id_pelanggan')->get();    
        // dd($data['bestPelanggan']); die;
        $data['transaksi'] = TransaksiPenjualan::select('*')->where('id', auth()->user()->id_perusahaan)->get();
        $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();  
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-pelanggan.index', $data, compact('tanggalAwal', 'tanggalAkhir', 'now'));
    }

    public function getDataBestPelanggan($awal, $akhir)
    {
        $no = 1;
        $data = array(); 

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $pelangganTerbaik = Pelanggan::leftJoin('t_transaksi_penjualan AS TP', 'TP.id_pelanggan', 't_pelanggan.id')->leftJoin('t_detail_penjualan AS DTP', 'DTP.id_penjualan', 'TP.id')->select('t_pelanggan.id AS id_pelanggan', 't_pelanggan.nama AS nama_pelanggan', 't_pelanggan.tlp AS tlp_pelanggan', 't_pelanggan.alamat AS alamat_pelanggan', DB::raw('sum(DTP.qty) as jumlahBeliBarang'), DB::raw('sum(DTP.qty*DTP.harga_jual) as jumlahBayarBarang'))->where('TP.id_perusahaan', auth()->user()->id_perusahaan)->groupBy('t_pelanggan.id')->orderBy('jumlahBayarBarang', 'DESC')->get();

            foreach($pelangganTerbaik as $item) {
                // return $key;
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['id_pelanggan'] = $item['id_pelanggan'];
                $row['nama_pelanggan'] = $item['nama_pelanggan'];
                $row['tlp_pelanggan'] = $item['tlp_pelanggan'];
                $row['alamat_pelanggan'] = $item['alamat_pelanggan'];
                $row['jumlahBeliBarang'] = $item['jumlahBeliBarang'];
                $row['jumlahBayarBarang'] = $item['jumlahBayarBarang'];

                $data[] = $row;
            }         

        }

        return datatables()
            ->of($data)
            ->rawColumns(['action'])
            ->make(true);

        return $data;

    }



    // LAPORAN Harian
    public function indexLaporanHarian(Request $request)
    {   
                            // return $detPembelian;
        $data['tanggal'] = date('Y-m-d');
        // return $kasMasuk;
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');
        $now = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != $now && $request->has('tanggal_akhir') && $request->tanggal_akhir != "") {
            $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
            $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
        } else {
            $tanggalAwal = date('Y-m-d', strtotime($now));
            $tanggalAkhir = date('Y-m-d', strtotime($now));
        }

        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        return view('laporan.laporan-harian.index', compact('tanggalAwal', 'tanggalAkhir', 'now'))->with($data);
    }


    // LAPORAN PEMBELIAN
    public function dataLaporanPembelian($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $detPembelian= DetailPembelian::where('t_detail_pembelian.tgl', 'Like','%$tanggal%')
                                        ->leftJoin('t_barang AS B', 'B.id', 't_detail_pembelian.id_barang')
                                        ->select('t_detail_pembelian.*', 'B.nama AS nama_barang', 'B.kode')    
                                        ->where('t_detail_pembelian.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'desc')->get();
    
            foreach($detPembelian as $item) {
                $row = array();
                $row['kode'] = '<span class="badge" style="background-color:#2f3d57; color:white;">'. $item->kode .'</span>';
                $row['nama_barang'] = $item->nama_barang ;
                $row['qty'] = $item->qty;
                $row['total_pembelian'] = 'Rp. '. format_uang($item->qty * $item->harga_beli);

                $data[] = $row;
            }         
        }

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['kode'])
            ->make(true);

        return $data;
    }



    // LAPORAN Retur Penjualan
    public function dataLaporanReturPenjualan($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $returPenjualan= DetailReturPenjualan::where('tgl', 'Like','%$tanggal%')
                                                ->leftJoin('t_barang AS B', 'B.id', 't_detail_retur_penjualan.id_barang')
                                                ->select('t_detail_retur_penjualan.*', 'B.nama AS nama_barang', 'B.kode')    
                                                ->where('t_detail_retur_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
                                                ->orderBy('id', 'desc')->get();
        
            foreach($returPenjualan as $item) {
                $row = array();
                $row['kode'] = '<span class="badge" style="background-color:#2f3d57; color:white;">'. $item->kode .'</span>';
                $row['nama_barang'] = $item->nama_barang ;
                $row['qty'] = $item->qty;
                $row['total_retur'] = 'Rp. '. format_uang($item->qty * $item->harga_jual);

                $data[] = $row;
            }         
        }

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['kode'])
            ->make(true);

        return $data;
    }

    // LAPORAN RETUR PEMBELIAN
    public function dataLaporanReturPembelian($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $returPembelian= ReturPembelian::where('t_retur_pembelian.tgl', 'Like','%$tanggal%')
                                            ->leftJoin('t_barang AS B', 'B.id', 't_retur_pembelian.id_barang')
                                            ->select('t_retur_pembelian.*', 'B.nama AS nama_barang', 'B.kode')    
                                            ->where('t_retur_pembelian.id_perusahaan', auth()->user()->id_perusahaan)
                                            ->orderBy('id', 'desc')->get();
        
            foreach($returPembelian as $item) {
                $row = array();
                $row['kode'] = '<span class="badge" style="background-color:#2f3d57; color:white;">'. $item->kode .'</span>';
                $row['nama_barang'] = $item->nama_barang ;
                $row['qty'] = $item->qty;
                $row['total_retur'] = 'Rp. '. format_uang($item->qty * $item->harga_beli);

                $data[] = $row;
            }         
        }

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['kode'])
            ->make(true);

        return $data;
    }



    // Laporan KAS
    public function indexLaporanKas(Request $request)
    {   
        $data['tanggal'] = date('Y-m-d');
        // $perusahaan = Perusahaan::select('id')->get();


        // return $kasMasuk;
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');
        $now = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != $now && $request->has('tanggal_akhir') && $request->tanggal_akhir != "") {
            $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
            $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
        } else {
            $tanggalAwal = date('Y-m-d', strtotime($now));
            $tanggalAkhir = date('Y-m-d', strtotime($now));
        }

        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
   
       return view('laporan.laporan-kas.index', compact('tanggalAwal', 'tanggalAkhir', 'now'))->with($data);
    }

    public function dataLaporanKasMasuk($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $kasMasuk= KasMasuk::where('tgl', 'Like', '%'.$tanggal.'%')
                                    ->leftJoin('t_users AS U', 'U.id', 't_kas_masuk.id_user')
                                    ->select('t_kas_masuk.*', 'U.nama AS nama_user')  
                                    ->where('t_kas_masuk.id_perusahaan', auth()->user()->id_perusahaan)
                                    ->orderBy('id', 'desc')->get();
            
            foreach($kasMasuk as $item) {
                // return $item;
                $row = array();
                // $row['DT_RowIndex'] = $no++;
                $row['tgl'] = tanggal_indonesia($tanggal, false);
                $row['jumlah'] = 'RP. '. format_uang($item->jumlah);
                $row['keterangan'] = $item->keterangan ;
                $row['oleh'] = ucfirst($item->nama_user) ;

                $data[] = $row;
            }         

        }

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['action', 'invoice'])
            ->make(true);

        return $data;
    }

    public function dataLaporanKasKeluar($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $kasKeluar= KasKeluar::where('tgl', 'Like', '%'.$tanggal.'%')
                                            // ->where('id_perusahaan', auth()->user()->id_perusahaan)
                                            ->leftJoin('t_users AS U', 'U.id', 't_kas_keluar.id_user')
                                            ->select('t_kas_keluar.*', 'U.nama AS nama_user')    
                                            ->where('t_kas_keluar.id_perusahaan', auth()->user()->id_perusahaan)
                                            ->orderBy('id', 'desc')->get();

            foreach($kasKeluar as $item) {
                // return $item;
                $row = array();
                // $row['DT_RowIndex'] = $no++;
                $row['tgl'] = tanggal_indonesia($tanggal, false);
                $row['jumlah'] = 'RP. '. format_uang($item->jumlah);
                $row['keperluan'] = $item->keperluan ;
                $row['oleh'] = ucfirst($item->nama_user) ;

                $data[] = $row;
            }         

        }

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['action', 'invoice'])
            ->make(true);

        return $data;
    }



    // LAPORAN PENJUALAN
     public function indexLaporanPenjualan(Request $request)
     {   
         $data['tanggal'] = date('Y-m-d');
         // return $kasMasuk;
         $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
         $tanggalAkhir = date('Y-m-d');
         $now = date('Y-m-d');
 
         if ($request->has('tanggal_awal') && $request->tanggal_awal != $now && $request->has('tanggal_akhir') && $request->tanggal_akhir != "") {
             $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
             $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
         } else {
             $tanggalAwal = date('Y-m-d', strtotime($now));
             $tanggalAkhir = date('Y-m-d', strtotime($now));
         }
 
         $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
    
        return view('laporan.laporan-penjualan.index', compact('tanggalAwal', 'tanggalAkhir', 'now'))->with($data);
     }
 
     public function dataLaporanPenjualan($awal, $akhir)
     {
         // return $awal;
         $no = 1;
         $data = array();
 
         while (strtotime($awal) <= strtotime($akhir)) {
             $tanggal = $awal;
             $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));
 
             $detPenjualan= DetailPenjualan::where('t_detail_penjualan.tgl', 'Like', '%'.$tanggal.'%')
                                            ->leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
                                            ->select('t_detail_penjualan.*', 'B.nama AS nama_barang', 'B.kode')    
                                            ->where('t_detail_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
                                            ->orderBy('id', 'desc')->get();
        
             foreach($detPenjualan as $item) {
                 $row = array();
                 $row['tgl'] = tanggal_indonesia($tanggal, false);
                 $row['kode'] = '<span class="badge" style="background-color:#2f3d57; color:white;">'. $item->kode .'</span>';
                 $row['nama_barang'] = $item->nama_barang ;
                 $row['qty'] = $item->qty;
                 $row['total_penjualan'] = 'Rp. '. format_uang($item->qty * $item->harga_jual);
                 $row['keuntungan'] = 'Rp. '. format_uang(($item->harga_jual - $item->harga_beli) * $item->qty);
 
                 $data[] = $row;
             }         
         }
 
         return datatables()
             ->of($data)
             ->addIndexColumn()
             ->rawColumns(['kode'])
             ->make(true);
 
         return $data;
     }



     // LAPORAN STOK
     public function indexLaporanStok(Request $request)
     {   
         $data['tanggal'] = date('Y-m-d');
         $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
         $tanggalAkhir = date('Y-m-d');
         $now = date('Y-m-d');
 
        $merek1st = Merek::select('*')->where('id_perusahaan', auth()->user()->id_perusahaan)->first();
        $kategori1st = Kategori::select('*')->where('id_perusahaan', auth()->user()->id_perusahaan)->first();
        $merek2nd = Merek::select('*')->where('id', $request->merek)->where('id_perusahaan', auth()->user()->id_perusahaan)->first();
        $kategori2nd = Kategori::select('*')->where('id', $request->kategori)->where('id_perusahaan', auth()->user()->id_perusahaan)->first();

        if ($request->has('merek') && $request->merek != '' && $request->has('kategori') && $request->kategori != '') {
            $data['merk'] = $request->merek;
            $data['category'] = $request->kategori;
            $nameMerk = $merek2nd->nama;
            $nameCategory = $kategori2nd->nama;
        } else {
            $data['merk'] = $merek1st->id;
            $data['category'] = $kategori1st->id;
            $nameMerk = $merek1st->nama;
            $nameCategory = $kategori1st->nama;
        }
 
         $data['merek'] = Merek::select('*')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();
         $data['kategori'] = Kategori::select('*')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();
         $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        //  return $data;
    
        return view('laporan.laporan-stok.index', compact('nameMerk','nameCategory','now'))->with($data);
     }
 
     public function dataLaporanStok($merek, $kategori)
     {
        //  return $merek;
         $no = 1;
         $data = array();
 
        //  while ($merek && $kategori != '') {
            //  $tanggal = $awal;
            //  $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));
 
            $barang = Barang::where('id_merek', $merek)
                            ->orWhere('id_kategori', $kategori)
                            ->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')
                            ->leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')
                            ->select('t_barang.*', 'M.nama AS nama_merek', 'K.nama AS nama_kategori')    
                            ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('kode', 'asc')->get();

        // return $barang;
             foreach($barang as $item) {
                 $row = array();
                 $row['kode'] = '<span class="badge" style="background-color:#2f3d57; color:white;">'. $item->kode .'</span>';
                 $row['nama_barang'] = $item->nama ;
                 $row['merek'] = $item->nama_merek;
                 $row['kategori'] = $item->nama_kategori;
                 $row['stock_minimal'] = $item->stock_minimal;
                 $row['stock_sekarang'] = $item->stock;
 
                 $data[] = $row;
             }         
            //  dd($data); die;
            // return $data;
        //  }
 
         return datatables()
             ->of($data)
             ->addIndexColumn()
             ->rawColumns(['kode'])
             ->make(true);
 
         return $data;
     }

     // LAPORAN KESESUAIAN STOK
     public function indexLaporanKesesuaianStok(Request $request){
        // select count(DTP.id) from t_transaksi_penjualan TP right join t_detail_penjualan DTP on TP.id = DTP.id_penjualan group by id_pelanggan;
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');
        // $kategori = $request->kategori;
        // $merek = $request->merek;
        $now = date('Y-m-d');
        // $condition = '';

        $merek1st = Merek::select('*')->where('id_perusahaan', auth()->user()->id_perusahaan)->first();
        $kategori1st = Kategori::select('*')->where('id_perusahaan', auth()->user()->id_perusahaan)->first();
        $merek2nd = Merek::select('*')->where('id', $request->merek)->where('id_perusahaan', auth()->user()->id_perusahaan)->first();
        $kategori2nd = Kategori::select('*')->where('id', $request->kategori)->where('id_perusahaan', auth()->user()->id_perusahaan)->first();

        if ($request->has('merek') && $request->merek != '' && $request->has('kategori') && $request->kategori != '' && $request->has('tanggal_awal') && $request->tanggal_awal != $now && $request->has('tanggal_akhir') && $request->tanggal_akhir != "") {
            $data['merk'] = $request->merek;
            $data['category'] = $request->kategori;
            $nameMerk = $merek2nd->nama;
            $nameCategory = $kategori2nd->nama;
            $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
            $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
        } else {
            $data['merk'] = $merek1st->id;
            $data['category'] = $kategori1st->id;
            $nameMerk = $merek1st->nama;
            $nameCategory = $kategori1st->nama;
            $tanggalAwal = date('Y-m-d', strtotime($now));
            $tanggalAkhir = date('Y-m-d', strtotime($now));
        }
 
        $data['merek'] = Merek::select('*')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();
        $data['kategori'] = Kategori::select('*')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();

        // $data['kesesuaianBarang'] = Penyesuaian::innerJoin('t_barang b', 'b.id', 't_penyesuaian.id_barang')->leftJoin('t_kategori k', 'k.id', 'b.id_kategori')->leftJoin('t_merek m', 'm.id', 'b.id_merek')->select('b.*', 'm.nama as nama_merek', 'k.nama as nama_kategori', 't_penyesuain.tgl', 't_penyesuain.stock_awal', 't_penyesuain.stock_baru')->where('id', auth()->user()->id_perusahaan)->where($condition)->orderBy('b.id')->orderBy('t_penyesuaian.tgl')->get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-kesesuaian-stok.index', $data, compact('nameMerk', 'nameCategory' ,'tanggalAwal', 'tanggalAkhir', 'now'));
    }
    
    public function dataLaporanKesesuaianStok($awal, $akhir, $merek, $kategori)
    {
        // return $awal;
        $no = 1;
        $data = array(); 
    
        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));
            // $condition = '';
            // if($kategori == 'semua' && $merek == 'semua'){
            //     $condition = '';
            // } else if ($kategori == 'semua' && $merek != 'semua'){
            //     $condition = 'b.merek, ' . $merek; 
            // } else if ($kategori != 'semua' && $merek == 'semua'){
            //     $condition = 'b.kategori, ' . $kategori; 
            // } else {
            //     $condition = "b.kategori == $kategori AND b.merek == $merek";
            // }
            
            $kesesuaianBarang = Penyesuaian::where('t_penyesuaian.tgl', 'LIKE', '%'.$tanggal.'%')
                                            ->where('id_merek', $merek)
                                            ->orWhere('id_kategori', $kategori)
                                            ->leftJoin('t_barang AS B', 'B.id', 't_penyesuaian.id_barang')
                                            ->leftJoin('t_kategori AS K', 'K.id', 'B.id_kategori')
                                            ->leftJoin('t_merek AS M', 'M.id', 'B.id_merek')
                                            ->select('B.*', 'M.nama AS nama_merek', 'K.nama AS nama_kategori', 't_penyesuaian.tgl', 't_penyesuaian.stock_awal', 't_penyesuaian.stock_baru')
                                            ->where('t_penyesuaian.id_perusahaan', auth()->user()->id_perusahaan)
                                            ->orderBy('id', 'DESC')->get();
            // return $kesesuaianBarang;
    
            foreach($kesesuaianBarang as $item) {
                // return $key;
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['kode'] = '<span class="badge" style="background-color:#2f3d57; color:white;">'. $item->kode .'</span>';
                $row['nama_barang'] = $item['nama'];
                $row['nama_merek'] = $item['nama_merek'];
                $row['nama_kategori'] = $item['nama_kategori'];
                $row['tgl'] = $item['tgl'];
                $row['stock_awal'] = $item['stock_awal'];
                $row['stock_baru'] = $item['stock_baru'];
                $row['selisih'] = $item['stock_awal'] - $item['stock_akhir'];
    
                $data[] = $row;
            }         
            // return $data;   
    
        }
    
        return datatables()
            ->of($data)
            ->rawColumns(['action'])
            ->make(true);
    
        return $data;
    
    }



    // LAPORAN HUTANG PIUTANG
    public function indexLaporaHutangPiutang(Request $request)
    {   
        $data['tanggal'] = date('Y-m-d');
        // $perusahaan = Perusahaan::select('id')->get();


        // return $kasMasuk;
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');
        $now = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != $now && $request->has('tanggal_akhir') && $request->tanggal_akhir != "") {
            $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
            $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
        } else {
            $tanggalAwal = date('Y-m-d', strtotime($now));
            $tanggalAkhir = date('Y-m-d', strtotime($now));
        }

        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
   
       return view('laporan.laporan-hutang-piutang.index', compact('tanggalAwal', 'tanggalAkhir', 'now'))->with($data);
    }

    public function dataLaporanHutang($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $hutang= Hutang::where('t_data_hutang.tgl', 'Like', '%'.$tanggal.'%')
                            ->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_data_hutang.id_pembelian')
                            ->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')
                            ->select('t_data_hutang.*', 'TP.kode_invoice', 'TP.sisa', 'S.nama AS nama_supplier')  
                            ->where('t_data_hutang.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'desc')->get();
            
            foreach($hutang as $item) {
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['no_pembelian'] = '<span class="badge" style="background-color:#2f3d57; color:white;">'. $item->kode_invoice .'</span>';
                $row['tgl'] = tanggal_indonesia($tanggal, false);
                $row['nama_supplier'] = $item->nama_supplier ;
                $row['total_bayar'] = 'Rp. '. format_uang($item->total_bayar );
                if ($item->sisa == 0) {
                    $row['status'] = '<span class="badge" style="background-color:#16c467; color:white;">Lunas</span>';
                } else {
                    $row['status'] = '<span class="badge badge-danger" color:white;">Belum Lunas</span>';
                }


                $data[] = $row;
            }         

        }

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['no_pembelian','status'])
            ->make(true);

        return $data;
    }

    public function dataLaporanPiutang($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $piutang= Piutang::where('t_data_piutang.tgl', 'Like', '%'.$tanggal.'%')
                            ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
                            ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
                            ->select('t_data_piutang.*', 'TP.kode_invoice', 'TP.sisa', 'P.nama AS nama_pelanggan')  
                            ->where('t_data_piutang.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'desc')->get();
            
            foreach($piutang as $item) {
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['no_penjualan'] = '<span class="badge" style="background-color:#2f3d57; color:white;">'. $item->kode_invoice .'</span>';
                $row['tgl'] = tanggal_indonesia($tanggal, false);
                $row['nama_pelanggan'] = $item->nama_pelanggan ;
                $row['total_bayar'] = 'Rp. '. format_uang($item->total_bayar );
                if ($item->sisa == 0) {
                    $row['status'] = '<span class="badge" style="background-color:#16c467; color:white;">Lunas</span>';
                } else {
                    $row['status'] = '<span class="badge badge-danger" color:white;">Belum Lunas</span>';
                }


                $data[] = $row;
            }         

        }

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['no_penjualan','status'])
            ->make(true);

        return $data;
    }
}
