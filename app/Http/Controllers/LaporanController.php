<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Perusahaan;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
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

        // dd($data['bestPelanggan']); die;
        $data['kas-masuk'] = KasMasuk::select('*')->where('id', auth()->user()->id_perusahaan)->get();
        $data['kas-keluar'] = KasKeluar::select('*')->where('id', auth()->user()->id_perusahaan)->get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-pelanggan.index', $data, compact('tanggalAwal', 'tanggalAkhir', 'now'));
    }

    public function getDataBestPelanggan($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $penjualan = TransaksiPenjualan::where('tgl', 'Like', '%'.$tanggal.'%')
                                            ->leftJoin('t_pelanggan AS P', 'P.id', 't_transaksi_penjualan.id_pelanggan')
                                            ->select('t_transaksi_penjualan.*', 'P.nama AS nama_pelanggan')
                                            
                                            ->orderBy('id', 'desc')->get();
                                            // return $penjualan;

            foreach($penjualan as $item) {
                // return $item;
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['tgl'] = tanggal_indonesia($tanggal, false);
                $row['nama_pelanggan'] = $item->nama_pelanggan;
                $row['invoice'] = '<span class="badge badge-info">'. $item->id .'</span>';
                $row['total_harga'] = 'RP. '. format_uang($item->total_harga);
                
                $row['action'] = '<button class="btn btn-xs btn-secondary rounded delete"><i class="fa-solid fa-print"></i></button>';

                $data[] = $row;
            }         
            // return $data;   

        }

        return datatables()
            ->of($data)
            ->rawColumns(['action', 'invoice'])
            ->make(true);

        return $data;

    }

    public function PDFBestPelanggan($awal, $akhir)
    {

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
 
             $detPenjualan= DetailPenjualan::where('tgl', 'Like', '%'.$tanggal.'%')
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
             ->rawColumns(['kode'])
             ->make(true);
 
         return $data;
     }



     // LAPORAN STOK
     public function indexLaporanStok(Request $request)
     {   
       
        // return $barang;
        // return $request;
         $data['tanggal'] = date('Y-m-d');
         $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
         $tanggalAkhir = date('Y-m-d');
         $now = date('Y-m-d');
 
        //  if ($request->has('tanggal_awal') && $request->tanggal_awal != $now && $request->has('tanggal_akhir') && $request->tanggal_akhir != "") {
        //      $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
        //      $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
        //  } else {
        //      $tanggalAwal = date('Y-m-d', strtotime($now));
        //      $tanggalAkhir = date('Y-m-d', strtotime($now));
        //  }
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



     // LAPORAN Harian
     public function indexLaporanHarian(Request $request)
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
    
        return view('laporan.laporan-harian.index', compact('tanggalAwal', 'tanggalAkhir', 'now'))->with($data);
     }
}
