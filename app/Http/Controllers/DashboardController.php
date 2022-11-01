<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\User;
use App\Models\Barang;
use App\Models\KasMasuk;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(){
        // $no = date('Y-m-d');
        // $p = Barang::select('*')->whereDate('created_at', $no)->get();
        // return $p;
        //Card
        $month = date('m');
        $year = date('Y');
        $data['penjualan'] = TransaksiPenjualan::whereMonth('created_at', $month)->whereYear('created_at', $year)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('total_harga');
        $data['kas'] = KasMasuk::whereMonth('created_at', $month)->whereYear('created_at', $year)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
        $data['pegawai'] = User::count();
        $data['check'] = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();
        $data['cardBarang'] = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->count();;
        $data['cardPenjualan'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        //


        // Ngambil Persentase Kenaikan
        $yesterday = date('Y-m-d', strtotime('-1days'));
        $today = date('Y-m-d');
        $now = now();

        //Barang
        $getDataBarangYesterday = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', $yesterday)->count();
        $getDataBarangToday = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', $today)->count();
        $countDataBarang = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        $barangNow = Barang::whereDate('created_at', $now)->where('id_perusahaan', auth()->user()->id_perusahaan)->get();
        //Transaksi
        $getDataTransaksiYesterday = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', $yesterday)->count();
        $getDataTransaksiToday = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', $today)->count();
        $countDataTransaksi = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        $transaksiNow = TransaksiPenjualan::whereDate('created_at', $now)->where('id_perusahaan', auth()->user()->id_perusahaan)->get();

        $data['percentage_barang'] = persentasePerbandingan($getDataBarangYesterday, $getDataBarangToday, $countDataBarang);
        $data['percentage_transaksi'] = persentasePerbandingan($getDataTransaksiYesterday, $getDataTransaksiToday, $countDataTransaksi);

        // return $countDataNow;
        // $checkJumlah = $getDataYesterday - $getDataToday;
        // $now = now();
        // if($checkJumlah < 0) {
        //     $hasilCheck = $checkJumlah + -($checkJumlah*2);
        // } elseif($checkJumlah >= 0) {
        //     $hasilCheck = $checkJumlah;
        // }
        // // return $hasilCheck;
        // if($getDataYesterday == 0) {
        //     if($countDataNow != 0) {
        //         $cek = 100 / $countDataNow;
        //         $percentage = round($hasilCheck * $cek, 2, PHP_ROUND_HALF_UP); 
        //     } elseif($countDataNow == 0) {
        //         $percentage = 0;
        //     }
        // }elseif ($hasilCheck != $getDataYesterday) {
        //     if($getDataYesterday <= $hasilCheck) {
        //         $cek1 = 100 / $getDataYesterday;
        //         $cek2 = $getDataToday - $getDataYesterday;
        //         $cek3 = $cek2 - $getDataYesterday;
        //         $percentage = round($cek1 * $cek3 , 2, PHP_ROUND_HALF_UP);
        //     } 
        //     elseif($getDataYesterday >= $hasilCheck) {
        //         $cek4 = 100/ $getDataYesterday;
        //         $percentage = round($cek4 * $hasilCheck, 2, PHP_ROUND_HALF_UP);
                
        //     } 
        // }elseif($hasilCheck == $getDataYesterday) {
        //     $percentage = 100;   
        // } 
        // elseif($hasilCheck >= $getDataYesterday) {
        //     $cek1 = 100 / $getDataYesterday ;
        //     $cek2 = $getDataYesterday - $hasilCheck;
        //     $percentage = 100 + round($cek1 * $cek2, 2, PHP_ROUND_HALF_EVEN);
        // }

        // return $percentage;


        $checkJumlahBarang = $getDataBarangYesterday - $getDataBarangToday;
        if($checkJumlahBarang < 0) {
            $hasilB = $checkJumlahBarang + -($checkJumlahBarang*2);
        } elseif($checkJumlahBarang >= 0) {
            $hasilB = $checkJumlahBarang;
        }
        
        $data['upordownbarang'] = $hasilB;
        $data['cekupordownbarang'] = $getDataBarangYesterday;
        $data['todaybarang'] = $getDataBarangToday;
        $data['totalBarangYesterday'] = $hasilB;
        // return $data;

        // return $getDataTransaksiYesterday;
        $checkJumlahTransaksi = $getDataTransaksiYesterday - $getDataTransaksiToday;
        if($checkJumlahTransaksi < 0) {
            $hasilT = $checkJumlahTransaksi + -($checkJumlahTransaksi*2);
        } elseif($checkJumlahTransaksi >= 0) {
            $hasilT = $checkJumlahTransaksi;
        }
        
        $data['upordowntransaksi'] = $hasilT;
        $data['cekupordowntransaksi'] = $getDataTransaksiYesterday;
        $data['todaytransaksi'] = $getDataBarangToday;
        $data['totalTransaksiYesterday'] = $hasilT;

       
        // PROGRESS

        $penjualan = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('tgl', date('Y-m-d'))->count();
        // return $penjualan;
        if($data['check']->grade == 1) {
            $data['penjualanHarian'] = $penjualan * 20;
        } elseif($data['check']->grade == 2) {
            $data['penjualanHarian'] = $penjualan * 2;
        } elseif($data['check']->grade == 3) {
            $data['penjualanHarian'] = $penjualan ;
        }

        $barang = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', $now)->count();
        // return $barang;
        if($data['check']->grade == 1) {
            $data['barangHarian'] = $barang * 20;
        } elseif($data['check']->grade == 2) {
            $data['barangHarian'] = $barang * 2;
        } elseif($data['check']->grade == 3) {
            $data['barangHarian'] = $barang ;
        }
        

        // GRAFIK HARGA 
        $firstMonth = Carbon::now()->startOfMonth();
        $month = date('m');
        $year = date('Y');


        $data['bulan1'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 1)->sum('total_harga');
        $data['bulan2'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 2)->sum('total_harga');
        $data['bulan3'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 3)->sum('total_harga');
        $data['bulan4'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 4)->sum('total_harga');
        $data['bulan5'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 5)->sum('total_harga');
        $data['bulan6'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 6)->sum('total_harga');
        $data['bulan7'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 7)->sum('total_harga');
        $data['bulan8'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 8)->sum('total_harga');
        $data['bulan9'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 9)->sum('total_harga');
        $data['bulan10'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 10)->sum('total_harga');
        $data['bulan11'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 11)->sum('total_harga');
        $data['bulan12'] = TransaksiPenjualan::whereYear('created_at',$year)->whereMonth('created_at', 12)->sum('total_harga');
        
        // return $data['bulan10'];

        // return $data_tanggal;
        // d($data_tanggal, $data_pendapatan);
        // $data['rekapBulanan'] = TransaksiPenjualan::whereYear('created_at', $year)->whereMonth('created_at', $month)->sum('total_harga');


        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        // return $data;
        return view('dashboard', $data);
    }
}
