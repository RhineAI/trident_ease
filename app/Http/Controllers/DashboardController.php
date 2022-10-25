<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\User;
use App\Models\Barang;
use App\Models\KasMasuk;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        //Card
        $data['penjualan'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->sum('total_harga');
        $data['pegawai'] = User::count();
        $data['kas'] = KasMasuk::where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
        $data['check'] = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();
        $brg = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        $data['cardBarang'] = $brg;
        //


        // Ngambil Persentase Kenaikan (barang)
        $yesterday = date('Y-m-d', strtotime('-1days'));
        $today = date('Y-m-d');
        $now = now();
        // return $brg;
        $getDataBarangYesterday = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', $yesterday)->count();
        $getDataBarangToday = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', $today)->count();
        $countDataBarang = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        $barangNow = Barang::select('created_at')->where('created_at', $now);

        $checkJumlahBarang = $getDataBarangYesterday - $getDataBarangToday;
        // return $checkJumlahBarang;
        if($checkJumlahBarang < 0) {
            $hasilCheck = $checkJumlahBarang + -($checkJumlahBarang*2);
        } elseif($checkJumlahBarang >= 0) {
            $hasilCheck = $checkJumlahBarang;
        }
        // return $hasilCheck;
        if ($hasilCheck != $getDataBarangYesterday) {
            if($getDataBarangYesterday != 0) {
                $cek1 = 100 / $getDataBarangYesterday ;
                $cek2 = $getDataBarangYesterday - $hasilCheck;
                $data['percentage_barang'] = round($cek1 * $cek2, 2, PHP_ROUND_HALF_UP) ;
            } else {
                $cek3 = 100 / $countDataBarang;
                $data['percentage_barang'] = $hasilCheck * $cek3; 
            }
        } elseif($hasilCheck == $getDataBarangYesterday) {
            if ($barangNow != $now) {
                $data['percentage_barang'] = 0;
            } else {
                $data['percentage_barang'] = 100;
            }
        } elseif($hasilCheck >= $getDataBarangYesterday) {
            $cek1 = 100 / $getDataBarangYesterday ;
            $cek2 = $getDataBarangYesterday - $hasilCheck;
            $data['percentage_barang'] = 100 + round($cek1 * $cek2, 2, PHP_ROUND_HALF_EVEN);
        } 
        
        // return $data['totalBarangYesterday'];
        // return $data['percentage_barang'];
        $data['totalBarangYesterday'] = $hasilCheck;


        if($data['check']->grade == 1) {
            $data['barang'] = $brg * 10;
        } elseif($data['check']->grade == 2) {
            $data['barang'] = $brg * 2;
        } elseif($data['check']->grade == 3) {
            $data['barang'] = $brg * 0.1;
        }

        $penjualan = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('tgl', date('Y-m-d'))->count();
        $data['total_penjualan'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        // return $penjualan;
        if($data['check']->grade == 1) {
            $data['penjualanHarian'] = $penjualan * 10;
        } elseif($data['check']->grade == 2) {
            $data['penjualanHarian'] = $penjualan * 2;
        } elseif($data['check']->grade == 3) {
            $data['penjualanHarian'] = $penjualan ;
        }

        $barang = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->where('created_at', $now)->count();
        if($data['check']->grade == 1) {
            $data['barangHarian'] = $barang * 10;
        } elseif($data['check']->grade == 2) {
            $data['barangHarian'] = $barang * 2;
        } elseif($data['check']->grade == 3) {
            $data['barangHarian'] = $barang ;
        }
        // return $check;
        // return $data['check'];
        // if ($data['check']->grade == 1) {
        //     'Free';
        // } elseif($data['check']->grade = 2) {
        //     'Intermediate';
        // } elseif($data['check']->grade = 3) {
        //     'Premium';
        // }

        // return $data;
        // return $brg;
        // $data['barang'] = $brg->count();
        // $data['barang'] = Barang::count();
        // ->where('id_perusahaan', auth()->user()->id_perushaan)->first();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        // return $data;
        return view('dashboard', $data);
    }
}
