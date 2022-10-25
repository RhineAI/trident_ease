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
        $data['penjualan'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->sum('total_harga');
        $data['pegawai'] = User::count();
        $data['kas'] = KasMasuk::where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
        $data['check'] = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();
        $brg = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        $data['cardBarang'] = $brg;


        // Ngambil Persentase Kenaikan (barang)
        $yesterday = date('Y-m-d', strtotime('-1days'));
        $today = date('Y-m-d');
        // return $brg;
        $getDataBarangYesterday = Barang::whereDate('created_at', $yesterday)->count();
        $getDataBarangToday = Barang::whereDate('created_at', $today)->count();
        $barangNow = Barang::select('created_at')->where('created_at', $today);
        // return $barangNow;
        $now = now();
        // return $getDataBarangYesterday;

        // $data['percentage_barang'] = persentasePerbandingan($getDataBarangYesterday, $getDataBarangToday);

        $checkJumlahBarang = $getDataBarangYesterday - $getDataBarangToday;
        // return $checkJumlahBarang;
        if($checkJumlahBarang < 0) {
            $hasilCheck = $checkJumlahBarang + -($checkJumlahBarang*2);
        } elseif($checkJumlahBarang >= 0) {
            $hasilCheck = $checkJumlahBarang;
        }
        // return $hasilCheck;
        if ($hasilCheck != $getDataBarangYesterday) {
            $cek1 = 100 / $getDataBarangYesterday ;
            // return $cek1;
            $cek2 = $getDataBarangYesterday - $hasilCheck;
            $data['percentage_barang'] = round($cek1 * $cek2, 2, PHP_ROUND_HALF_UP) ;
        } elseif($hasilCheck == $getDataBarangYesterday) {
            if ($now == $barangNow) {
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

        $total = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        if($data['check']->grade == 1) {
            $data['total_penjualan'] = $total * 10;
        } elseif($data['check']->grade == 2) {
            $data['total_penjualan'] = $total * 2;
        } elseif($data['check']->grade == 3) {
            $data['total_penjualan'] = $total * 0.1;
            // $data['jumlah_penjualan'] = $total;
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
