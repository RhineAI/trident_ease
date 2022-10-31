<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use App\Models\Barang;
use App\Models\KasMasuk;
use App\Models\Kategori;
use App\Models\KasKeluar;
use App\Models\Pelanggan;
use App\Models\Perusahaan;
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
    public function indexBestPelanggan(Request $request){
        // select count(DTP.id) from t_transaksi_penjualan TP right join t_detail_penjualan DTP on TP.id = DTP.id_penjualan group by id_pelanggan;
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');
        $now = date('Y-m-d');
        $kategori = $request->kategori;
        $merek = $request->merek;

        if ($request->has('tanggal_awal') && $request->tanggal_awal != $now && $request->has('tanggal_akhir') && $request->tanggal_akhir != "") {
            $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
            $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
            if($kategori == 'semua' && $merek == 'semua'){
                $condition = '';
            } else if ($kategori == 'semua' && $merek != 'semua'){
                $condition = 'b.merek, ' . $merek; 
            } else if ($kategori != 'semua' && $merek == 'semua'){
                $condition = 'b.kategori, ' . $kategori; 
            } else {
                $condition = "b.kategori == $kategori AND b.merek == $merek";
            }   
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

            $pelangganTerbaik = Pelanggan::leftJoin('t_transaksi_penjualan AS TP', 'TP.id_pelanggan', 't_pelanggan.id')->leftJoin('t_detail_penjualan AS DTP', 'DTP.id_penjualan', 'TP.id')->select('t_pelanggan.id AS id_pelanggan', 't_pelanggan.nama AS nama_pelanggan', 't_pelanggan.tlp AS tlp_pelanggan', 't_pelanggan.alamat AS alamat_pelanggan', DB::raw('sum(DTP.qty) as jumlahBeliBarang'), DB::raw('sum(DTP.qty*DTP.harga_jual) as jumlahBayarBarang'))->where('TP.id_perusahaan', auth()->user()->id_perusahaan)->groupBy('t_pelanggan.id')->orderBy('jumlahBayarBarang', 'DESC')->get();
            // return $pelangganTerbaik;

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
            // return $data;   

        }

        return datatables()
            ->of($data)
            ->rawColumns(['action', 'invoice'])
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
            ->rawColumns(['action'])
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


}
