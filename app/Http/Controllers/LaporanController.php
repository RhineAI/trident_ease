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
use App\Models\ReturPenjualan;
use App\Models\ReturPembelian;
use App\Models\TransaksiPenjualan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class LaporanController extends Controller
{

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

        $detPenjualan = DetailPenjualan::leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
                                        ->select('t_detail_penjualan.*', 'B.nama AS nama_barang', 'B.kode')
                                        ->whereBetween('t_detail_penjualan.tgl', [$tanggalAwal, $tanggalAkhir])
                                        ->where('t_detail_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'asc')->get();
        $data['totalU'] = 0;
        $data['totalO'] = 0;
        foreach($detPenjualan as $item) {
            if($item->diskon != 0) {
                $countUntung = (($item->harga_jual - $item->harga_beli) * $item->qty) - ( ($item->harga_jual - $item->harga_beli) * $item->qty) * $item->diskon/100;
                $data['totalU'] += $countUntung;
            } else {
                $countUntung = ($item->harga_jual - $item->harga_beli) * $item->qty;
                $data['totalU'] += $countUntung;
            }
            $countOmset = $item->harga_jual * $item->qty;
            $data['totalO'] += $countOmset;
        }   
        
        $detPembelian= DetailPembelian::whereBetween('t_detail_pembelian.tgl', [$tanggalAwal, $tanggalAkhir])
                                        ->leftJoin('t_barang AS B', 'B.id', 't_detail_pembelian.id_barang')
                                        ->select('t_detail_pembelian.*', 'B.nama AS nama_barang', 'B.kode')    
                                        ->where('t_detail_pembelian.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'asc')->get();
        $data['totalBeli'] = 0; 
        foreach($detPembelian as $item) {
            if($item->diskon != 0) {
                $countOmset = ($item->harga_beli * $item->qty) - (($item->harga_beli * $item->qty) * $item->diskon/100);
                $data['totalBeli'] += $countOmset;
            } else {
                $countOmset = ($item->harga_beli * $item->qty);
                $data['totalBeli'] += $countOmset;
            }
        }   

        $returPenjualan = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')
                                    ->leftJoin('t_barang AS B', 'B.id', 'DRP.id_barang')
                                    ->whereBetween('t_retur_penjualan.tgl', [$tanggalAwal, $tanggalAkhir])
                                    ->select('DRP.*' ,'B.nama AS nama_barang', 'B.kode')    
                                    ->where('DRP.id_perusahaan', auth()->user()->id_perusahaan)
                                    ->orderBy('id', 'desc')->get();
        // return $returPenjualan;
        $data['totalReturPenjualan'] = 0;
        foreach($returPenjualan as $item) {
            $countReturJual = $item->harga_jual * $item->qty;
            $data['totalReturPenjualan'] += $countReturJual;
        }  

        $returPembelian = ReturPembelian::leftJoin('t_detail_retur_pembelian AS DRP', 'DRP.id_retur_pembelian', 't_retur_pembelian.id')
                                        ->leftJoin('t_barang AS B', 'B.id', 'DRP.id_barang')
                                        ->whereBetween('t_retur_pembelian.tgl', [$tanggalAwal, $tanggalAkhir])
                                        ->select('DRP.*' ,'B.nama AS nama_barang', 'B.kode')    
                                        ->where('DRP.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'desc')->get();
        $data['totalReturPembelian'] = 0;
        foreach($returPembelian as $item) {
            $countReturBeli = $item->harga_beli * $item->qty;
            $data['totalReturPembelian'] += $countReturBeli;
        }  

        $kasMasuk= KasMasuk::whereBetween('tgl', [$tanggalAwal, $tanggalAkhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_masuk.id_user')
                            ->select('t_kas_masuk.*', 'U.nama AS nama_user')  
                            ->where('t_kas_masuk.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $data['totalKasMasuk'] = 0;
        foreach($kasMasuk as $item) {
            $data['totalKasMasuk'] += $item->jumlah;
        }   

        $kasKeluar= KasKeluar::whereBetween('tgl', [$tanggalAwal, $tanggalAkhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_keluar.id_user')
                            ->select('t_kas_keluar.*', 'U.nama AS nama_user')    
                            ->where('t_kas_keluar.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $data['totalKasKeluar'] = 0;
        foreach($kasKeluar as $item) {
            $data['totalKasKeluar'] += $item->jumlah;
        } 

        $hutang= Hutang::whereBetween('t_data_hutang.tgl', [$tanggalAwal, $tanggalAkhir])
                        ->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_data_hutang.id_pembelian')
                        ->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')
                        ->select('t_data_hutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'S.nama AS nama_supplier')  
                        ->where('t_data_hutang.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('id', 'desc')->get();
        $data['totalHutang'] = 0;
        foreach($hutang as $item) {
            $data['totalHutang'] += $item->total_bayar;
        } 

        $piutang= Piutang::whereBetween('t_data_piutang.tgl', [$tanggalAwal, $tanggalAkhir])
                            ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
                            ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
                            ->select('t_data_piutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'P.nama AS nama_pelanggan')  
                            ->where('t_data_piutang.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'desc')->get();                       
        $data['totalPiutang'] = 0;
        foreach($piutang as $item) {
            $data['totalPiutang'] += $item->total_bayar;
        } 

        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        return view('laporan.laporan-harian.index', compact('tanggalAwal', 'tanggalAkhir', 'now'))->with($data);
    }

    public function DownloadHarian($awal, $akhir) 
    {
        $tglAwal = $awal;
        $tanggalAwal = $awal;
        $tanggalAkhir = $akhir;
        $no = 1;   
        
        $penjualan = DetailPenjualan::leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
                                        ->select('t_detail_penjualan.*', 'B.nama AS nama_barang', 'B.kode')
                                        ->whereBetween('t_detail_penjualan.tgl', [$tanggalAwal, $tanggalAkhir])
                                        ->where('t_detail_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'asc')->get();
        $totalU = 0;
        $totalO = 0;
        foreach($penjualan as $item) {
            if($item->diskon != 0) {
                $countUntung = (($item->harga_jual - $item->harga_beli) * $item->qty) - ( ($item->harga_jual - $item->harga_beli) * $item->qty) * $item->diskon/100;
                $totalU += $countUntung;
            } else {
                $countUntung = ($item->harga_jual - $item->harga_beli) * $item->qty;
                $totalU += $countUntung;
            }
            $countOmset = $item->harga_jual * $item->qty;
            $totalO += $countOmset;
        }   
        
        $pembelian= DetailPembelian::whereBetween('t_detail_pembelian.tgl', [$tanggalAwal, $tanggalAkhir])
                                        ->leftJoin('t_barang AS B', 'B.id', 't_detail_pembelian.id_barang')
                                        ->select('t_detail_pembelian.*', 'B.nama AS nama_barang', 'B.kode')    
                                        ->where('t_detail_pembelian.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'asc')->get();
        $totalBeli = 0; 
        foreach($pembelian as $item) {
            if($item->diskon != 0) {
                $countOmset = ($item->harga_beli * $item->qty) - (($item->harga_beli * $item->qty) * $item->diskon/100);
                $totalBeli += $countOmset;
            } else {
                $countOmset = ($item->harga_beli * $item->qty);
                $totalBeli += $countOmset;
            }
        }   

        $returPenjualan = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')
                                    ->leftJoin('t_barang AS B', 'B.id', 'DRP.id_barang')
                                    ->whereBetween('t_retur_penjualan.tgl', [$tanggalAwal, $tanggalAkhir])
                                    ->select('DRP.*' ,'B.nama AS nama_barang', 'B.kode')    
                                    ->where('DRP.id_perusahaan', auth()->user()->id_perusahaan)
                                    ->orderBy('id', 'desc')->get();
        // return $returPenjualan;
        $totalReturPenjualan = 0;
        foreach($returPenjualan as $item) {
            $countReturJual = $item->harga_jual * $item->qty;
            $totalReturPenjualan += $countReturJual;
        }  

        $returPembelian = ReturPembelian::leftJoin('t_detail_retur_pembelian AS DRP', 'DRP.id_retur_pembelian', 't_retur_pembelian.id')
                                        ->leftJoin('t_barang AS B', 'B.id', 'DRP.id_barang')
                                        ->whereBetween('t_retur_pembelian.tgl', [$tanggalAwal, $tanggalAkhir])
                                        ->select('DRP.*' ,'B.nama AS nama_barang', 'B.kode')    
                                        ->where('DRP.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'desc')->get();
        $totalReturPembelian = 0;
        foreach($returPembelian as $item) {
            $countReturBeli = $item->harga_beli * $item->qty;
            $totalReturPembelian += $countReturBeli;
        }  

        $kasMasuk= KasMasuk::whereBetween('tgl', [$tanggalAwal, $tanggalAkhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_masuk.id_user')
                            ->select('t_kas_masuk.*', 'U.nama AS nama_user')  
                            ->where('t_kas_masuk.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $totalKasMasuk = 0;
        foreach($kasMasuk as $item) {
            $totalKasMasuk += $item->jumlah;
        }   

        $kasKeluar= KasKeluar::whereBetween('tgl', [$tanggalAwal, $tanggalAkhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_keluar.id_user')
                            ->select('t_kas_keluar.*', 'U.nama AS nama_user')    
                            ->where('t_kas_keluar.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $totalKasKeluar = 0;
        foreach($kasKeluar as $item) {
            $totalKasKeluar += $item->jumlah;
        } 

        $hutang= Hutang::whereBetween('t_data_hutang.tgl', [$tanggalAwal, $tanggalAkhir])
                        ->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_data_hutang.id_pembelian')
                        ->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')
                        ->select('t_data_hutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'S.nama AS nama_supplier')  
                        ->where('t_data_hutang.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('id', 'desc')->get();
        $totalHutang = 0;
        foreach($hutang as $item) {
            $totalHutang += $item->total_bayar;
        } 

        $piutang= Piutang::whereBetween('t_data_piutang.tgl', [$tanggalAwal, $tanggalAkhir])
                            ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
                            ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
                            ->select('t_data_piutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'P.nama AS nama_pelanggan')  
                            ->where('t_data_piutang.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'desc')->get();                       
        $totalPiutang = 0;
        foreach($piutang as $item) {
            $totalPiutang += $item->total_bayar;
        } 

       

        // return $returPenjualan;
        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        // return $data;
        // return view('laporan.laporan-harian.pdf', compact('tglAwal' ,'awal', 'akhir', 'penjualan', 'pembelian', 'returPenjualan', 'returPembelian', 'hutang', 'piutang', 'kasMasuk', 'kasKeluar', 'cPerusahaan', 'totalU', 'totalO', 'totalBeli', 'totalReturPenjualan', 'totalReturPembelian', 'totalHutang', 'totalPiutang', 'totalKasMasuk', 'totalKasKeluar'));
        $pdf = PDF::loadView('laporan.laporan-harian.pdf', compact('tglAwal' ,'awal', 'akhir', 'penjualan', 'pembelian', 'returPenjualan', 'returPembelian', 'hutang', 'piutang', 'kasMasuk', 'kasKeluar', 'cPerusahaan', 'totalU', 'totalO', 'totalBeli', 'totalReturPenjualan', 'totalReturPembelian', 'totalHutang', 'totalPiutang', 'totalKasMasuk', 'totalKasKeluar'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Laporan Harian-'. $cPerusahaan->nama .' '. date('Y-m-d h.i.s') );
    }

    public function PrintPDFHarian($awal, $akhir)
    {
        $tglAwal = $awal;
        $no = 1;   

        $penjualan = DetailPenjualan::leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
                                        ->select('t_detail_penjualan.*', 'B.nama AS nama_barang', 'B.kode')
                                        ->whereBetween('t_detail_penjualan.tgl', [$awal, $akhir])
                                        ->where('t_detail_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'asc')->get();
        $data['totalU'] = 0;
        $data['totalO'] = 0;
        foreach($penjualan as $item) {
            if($item->diskon != 0) {
                $countUntung = (($item->harga_jual - $item->harga_beli) * $item->qty) - ( ($item->harga_jual - $item->harga_beli) * $item->qty) * $item->diskon/100;
                $data['totalU'] += $countUntung;
            } else {
                $countUntung = ($item->harga_jual - $item->harga_beli) * $item->qty;
                $data['totalU'] += $countUntung;
            }
            $countOmset = $item->harga_jual * $item->qty;
            $data['totalO'] += $countOmset;
        }   
        
        $pembelian= DetailPembelian::whereBetween('t_detail_pembelian.tgl', [$awal, $akhir])
                                        ->leftJoin('t_barang AS B', 'B.id', 't_detail_pembelian.id_barang')
                                        ->select('t_detail_pembelian.*', 'B.nama AS nama_barang', 'B.kode')    
                                        ->where('t_detail_pembelian.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'asc')->get();
        $data['totalBeli'] = 0; 
        foreach($pembelian as $item) {
            if($item->diskon != 0) {
                $countOmset = ($item->harga_beli * $item->qty) - (($item->harga_beli * $item->qty) * $item->diskon/100);
                $data['totalBeli'] += $countOmset;
            } else {
                $countOmset = ($item->harga_beli * $item->qty);
                $data['totalBeli'] += $countOmset;
            }
        }   

        $returPenjualan = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')
                                    ->leftJoin('t_barang AS B', 'B.id', 'DRP.id_barang')
                                    ->whereBetween('t_retur_penjualan.tgl', [$awal, $akhir])
                                    ->select('DRP.*' ,'B.nama AS nama_barang', 'B.kode')    
                                    ->where('DRP.id_perusahaan', auth()->user()->id_perusahaan)
                                    ->orderBy('id', 'desc')->get();
        // return $returPenjualan;
        $data['totalReturPenjualan'] = 0;
        foreach($returPenjualan as $item) {
            $countReturJual = $item->harga_jual * $item->qty;
            $data['totalReturPenjualan'] += $countReturJual;
        }  

        $returPembelian = ReturPembelian::leftJoin('t_detail_retur_pembelian AS DRP', 'DRP.id_retur_pembelian', 't_retur_pembelian.id')
                                        ->leftJoin('t_barang AS B', 'B.id', 'DRP.id_barang')
                                        ->whereBetween('t_retur_pembelian.tgl', [$awal, $akhir])
                                        ->select('DRP.*' ,'B.nama AS nama_barang', 'B.kode')    
                                        ->where('DRP.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'desc')->get();
        $data['totalReturPembelian'] = 0;
        foreach($returPembelian as $item) {
            $countReturBeli = $item->harga_beli * $item->qty;
            $data['totalReturPembelian'] += $countReturBeli;
        }  

        $kasMasuk= KasMasuk::whereBetween('tgl', [$awal, $akhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_masuk.id_user')
                            ->select('t_kas_masuk.*', 'U.nama AS nama_user')  
                            ->where('t_kas_masuk.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $data['totalKasMasuk'] = 0;
        foreach($kasMasuk as $item) {
            $data['totalKasMasuk'] += $item->jumlah;
        }   

        $kasKeluar= KasKeluar::whereBetween('tgl', [$awal, $akhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_keluar.id_user')
                            ->select('t_kas_keluar.*', 'U.nama AS nama_user')    
                            ->where('t_kas_keluar.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $data['totalKasKeluar'] = 0;
        foreach($kasKeluar as $item) {
            $data['totalKasKeluar'] += $item->jumlah;
        } 

        $hutang= Hutang::whereBetween('t_data_hutang.tgl', [$awal, $akhir])
                        ->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_data_hutang.id_pembelian')
                        ->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')
                        ->select('t_data_hutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'S.nama AS nama_supplier')  
                        ->where('t_data_hutang.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('id', 'desc')->get();
        $data['totalHutang'] = 0;
        foreach($hutang as $item) {
            $data['totalHutang'] += $item->total_bayar;
        } 

        $piutang= Piutang::whereBetween('t_data_piutang.tgl', [$awal, $akhir])
                            ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
                            ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
                            ->select('t_data_piutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'P.nama AS nama_pelanggan')  
                            ->where('t_data_piutang.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'desc')->get();  
                            // return $piutang;                     
        $data['totalPiutang'] = 0;
        foreach($piutang as $item) {
            $data['totalPiutang'] += $item->total_bayar;
        } 

        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-harian.print', compact('tglAwal' ,'awal', 'akhir', 'penjualan', 'pembelian', 'returPenjualan', 'returPembelian', 'hutang', 'piutang', 'kasMasuk', 'kasKeluar', 'cPerusahaan'))->with($data);
    }



     // LAPORAN PENJUALAN
    public function penjualan($awal, $akhir)
    {
    $data = array();
        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $detail = DetailPenjualan::where('t_detail_penjualan.tgl', 'Like', '%'.$tanggal.'%')
                                        ->leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
                                        ->select('t_detail_penjualan.*', 'B.nama AS nama_barang', 'B.kode')    
                                        ->where('t_detail_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'desc')->get();
            
            foreach($detail as $item) {
            $row = array();
            $row['tgl'] = tanggal_indonesia($tanggal, false);
            $row['kode'] = '<span class="badge" style="background-color:#2f3d57; color:white;">'. $item->kode .'</span>';
            $row['nama_barang'] = $item->nama_barang ;
            $row['qty'] = $item->qty;
            $row['total_penjualan'] = 'Rp. '. format_uang($item->qty * $item->harga_jual);
            $countUntung = (($item->harga_jual - $item->harga_beli) * $item->qty) - ( ($item->harga_jual - $item->harga_beli) * $item->qty) * $item->diskon/100;

            $row['keuntungan'] = 'Rp. '. format_uang($countUntung); 
            $data[] = $row; 
        }
        }
        return $data;
    }

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

        $detPenjualan = DetailPenjualan::leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
                                        ->select('t_detail_penjualan.*', 'B.nama AS nama_barang', 'B.kode')
                                        ->whereBetween('t_detail_penjualan.tgl', [$tanggalAwal, $tanggalAkhir])
                                        ->where('t_detail_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'asc')->get();
        $totalU = 0;
        $totalO = 0;
        foreach($detPenjualan as $item) {
            if($item->diskon != 0) {
                $countUntung = (($item->harga_jual - $item->harga_beli) * $item->qty) - ( ($item->harga_jual - $item->harga_beli) * $item->qty) * $item->diskon/100;
                $totalU += $countUntung;
            } else {
                $countUntung = ($item->harga_jual - $item->harga_beli) * $item->qty;
                $totalU += $countUntung;
            }
            $countOmset = $item->harga_jual * $item->qty;
            $totalO += $countOmset;
        }       

        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-penjualan.index', compact('tanggalAwal', 'tanggalAkhir', 'now', 'detPenjualan', 'totalU', 'totalO'))->with($data);
    }
  

    public function dataLaporanPenjualan($awal, $akhir) 
    {
        $data = $this->penjualan($awal, $akhir);
        // return view('laporan.laporan-penjualan.index', compact('data'));
        return datatables()
                ->of($data)
                ->addIndexColumn()
                ->rawColumns(['kode'])
                ->make(true);
    }

 
    public function DownloadPenjualan($awal, $akhir) 
    {
        $detPenjualan = DetailPenjualan::leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
                                        ->select('t_detail_penjualan.*', 'B.nama AS nama_barang', 'B.kode')
                                        ->whereBetween('t_detail_penjualan.tgl', [$awal, $akhir])
                                        ->where('t_detail_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'asc')->get();
        $totalU = 0;
        $totalO = 0;
        $no = 0;

        foreach($detPenjualan as $item) {
        if($item->diskon != 0) {
            $countUntung = (($item->harga_jual - $item->harga_beli) * $item->qty) - ( ($item->harga_jual - $item->harga_beli) * $item->qty) * $item->diskon/100;
            $totalU += $countUntung;
        } else {
            $countUntung = ($item->harga_jual - $item->harga_beli) * $item->qty;
            $totalU += $countUntung;
        }
            $countOmset = $item->harga_jual * $item->qty;
            $totalO += $countOmset;
        }   

        $tglAwal = $awal;

        // while (strtotime($awal) <= strtotime($akhir)) {
        //     $tanggal = $awal;
        //     $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

        //     $detPenjualan= DetailPenjualan::where('t_detail_penjualan.tgl', 'Like', '%'.$tanggal.'%')
        //                                 ->leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
        //                                 ->select('t_detail_penjualan.*', 'B.nama AS nama_barang', 'B.kode')    
        //                                 ->where('t_detail_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
        //                                 ->orderBy('id', 'desc')->get();
    
        //     foreach($detPenjualan as $item) {
        //         $row = array();
        //         $row['tgl'] = tanggal_indonesia($tanggal, false);
        //         $row['kode'] = $item->kode;
        //         $row['nama_barang'] = $item->nama_barang ;
        //         $row['qty'] = $item->qty;
        //         $row['total_penjualan'] = 'Rp. '. format_uang($item->qty * $item->harga_jual);
        //         $row['keuntungan'] = 'Rp. '. format_uang(($item->harga_jual - $item->harga_beli) * $item->qty);

        //         $penjualan[] = $row;
        //     }         
        // }
        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();


        // return $data;
        // return view('laporan.laporan-penjualan.pdf', compact('tglAwal' ,'awal', 'akhir', 'penjualan', 'cPerusahaan'));
        $pdf = PDF::loadView('laporan.laporan-penjualan.pdf', compact('no', 'totalO', 'totalU','tglAwal', 'awal', 'akhir', 'cPerusahaan', 'detPenjualan'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Laporan Penjualan-'. $cPerusahaan->nama .' '. date('Y-m-d-h.i.s') );
    }

    public function PrintPDFPenjualan($awal, $akhir) 
    {
        $tglAwal = $awal;
        $detPenjualan = DetailPenjualan::leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
                                ->select('t_detail_penjualan.*', 'B.nama AS nama_barang', 'B.kode')
                                ->whereBetween('t_detail_penjualan.tgl', [$awal, $akhir])
                                ->where('t_detail_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
                                ->orderBy('id', 'asc')->get();
        $data['no'] = 0;
        $data['totalU'] = 0;
        $data['totalO'] = 0;
        foreach($detPenjualan as $item) {
            if($item->diskon != 0) {
                $countUntung = (($item->harga_jual - $item->harga_beli) * $item->qty) - ( ($item->harga_jual - $item->harga_beli) * $item->qty) * $item->diskon/100;
                $data['totalU'] += $countUntung;
            } else {
                $countUntung = ($item->harga_jual - $item->harga_beli) * $item->qty;
                $data['totalU'] += $countUntung;
            }
            $countOmset = $item->harga_jual * $item->qty;
            $data['totalO'] += $countOmset;
        }   

        $tglAwal = $awal;

        // while (strtotime($awal) <= strtotime($akhir)) {
        //     $tanggal = $awal;
        //     $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

        //     $detPenjualan= DetailPenjualan::where('t_detail_penjualan.tgl', 'Like', '%'.$tanggal.'%')
        //                                 ->leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
        //                                 ->select('t_detail_penjualan.*', 'B.nama AS nama_barang', 'B.kode')    
        //                                 ->where('t_detail_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
        //                                 ->orderBy('id', 'desc')->get();
    
        //     foreach($detPenjualan as $item) {
        //         $row = array();
        //         $row['tgl'] = tanggal_indonesia($tanggal, false);
        //         $row['kode'] = $item->kode;
        //         $row['nama_barang'] = $item->nama_barang ;
        //         $row['qty'] = $item->qty;
        //         $row['total_penjualan'] = 'Rp. '. format_uang($item->qty * $item->harga_jual);
        //         $row['keuntungan'] = 'Rp. '. format_uang(($item->harga_jual - $item->harga_beli) * $item->qty);

        //         $penjualan[] = $row;
        //     }         
        // }

        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-penjualan.print', compact('detPenjualan' ,'tglAwal' ,'awal', 'akhir', 'cPerusahaan'))->with($data);
    }
 


    // LAPORAN PEMBELIAN
    public function indexLaporanPembelian(Request $request)
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

            $detPembelian= DetailPembelian::whereBetween('t_detail_pembelian.tgl', [$tanggalAwal, $tanggalAkhir])
                                        ->leftJoin('t_barang AS B', 'B.id', 't_detail_pembelian.id_barang')
                                        ->select('t_detail_pembelian.*', 'B.nama AS nama_barang', 'B.kode')    
                                        ->where('t_detail_pembelian.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'asc')->get(); 
        $totalBeli = 0;
        $no = 0;

        foreach($detPembelian as $item) {
            if($item->diskon != 0) {
                $countOmset = ($item->harga_beli * $item->qty) - (($item->harga_beli * $item->qty) * $item->diskon/100);
                $totalBeli += $countOmset;
            } else {
                $countOmset = ($item->harga_beli * $item->qty);
                $totalBeli += $countOmset;
            }
        }   
            
         $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
 
         return view('laporan.laporan-pembelian.index', compact('tanggalAwal', 'tanggalAkhir', 'now', 'totalBeli', 'detPembelian'))->with($data);
    }

    public function pembelian($awal, $akhir)
    {
        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $detPembelian= DetailPembelian::where('t_detail_pembelian.tgl', 'Like','%'.$tanggal.'%')
                                        ->leftJoin('t_barang AS B', 'B.id', 't_detail_pembelian.id_barang')
                                        ->select('t_detail_pembelian.*', 'B.nama AS nama_barang', 'B.kode')    
                                        ->where('t_detail_pembelian.id_perusahaan', auth()->user()->id_perusahaan)
                                        ->orderBy('id', 'desc')->get();

            foreach($detPembelian as $item) {
                $row = array();
                $row['tgl'] = tanggal_indonesia($item->tgl, false) ;
                $row['kode'] = '<span class="badge" style="background-color:#2f3d57; color:white;">'. $item->kode .'</span>';
                $row['nama_barang'] = $item->nama_barang ;
                $row['qty'] = $item->qty;
                if($item->diskon != 0) {
                    $totalBeli= 'Rp.' . format_uang($item->qty * $item->harga_beli - (($item->qty * $item->harga_beli) * $item->diskon/100));
                } else {
                    $totalBeli= 'Rp. '. format_uang($item->qty * $item->harga_beli);
                }
                $row['total_pembelian'] = $totalBeli;

                $data[] = $row;
            }         
        }
        return $data;
    }

    public function dataLaporanPembelian($awal, $akhir)
    {
        $data = $this->pembelian($awal, $akhir);

        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->rawColumns(['kode'])
        ->make(true);
    }

    public function DownloadPembelian($awal, $akhir) 
    {
        $detPembelian = DetailPembelian::leftJoin('t_barang AS B', 'B.id', 't_detail_pembelian.id_barang')
                                                ->select('t_detail_pembelian.*', 'B.nama AS nama_barang', 'B.kode')
                                                ->whereBetween('t_detail_pembelian.tgl', [$awal, $akhir])
                                                ->where('t_detail_pembelian.id_perusahaan', auth()->user()->id_perusahaan)
                                                ->orderBy('id', 'asc')->get();
        $totalBeli = 0;
        $no = 0;

        foreach($detPembelian as $item) {
            if($item->diskon != 0) {
                $countOmset = ($item->harga_beli * $item->qty) - (($item->harga_beli * $item->qty) * $item->diskon/100);
                $totalBeli += $countOmset;
            } else {
                $countOmset = ($item->harga_beli * $item->qty);
                $totalBeli += $countOmset;
            }
        }   

        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        $tglAwal = $awal;

        // return $data;
        // return view('laporan.laporan-pembelian.pdf', compact('tglAwal' ,'awal', 'akhir', 'cPerusahaan'))->with($data);
        $pdf = PDF::loadView('laporan.laporan-pembelian.pdf', compact('totalBeli' ,'no' ,'tglAwal', 'awal', 'akhir', 'cPerusahaan', 'detPembelian'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Laporan Pembelian-'. $cPerusahaan->nama .' '. date('Y-m-d-h.i.s') );
    }

    public function PrintPDFPembelian($awal, $akhir) 
    {
        $data['detPembelian'] = DetailPembelian::leftJoin('t_barang AS B', 'B.id', 't_detail_pembelian.id_barang')
                                                ->select('t_detail_pembelian.*', 'B.nama AS nama_barang', 'B.kode')
                                                ->whereBetween('t_detail_pembelian.tgl', [$awal, $akhir])
                                                ->where('t_detail_pembelian.id_perusahaan', auth()->user()->id_perusahaan)
                                                ->orderBy('id', 'asc')->get();
        $data['totalBeli'] = 0;
        $data['no'] = 0;

        foreach($data['detPembelian'] as $item) {
            if($item->diskon != 0) {
                $countOmset = ($item->harga_beli * $item->qty) - (($item->harga_beli * $item->qty) * $item->diskon/100);
                $data['totalBeli'] += $countOmset;
            } else {
                $countOmset = ($item->harga_beli * $item->qty);
                $data['totalBeli'] += $countOmset;
            }
        }   
        $tglAwal = $awal;

        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-pembelian.print', compact('tglAwal' ,'awal', 'akhir', 'cPerusahaan'))->with($data);
    }





    // LAPORAN RETUR 
    public function returPembelian($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $returPembelian = ReturPembelian::leftJoin('t_detail_retur_pembelian AS DRP', 'DRP.id_retur_pembelian', 't_retur_pembelian.id')
                                            ->leftJoin('t_barang AS B', 'B.id', 'DRP.id_barang')
                                            ->where('t_retur_pembelian.tgl', 'LIKE', '%'.$tanggal.'%')
                                            ->select('DRP.*' ,'B.nama AS nama_barang', 'B.kode')    
                                            ->where('DRP.id_perusahaan', auth()->user()->id_perusahaan)
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

        return $data;
    }

    public function dataLaporanReturPembelian($awal, $akhir)
    {
        $data = $this->returPembelian($awal, $akhir);

        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->rawColumns(['kode'])
        ->make(true);

    }


    public function returPenjualan($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $returPenjualan = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')
                                                ->leftJoin('t_barang AS B', 'B.id', 'DRP.id_barang')
                                                ->where('t_retur_penjualan.tgl', 'LIKE', '%'.$tanggal.'%')
                                                ->select('DRP.*' ,'B.nama AS nama_barang', 'B.kode')    
                                                ->where('DRP.id_perusahaan', auth()->user()->id_perusahaan)
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

        return $data;
    }

    public function dataLaporanReturPenjualan($awal, $akhir)
    {
        $data = $this->returPenjualan($awal, $akhir);

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['kode'])
            ->make(true);
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

        $kasMasuk= KasMasuk::whereBetween('tgl', [$tanggalAwal, $tanggalAkhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_masuk.id_user')
                            ->select('t_kas_masuk.*', 'U.nama AS nama_user')  
                            ->where('t_kas_masuk.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $totalKasMasuk = 0;
        foreach($kasMasuk as $item) {
            $totalKasMasuk += $item->jumlah;
        }   

        $kasKeluar= KasKeluar::whereBetween('tgl', [$tanggalAwal, $tanggalAkhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_keluar.id_user')
                            ->select('t_kas_keluar.*', 'U.nama AS nama_user')    
                            ->where('t_kas_keluar.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $totalKasKeluar = 0;
        foreach($kasKeluar as $item) {
            $totalKasKeluar += $item->jumlah;
        }    

        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
   
       return view('laporan.laporan-kas.index', compact('tanggalAwal', 'tanggalAkhir', 'now', 'kasMasuk', 'kasKeluar', 'totalKasMasuk', 'totalKasKeluar'))->with($data);
    }

    public function kasMasuk($awal, $akhir)
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
        return $data;
    }

    public function dataLaporanKasMasuk($awal, $akhir)
    {
        $data = $this->kasMasuk($awal, $akhir);
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function kasKeluar($awal, $akhir)
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
        return $data;

    }

    public function dataLaporanKasKeluar($awal, $akhir) 
    {
        $data = $this->kasKeluar($awal, $akhir);

        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function DownloadKas($awal, $akhir) 
    {
        // $kas_masuk = $this->kasMasuk($awal, $akhir);
        // $kas_keluar = $this->kasKeluar($awal, $akhir);
        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $tglAwal = $awal;

        $kasMasuk= KasMasuk::whereBetween('tgl', [$awal, $akhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_masuk.id_user')
                            ->select('t_kas_masuk.*', 'U.nama AS nama_user')  
                            ->where('t_kas_masuk.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $totalKasMasuk = 0;
        foreach($kasMasuk as $item) {
            $totalKasMasuk += $item->jumlah;
        }   

        $kasKeluar= KasKeluar::whereBetween('tgl', [$awal, $akhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_keluar.id_user')
                            ->select('t_kas_keluar.*', 'U.nama AS nama_user')    
                            ->where('t_kas_keluar.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $totalKasKeluar = 0;
        foreach($kasKeluar as $item) {
            $totalKasKeluar += $item->jumlah;
        } 

        // return $data;
        // return view('laporan.laporan-kas.pdf', compact('totalKasMasuk', 'totalKasKeluar', 'tglAwal' ,'awal', 'akhir', 'kasMasuk', 'kasKeluar', 'cPerusahaan'));
        $pdf = PDF::loadView('laporan.laporan-kas.pdf', compact('totalKasMasuk', 'totalKasKeluar','tglAwal', 'awal', 'akhir', 'kasMasuk', 'kasKeluar', 'cPerusahaan'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Laporan KAS-'. $cPerusahaan->nama .' '. date('Y-m-d h.i.s') );
    }

    public function PrintPDFKas($awal, $akhir) 
    {
        // $kasMasuk = $this->kasMasuk($awal, $akhir);
        // $kasKeluar = $this->kasKeluar($awal, $akhir);
        $kasMasuk= KasMasuk::whereBetween('tgl', [$awal, $akhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_masuk.id_user')
                            ->select('t_kas_masuk.*', 'U.nama AS nama_user')  
                            ->where('t_kas_masuk.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $totalKasMasuk = 0;
        foreach($kasMasuk as $item) {
            $totalKasMasuk += $item->jumlah;
        }   

        $kasKeluar= KasKeluar::whereBetween('tgl', [$awal, $akhir])
                            ->leftJoin('t_users AS U', 'U.id', 't_kas_keluar.id_user')
                            ->select('t_kas_keluar.*', 'U.nama AS nama_user')    
                            ->where('t_kas_keluar.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('id', 'asc')->get();
        $totalKasKeluar = 0;
        foreach($kasKeluar as $item) {
            $totalKasKeluar += $item->jumlah;
        } 
        $tglAwal = $awal;
        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        return view('laporan.laporan-kas.print', compact('tglAwal' ,'awal', 'akhir', 'totalKasMasuk', 'totalKasKeluar', 'kasMasuk','kasKeluar', 'cPerusahaan'));
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

        return view('laporan.laporan-stok.index', compact('nameMerk','nameCategory','now'))->with($data);
    }
 
    public function stok($merek, $kategori)
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
        return $data;
    }

    public function dataLaporanStok($merek, $kategori) 
    {
        $data = $this->stok($merek, $kategori);

        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->rawColumns(['kode'])
        ->make(true);
    }

    public function DownloadStok($merek, $kategori) 
    {
        $stok = array();
        $barang = Barang::where('id_merek', $merek)
                        ->orWhere('id_kategori', $kategori)
                        ->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')
                        ->leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')
                        ->select('t_barang.*', 'M.nama AS nama_merek', 'K.nama AS nama_kategori')    
                        ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('kode', 'asc')->get();

            foreach($barang as $item) {
                $row = array();
                $row['kode'] = $item->kode;
                $row['nama_barang'] = $item->nama ;
                $row['merek'] = $item->nama_merek;
                $row['kategori'] = $item->nama_kategori;
                $row['stock_minimal'] = $item->stock_minimal;
                $row['stock_sekarang'] = $item->stock;

                $stok[] = $row;
            }  

        $merk = Merek::where('id', $merek)->first();
        $category = Kategori::where('id', $kategori)->first();
        // return $category;
        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        // return $data;
        // return view('laporan.laporan-stok.pdf', compact('stok','merek', 'kategori', 'merk', 'category', 'cPerusahaan'));
        $pdf = PDF::loadView('laporan.laporan-stok.pdf', compact('merek', 'kategori', 'merk', 'category', 'stok', 'cPerusahaan'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Laporan Stok-'. $cPerusahaan->nama .' '. date('Y-m-d h.i.s') );
    }

    public function PrintPDFStok($merek, $kategori) 
    {
        $stok = array();
        $barang = Barang::where('id_merek', $merek)
                        ->orWhere('id_kategori', $kategori)
                        ->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')
                        ->leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')
                        ->select('t_barang.*', 'M.nama AS nama_merek', 'K.nama AS nama_kategori')    
                        ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('kode', 'asc')->get();

            foreach($barang as $item) {
                $row = array();
                $row['kode'] = $item->kode;
                $row['nama_barang'] = $item->nama ;
                $row['merek'] = $item->nama_merek;
                $row['kategori'] = $item->nama_kategori;
                $row['stock_minimal'] = $item->stock_minimal;
                $row['stock_sekarang'] = $item->stock;

                $stok[] = $row;
            }  

        $merk = Merek::where('id', $merek)->first();
        $category = Kategori::where('id', $kategori)->first();
        // return $category;
        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-stok.print', compact('stok', 'merk', 'category', 'cPerusahaan'));
    }
     

    

     // LAPORAN KESESUAIAN STOK
    public function indexLaporanKesesuaianStok(Request $request)
    {
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
    
    public function kesesuaianStok($awal, $akhir, $merek, $kategori)
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
                                            ->orWhere('id_merek', $merek)
                                            ->orWhere('id_kategori', $kategori)
                                            ->leftJoin('t_barang AS B', 'B.id', 't_penyesuaian.id_barang')
                                            ->leftJoin('t_kategori AS K', 'K.id', 'B.id_kategori')
                                            ->leftJoin('t_merek AS M', 'M.id', 'B.id_merek')
                                            ->select('B.*', 'M.nama AS nama_merek', 'K.nama AS nama_kategori', 't_penyesuaian.tgl', 't_penyesuaian.stock_awal', 't_penyesuaian.stock_baru')
                                            ->where('t_penyesuaian.id_perusahaan', auth()->user()->id_perusahaan)
                                            ->orderBy('id', 'DESC')->get();
    
            foreach($kesesuaianBarang as $item) {
                // return $key;
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['kode'] = '<span class="badge" style="background-color:#2f3d57; color:white;">'. $item->kode .'</span>';
                $row['nama_barang'] = $item['nama'];
                $row['merek'] = $item['nama_merek'];
                $row['kategori'] = $item['nama_kategori'];
                // $row['tgl'] = $item['tgl'];
                $row['stock_awal'] = $item['stock_awal'];
                $row['stock_baru'] = $item['stock_baru'];
                $row['selisih'] = $item['stock_awal'] - $item['stock_baru'];
    
                $data[] = $row;
            }             
        }
    
        return $data;
    
    }

    public function dataLaporanKesesuaianStok($awal, $akhir, $merek, $kategori)
    {
        $data = $this->kesesuaianStok($awal, $akhir, $merek, $kategori);
          
        return datatables()
            ->of($data)
            ->rawColumns(['kode'])
            ->make(true);
    }

    public function DownloadKesesuaianStok($awal, $akhir,  $merek, $kategori) 
    {
        $no = 1;
        $kesesuaian_stok = array(); 
        $tglAwal = $awal;
        $akhir = $akhir;
    
        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));
            
            $kesesuaianBarang = Penyesuaian::where('t_penyesuaian.tgl', 'LIKE', '%'.$tanggal.'%')
                                            ->orWhere('id_merek', $merek)
                                            ->orWhere('id_kategori', $kategori)
                                            ->leftJoin('t_barang AS B', 'B.id', 't_penyesuaian.id_barang')
                                            ->leftJoin('t_kategori AS K', 'K.id', 'B.id_kategori')
                                            ->leftJoin('t_merek AS M', 'M.id', 'B.id_merek')
                                            ->select('B.*', 'M.nama AS nama_merek', 'K.nama AS nama_kategori', 't_penyesuaian.tgl', 't_penyesuaian.stock_awal', 't_penyesuaian.stock_baru')
                                            ->where('t_penyesuaian.id_perusahaan', auth()->user()->id_perusahaan)
                                            ->orderBy('t_penyesuaian.id', 'DESC')->get();
    
            foreach($kesesuaianBarang as $item) {
                // return $key;
                $row = array();
                // $row['DT_RowIndex'] = $no++;
                $row['kode'] = $item->kode;
                $row['nama_barang'] = $item['nama'];
                $row['merek'] = $item['nama_merek'];
                $row['kategori'] = $item['nama_kategori'];
                // $row['tgl'] = $item['tgl'];
                $row['stock_awal'] = $item['stock_awal'];
                $row['stock_baru'] = $item['stock_baru'];
                $row['selisih'] = $item['stock_awal'] - $item['stock_baru'];
    
                $kesesuaian_stok[] = $row;
            }             
        }

        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
      
        $merk = Merek::orderBy('id', 'ASC')->where('id', $merek)->first();
        $category = Kategori::orderBy('id', 'ASC')->where('id', $kategori)->first();
        // return $merk;
        
        // return view('laporan.laporan-kesesuaian-stok.pdf', compact('tglAwal' ,'awal', 'akhir', 'kesesuaian_stok', 'merk', 'category', 'cPerusahaan'));
        $pdf = PDF::loadView('laporan.laporan-kesesuaian-stok.pdf', compact('cPerusahaan' , 'tglAwal', 'awal', 'akhir','merk', 'category', 'kesesuaian_stok'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Laporan Kesesuaian Stok-'. $cPerusahaan->nama .' '. date('Y-m-d h.i.s') );
    }

    public function PrintPDFKesesuaianStok($awal, $akhir, $merek, $kategori) 
    {
        // return $awal;
        $tglAwal = $awal;

        $no = 1;
        $kesesuaian_stok = array();     
        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));
            
            $kesesuaianBarang = Penyesuaian::where('t_penyesuaian.tgl', 'LIKE', '%'.$tanggal.'%')
                                            ->orWhere('id_merek', $merek)
                                            ->orWhere('id_kategori', $kategori)
                                            ->leftJoin('t_barang AS B', 'B.id', 't_penyesuaian.id_barang')
                                            ->leftJoin('t_kategori AS K', 'K.id', 'B.id_kategori')
                                            ->leftJoin('t_merek AS M', 'M.id', 'B.id_merek')
                                            ->select('B.*', 'M.nama AS nama_merek', 'K.nama AS nama_kategori', 't_penyesuaian.tgl', 't_penyesuaian.stock_awal', 't_penyesuaian.stock_baru')
                                            ->where('t_penyesuaian.id_perusahaan', auth()->user()->id_perusahaan)
                                            ->orderBy('id', 'DESC')->get();
    
            foreach($kesesuaianBarang as $item) {
                $row = array();
                // $row['DT_RowIndex'] = $no++;
                $row['kode'] = $item->kode;
                $row['nama_barang'] = $item['nama'];
                $row['merek'] = $item['nama_merek'];
                $row['kategori'] = $item['nama_kategori'];
                $row['stock_awal'] = $item['stock_awal'];
                $row['stock_baru'] = $item['stock_baru'];
                $row['selisih'] = $item['stock_awal'] - $item['stock_baru'];
    
                $kesesuaian_stok[] = $row;
            }             
        }

        // $merek = $merek;
        // $kategori = $kategori;
        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $akhir = $akhir;
        $merk = Merek::orderBy('id', 'DESC')->where('id', $merek)->first();
        $category = Kategori::orderBy('id', 'DESC')->where('id', $kategori)->first();
       
        // return $akhir;

        return view('laporan.laporan-kesesuaian-stok.print', compact('tglAwal' ,'awal', 'akhir', 'kesesuaian_stok', 'merk', 'category', 'cPerusahaan'));
    }




    // LAPORAN HUTANG PIUTANG
    public function indexLaporanHutang(Request $request)
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

        $hutang= Hutang::whereBetween('t_data_hutang.tgl', [$tanggalAwal, $tanggalAkhir])
                        ->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_data_hutang.id_pembelian')
                        ->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')
                        ->select('t_data_hutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'S.nama AS nama_supplier')  
                        ->where('t_data_hutang.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('TP.id', 'desc')->get();

        $totalHutang = 0;
        foreach($hutang as $item) {
            $totalHutang += $item->total_bayar;
        }    

        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
   
       return view('laporan.laporan-hutang.index', compact('totalHutang','tanggalAwal', 'tanggalAkhir', 'now', 'hutang'))->with($data);
    }

    public function hutang($awal, $akhir)
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
                            ->select('t_data_hutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'S.nama AS nama_supplier')  
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

        return $data;
    }

    public function dataLaporanHutang($awal, $akhir)
    {
        $data = $this->hutang($awal, $akhir);
        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->rawColumns(['no_pembelian','status'])
        ->make(true);
    }

    public function indexLaporanPiutang(Request $request)
    {   
        $data['tanggal'] = date('Y-m-d');

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

        $piutang= Piutang::whereBetween('t_data_piutang.tgl', [$tanggalAwal, $tanggalAkhir])
                        ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
                        ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
                        ->select('t_data_piutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'P.nama AS nama_pelanggan')  
                        ->where('t_data_piutang.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('TP.id', 'desc')->get();
                           
        $totalPiutang = 0;
        foreach($piutang as $item) {
            $totalPiutang += $item->total_bayar;
        }    

        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
   
       return view('laporan.laporan-piutang.index', compact('tanggalAwal', 'tanggalAkhir', 'now', 'piutang', 'totalPiutang'))->with($data);
    }

    public function piutang($awal, $akhir)
    {
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $piutang= Piutang::where('t_data_piutang.tgl', 'Like', '%'.$tanggal.'%')
                            ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
                            ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
                            ->select('t_data_piutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'P.nama AS nama_pelanggan')  
                            ->where('t_data_piutang.id_perusahaan', auth()->user()->id_perusahaan)
                            ->orderBy('TP.id', 'desc')->get();
            
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
        return $data;
    }

    public function dataLaporanPiutang($awal, $akhir)
    {
        $data = $this->piutang($awal, $akhir);
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['no_penjualan','status'])
            ->make(true);
    }

    public function DownloadHutang($awal, $akhir) 
    {
        $no = 1;

        $tglAwal = $awal;
        $hutang= Hutang::whereBetween('t_data_hutang.tgl', [$awal, $akhir])
                        ->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_data_hutang.id_pembelian')
                        ->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')
                        ->select('t_data_hutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'S.nama AS nama_supplier')  
                        ->where('t_data_hutang.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('TP.id', 'desc')->get();
        $totalHutang = 0;
        foreach($hutang as $item) {
            $totalHutang += $item->total_bayar;
        } 

        // $hutang = array();

        // while (strtotime($awal) <= strtotime($akhir)) {
        //     $tanggal = $awal;
        //     $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

        //     $h = Hutang::where('t_data_hutang.tgl', 'Like', '%'.$tanggal.'%')
        //                 ->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_data_hutang.id_pembelian')
        //                 ->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')
        //                 ->select('t_data_hutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'S.nama AS nama_supplier')  
        //                 ->where('t_data_hutang.id_perusahaan', auth()->user()->id_perusahaan)
        //                 ->orderBy('id', 'desc')->get();
            
        //     foreach($h as $item) {
        //         $row = array();
        //         $row['DT_RowIndex'] = $no++;
        //         $row['no_pembelian'] = $item->kode_invoice;
        //         $row['tgl'] = tanggal_indonesia($tanggal, false);
        //         $row['nama_supplier'] = $item->nama_supplier ;
        //         $row['total_bayar'] = 'Rp. '. format_uang($item->total_bayar );
        //         if ($item->sisa == 0) {
        //             $row['status'] = 'Lunas';
        //         } else {
        //             $row['status'] = 'Belum Lunas';
        //         }


        //         $hutang[] = $row;
        //     }         

        // }
    
        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        // return $data;
        // return view('laporan.laporan-hutang.pdf', compact('tglAwal', 'totalHutang' ,'awal', 'akhir', 'hutang', 'cPerusahaan'));
        $pdf = PDF::loadView('laporan.laporan-hutang.pdf', compact('tglAwal', 'totalHutang', 'awal', 'akhir', 'hutang', 'cPerusahaan'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Laporan Hutang-'. $cPerusahaan->nama .' '. date('Y-m-d h.i.s'));
    }

    public function DownloadPiutang($awal, $akhir) 
    {
        $no = 1;
        $tglAwal = $awal;

        // $piutang = array();

        $piutang= Piutang::whereBetween('t_data_piutang.tgl', [$awal, $akhir])
                        ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
                        ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
                        ->select('t_data_piutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'P.nama AS nama_pelanggan')  
                        ->where('t_data_piutang.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('TP.id', 'desc')->get();                       
        $totalPiutang = 0;
        foreach($piutang as $item) {
            $totalPiutang += $item->total_bayar;
        } 
        // while (strtotime($awal) <= strtotime($akhir)) {
        //     $tanggal = $awal;
        //     $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

        //     $p = Piutang::where('t_data_piutang.tgl', $tanggal)
        //         ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
        //         ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
        //         ->select('t_data_piutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'P.nama AS nama_pelanggan')  
        //         ->where('t_data_piutang.id_perusahaan', auth()->user()->id_perusahaan)
        //         ->orderBy('id', 'desc')->get();
            
        //     foreach($p as $item) {
        //         $row = array();
        //         $row['DT_RowIndex'] = $no++;
        //         $row['no_penjualan'] = $item->kode_invoice ;
        //         $row['tgl'] = tanggal_indonesia($tanggal, false);
        //         $row['nama_pelanggan'] = $item->nama_pelanggan ;
        //         $row['total_bayar'] = 'Rp. '. format_uang($item->total_bayar );
        //         if ($item->sisa == 0) {
        //             $row['status'] = 'Lunas';
        //         } else {
        //             $row['status'] = 'Belum Lunas';
        //         }

        //         $piutang[] = $row;
        //     }         

        // }
        
        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        // return $data;
        // return view('laporan.laporan-piutang.pdf', compact('tglAwal', 'totalPiutang' ,'awal', 'akhir', 'piutang', 'cPerusahaan'));
        $pdf = PDF::loadView('laporan.laporan-piutang.pdf', compact('awal', 'totalPiutang', 'akhir', 'piutang', 'tglAwal', 'cPerusahaan'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Laporan Piutang-'. $cPerusahaan->nama .' '. date('Y-m-d h.i.s'));
    }

    public function PrintPDFHutang($awal, $akhir) 
    {
        $no = 1;
        $tglAwal = $awal;
        $hutang= Hutang::whereBetween('t_data_hutang.tgl', [$awal, $akhir])
                        ->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_data_hutang.id_pembelian')
                        ->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')
                        ->select('t_data_hutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'S.nama AS nama_supplier')  
                        ->where('t_data_hutang.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('TP.id', 'desc')->get();                       
        $totalHutang = 0;
        foreach($hutang as $item) {
        $totalHutang += $item->total_bayar;
        } 
        // $hutang = array();

        // while (strtotime($awal) <= strtotime($akhir)) {
        //     $tanggal = $awal;
        //     $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

        //     $h = Hutang::where('t_data_hutang.tgl', 'Like', '%'.$tanggal.'%')
        //                 ->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_data_hutang.id_pembelian')
        //                 ->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')
        //                 ->select('t_data_hutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'S.nama AS nama_supplier')  
        //                 ->where('t_data_hutang.id_perusahaan', auth()->user()->id_perusahaan)
        //                 ->orderBy('id', 'desc')->get();
            
        //     foreach($h as $item) {
        //         $row = array();
        //         $row['DT_RowIndex'] = $no++;
        //         $row['no_pembelian'] = $item->kode_invoice;
        //         $row['tgl'] = tanggal_indonesia($tanggal, false);
        //         $row['nama_supplier'] = $item->nama_supplier ;
        //         $row['total_bayar'] = 'Rp. '. format_uang($item->total_bayar );
        //         if ($item->sisa == 0) {
        //             $row['status'] = 'Lunas';
        //         } else {
        //             $row['status'] = 'Belum Lunas';
        //         }

        //         $hutang[] = $row;
        //     }         

        // }
    
        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-hutang.print', compact('totalHutang', 'tglAwal' ,'awal', 'akhir', 'hutang', 'cPerusahaan'));
    }

    public function PrintPDFPiutang($awal, $akhir) 
    {
        $tglAwal = $awal;
        $no = 1;
        $piutang = array();

        $piutang= Piutang::whereBetween('t_data_piutang.tgl', [$awal, $akhir])
                        ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
                        ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
                        ->select('t_data_piutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'P.nama AS nama_pelanggan')  
                        ->where('t_data_piutang.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('TP.id', 'desc')->get();                       
        $totalPiutang = 0;
        foreach($piutang as $item) {
            $totalPiutang += $item->total_bayar;
        } 

        // while (strtotime($awal) <= strtotime($akhir)) {
        //     $tanggal = $awal;
        //     $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

        //     $p = Piutang::where('t_data_piutang.tgl', $tanggal)
        //         ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
        //         ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
        //         ->select('t_data_piutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'P.nama AS nama_pelanggan')  
        //         ->where('t_data_piutang.id_perusahaan', auth()->user()->id_perusahaan)
        //         ->orderBy('id', 'desc')->get();
            
        //     foreach($p as $item) {
        //         $row = array();
        //         $row['DT_RowIndex'] = $no++;
        //         $row['no_penjualan'] = $item->kode_invoice ;
        //         $row['tgl'] = tanggal_indonesia($tanggal, false);
        //         $row['nama_pelanggan'] = $item->nama_pelanggan ;
        //         $row['total_bayar'] = 'Rp. '. format_uang($item->total_bayar );
        //         if ($item->sisa == 0) {
        //             $row['status'] = 'Lunas';
        //         } else {
        //             $row['status'] = 'Belum Lunas';
        //         }

        //         $piutang[] = $row;
        //     }         
        // }

        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-piutang.print', compact('totalPiutang', 'tglAwal' ,'awal', 'akhir', 'piutang', 'cPerusahaan'));
    }




    // LAPORAN PELANGGAN TERBAIK
    public function indexBestPelanggan(Request $request)
    {
        // select count(DTP.id) from t_transaksi_penjualan TP right join t_detail_penjualan DTP on TP.id = DTP.id_penjualan group by id_pelanggan;
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');
        $now = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != $now && $request->has('tanggal_akhir') && $request->tanggal_akhir != "") {
            $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
            $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
            // if($kategori == 'semua' && $merek == 'semua'){
            //     $condition = '';
            // } else if ($kategori == 'semua' && $merek != 'semua'){
            //     $condition = 'b.merek, ' . $merek; 
            // } else if ($kategori != 'semua' && $merek == 'semua'){
            //     $condition = 'b.kategori, ' . $kategori; 
            // } else {
            //     $condition = "b.kategori == $kategori AND b.merek == $merek";
            // }
        } else {
            $tanggalAwal = date('Y-m-d', strtotime($now));
            $tanggalAkhir = date('Y-m-d', strtotime($now));
        }

        // $data['bestPelanggan'] = Pelanggan::leftJoin('t_transaksi_penjualan AS TP', 'TP.id_pelanggan', 't_pelanggan.id')->leftJoin('t_detail_penjualan AS DTP', 'DTP.id_penjualan', 'TP.id')->select('t_pelanggan.id AS id_pelanggan', 't_pelanggan.nama AS nama_pelanggan', 't_pelanggan.tlp AS tlp_pelanggan', 't_pelanggan.alamat AS alamat_pelanggan', DB::raw('sum(DTP.qty) as jumlahBeliBarang'), DB::raw('sum(DTP.qty*DTP.harga_jual) as jumlahBayarBarang'))->where('TP.id_perusahaan', auth()->user()->id_perusahaan)->groupBy('t_pelanggan.id')->orderBy('jumlahBayarBarang', 'DESC')->get();
        // $data['bestPelanggan'] = TransaksiPenjualan::leftJoin('t_detail_penjualan AS DTP', 'DTP.id_penjualan', 't_transaksi_penjualan.id')->select('t_transaksi_penjualan.id_pelanggan', DB::raw('sum(qty) as jumlahBeliBarang'))->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->groupBy('t_transaksi_penjualan.id_pelanggan')->get();    
        // dd($data['bestPelanggan']); die;
        // $data['transaksi'] = TransaksiPenjualan::select('*')->where('id', auth()->user()->id_perusahaan)->get();
        // $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();  
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-pelanggan.index', $data, compact('tanggalAwal', 'tanggalAkhir', 'now'));
    }

    public function bestPelanggan($awal, $akhir)
    {
        $no = 1;
        $data = array(); 

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $pelangganTerbaik = Pelanggan::where('TP.tgl', 'Like', '%'.$tanggal.'%')->leftJoin('t_transaksi_penjualan AS TP', 'TP.id_pelanggan', 't_pelanggan.id')->leftJoin('t_detail_penjualan AS DTP', 'DTP.id_penjualan', 'TP.id')->select('t_pelanggan.id AS id_pelanggan', 't_pelanggan.nama AS nama_pelanggan', 't_pelanggan.tlp AS tlp_pelanggan', 't_pelanggan.alamat AS alamat_pelanggan', DB::raw('sum(DTP.qty) as jumlahBeliBarang'), DB::raw('sum(DTP.qty*DTP.harga_jual) as jumlahBayarBarang'))->where('TP.id_perusahaan', auth()->user()->id_perusahaan)->groupBy('t_pelanggan.id')->orderBy('jumlahBayarBarang', 'DESC')->get();
            // return $pelangganTerbaik;

            foreach($pelangganTerbaik as $item) {
                // return $key;
                $row = array();
                $row['DT_RowIndex'] = $no++;
                // $row['id_pelanggan'] = $item['id_pelanggan'];
                $row['nama_pelanggan'] = $item['nama_pelanggan'];
                $row['tlp_pelanggan'] = $item['tlp_pelanggan'];
                $row['alamat_pelanggan'] = $item['alamat_pelanggan'];
                $row['jumlahBeliBarang'] = $item['jumlahBeliBarang'];
                $row['jumlahBayarBarang'] = 'RP. '. format_uang($item['jumlahBayarBarang']);

                $data[] = $row;
            }         

        }

        return $data;
    }

    public function getDataBestPelanggan($awal, $akhir)
    {
        $data = $this->bestPelanggan($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function DownloadBestPelanggan($awal, $akhir) 
    {
        $pelanggan = $this->bestPelanggan($awal, $akhir);
        $tglAwal = $awal;

        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        // return $data;
        // return view('laporan.laporan-pelanggan.pdf', compact('tglAwal' ,'awal', 'akhir', 'pelanggan', 'cPerusahaan'));
        $pdf = PDF::loadView('laporan.laporan-pelanggan.pdf', compact('awal', 'akhir', 'pelanggan', 'tglAwal', 'cPerusahaan'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Laporan Pelanggan Terbaik-'. $cPerusahaan->nama .' '. date('Y-m-d h.i.s'));
    }

    public function PrintPDFBestPelanggan($awal, $akhir)
    {
        $pelanggan = $this->bestPelanggan($awal, $akhir);
        $tglAwal = $awal;

        $cPerusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporan.laporan-pelanggan.print', compact('tglAwal' ,'awal', 'akhir', 'pelanggan', 'cPerusahaan'));
    }
}