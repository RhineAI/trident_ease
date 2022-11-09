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
        $lastMonth = date('m', strtotime('-1month'));
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

        //PENGHASILAN TRANSAKSI
        $LatestTotalTransaksi = TransaksiPenjualan::whereYear('created_at', $year)->whereMonth('created_at', $lastMonth)->where('id', auth()->user()->id_perusahaan)->sum('total_harga');
        $NowTotalTransaksi = TransaksiPenjualan::whereYear('created_at', $year)->whereMonth('created_at', $month)->where('id', auth()->user()->id_perusahaan)->sum('total_harga');
        //KAS MASUK
        $getLatestTotal = KasMasuk::whereYear('created_at', $year)->whereMonth('created_at', $lastMonth)->where('id', auth()->user()->id_perusahaan)->sum('jumlah');
        $getNowTotal = KasMasuk::whereYear('created_at', $year)->whereMonth('created_at', $month)->where('id', auth()->user()->id_perusahaan)->sum('jumlah');

        if ($getLatestTotal == 0) {
            if($getNowTotal > 10) {
                $percentage = $getNowTotal;
            } elseif ($getNowTotal > 100) {
                $percentage = $getNowTotal / 10;
            } elseif ($getNowTotal > 1000) {
                $percentage = $getNowTotal / 10;
            } elseif ($getNowTotal > 10000) {
                $percentage = $getNowTotal / 100;
            } elseif ($getNowTotal > 100000) {
                $percentage = $getNowTotal / 1000;
            } elseif ($getNowTotal > 1000000) {
                $percentage = $getNowTotal / 10000;
            } elseif ($getNowTotal > 10000000) {
                $percentage = $getNowTotal / 100000;
            } elseif ($getNowTotal > 100000000) {
                $percentage = $getNowTotal / 1000000;
            } elseif ($getNowTotal > 1000000000) {
                $percentage = $getNowTotal / 10000000;
            } elseif ($getNowTotal > 10000000000) {
                $percentage = $getNowTotal / 100000000;
            } elseif ($getNowTotal > 100000000000) {
                $percentage = $getNowTotal / 1000000000;
            } elseif ($getNowTotal > 1000000000000) {
                $percentage = $getNowTotal / 10000000000;
            } 
        } else {
            $difference = $getNowTotal - $getLatestTotal;
            // JIKA KURANG DARI    $differece = 1000 - 2000 (-1000); 
            // JIKA LEBIH DARI     $differece = 5000 - 1000 (4000); 
            // JIKA DATA LAST 0    $difference = 1000 - 0 (1000);
    
            if ($difference <= $getLatestTotal) { //-1000
                $makePositive = -1 * $difference; //1000 
                $divide = 100 / $getLatestTotal; //100 / 2000 = 0.05
                $percentage = round($makePositive * $divide, 2, PHP_ROUND_HALF_UP); //1000 * 0.05 = 50
            } elseif ($difference == $getLatestTotal) {
                $percentage = 100;
            } elseif ($differece >= $getLatestTotal) { //4000
                $divide = 100 / $getLatestTotal; //100 / 1000 = 0.1
                $times = round($differece * $divide, 2, PHP_ROUND_HALF_UP); // 4000 * 0.1 = 500
                if ($times > 1000) {
                    $percentage = 1000 . '+';
                } else {
                    $percentage = $times;
                }
            }
        }
        $data['percentage_penghasilan'] = $percentage;
        
        $data['percentage_barang'] = persentasePerbandingan($getDataBarangYesterday, $getDataBarangToday, $countDataBarang);
        // $data['percentage_penghasilan'] = persentasePerbandinganHarga($LatestTotalTransaksi, $NowTotalTransaksi);
        $data['percentage_transaksi'] = persentasePerbandingan($getDataTransaksiYesterday, $getDataTransaksiToday, $countDataTransaksi);
        // $data['percentage_kas'] = persentasePerbandinganHarga($LatestTotalKasMasuk, $NowTotalKasMasuk);

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
