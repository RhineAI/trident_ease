<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Barang;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\Pelanggan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use App\Models\TransaksiPenjualan;
use Illuminate\Routing\Controller;


class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index(){
        if(auth()->user()->hak_akses == 'super_admin') {
        $queryPerusahaan = Perusahaan::select('*');
        // GRAFIK HARGA 
        $firstMonth = Carbon::now()->startOfMonth();
        $month = date('m');
        $year = date('Y');  

            $data['cPerusahaan'] = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();
            $data['free'] = Perusahaan::whereMonth('created_at', $month)->where('grade', 1)->count();
            $data['plus'] = Perusahaan::whereMonth('created_at', $month)->where('grade', 2)->count();
            $data['pro'] = Perusahaan::whereMonth('created_at', $month)->where('grade', 3)->count();

            $data['omsetBulanan'] = ($data['plus'] * 180000) + ($data['pro'] * 300000);
            $data['omsetTahunan'] = 0;
            
            for($monthIndex = 1; $monthIndex <= 12; $monthIndex++) {
                $plus = Perusahaan::whereMonth('created_at', $monthIndex)->where('grade', 2)->count();
                $pro = Perusahaan::whereMonth('created_at', $monthIndex)->where('grade', 3)->count();
                $data['bulan'.$monthIndex] = ($plus * 180000) + ($pro * 300000);
                $data['omsetTahunan'] += $data['bulan'. $monthIndex];
            }

            $server = 800000;
            $data['keuntungan'] = $data['omsetTahunan'] - $server;
            
            return view('dashboardSuperAdmin', $data);
        } else {
            $lastMonth = date('m', strtotime('-1month'));
            for ($month = 1; $month <= 12; $month++) {
            $data['bulan'.$month] = TransaksiPenjualan::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where('id_perusahaan', auth()->user()->id_perusahaan)
                ->sum('total_harga');
        }  
            $data['laba'] = TransaksiPenjualan::whereMonth('created_at', $month)->whereYear('created_at', $year)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('keuntungan');
            $data['omset'] = TransaksiPenjualan::whereMonth('created_at', $month)->whereYear('created_at', $year)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('total_harga');
            $totalKasMasuk = KasMasuk::whereMonth('created_at', $month)->whereYear('created_at', $year)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
            $totalKasKeluar = KasKeluar::whereMonth('created_at', $month)->whereYear('created_at', $year)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
            // $data['pegawai'] = User::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
            $data['check'] = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();
            $data['cardBarang'] = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
            $data['informasi_penambahan_barang'] = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->count();
            $data['cardPenjualan'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
            $data['informasi_penambahan_transaksi'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->count();

            // Ngambil Persentase Kenaikan
            $yesterday = date('Y-m-d', strtotime('-1days'));
            $today = date('Y-m-d');
            $now = now();

            //Barang
            $getDataBarangYesterday = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', $yesterday)->count();
            $getDataBarangToday = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', $today)->count();
            $countDataBarang = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
            //Transaksi
            $getDataTransaksiYesterday = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', $yesterday)->count();
            $getDataTransaksiToday = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->whereDate('created_at', $today)->count();
            $countDataTransaksi = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->count();

            //PENGHASILAN TRANSAKSI
            $LatestTotalTransaksi = TransaksiPenjualan::whereYear('tgl', $year)->whereMonth('tgl', $lastMonth)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('total_harga');
            $NowTotalTransaksi = TransaksiPenjualan::whereYear('created_at', $year)->whereMonth('created_at', $month)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('total_harga');

            //KAS MASUK
            // $LatestTotalKasMasuk = KasMasuk::whereYear('tgl', $year)->whereMonth('tgl', $lastMonth)->where('id_perusahaan',  auth()->user()->id_perusahaan)->sum('jumlah');
            // $NowTotalKasMasuk = KasMasuk::whereYear('created_at', $year)->whereMonth('created_at', $month)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
            
            $data['percentage_penghasilan'] = persentasePerbandinganHarga($LatestTotalTransaksi, $NowTotalTransaksi);
            $data['percentage_transaksi'] = persentasePerbandingan($getDataTransaksiYesterday, $getDataTransaksiToday, $countDataTransaksi);
            // $data['percentage_kas_masuk'] = persentasePerbandinganHarga($LatestTotalKasMasuk, $NowTotalKasMasuk);

            // PERCENTAGE UP OR DOWN BARANG
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
            
            //PERCENTAGE UP OR DOWN INCOME TRANSACTION
            $checkJumlahPenghasilan = $LatestTotalTransaksi - $NowTotalTransaksi;
            if($checkJumlahPenghasilan < 0) {
                $hasilP = $checkJumlahPenghasilan + -($checkJumlahPenghasilan*2);
            } elseif($checkJumlahPenghasilan >= 0) {
                $hasilP = $checkJumlahPenghasilan;
            }
            $data['upordownpenghasilan'] = $hasilP;
            $data['cekupordownpenghasilan'] = $LatestTotalTransaksi;
            $data['todaypenghasilan'] = $NowTotalTransaksi;

            //PERCENTAGE UP OR DOWN TRANSACTION
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

            // //PERCENTAGE UP OR DOWN INCOME KAS
            // $checkJumlahKasMasuk = $LatestTotalTransaksi - $NowTotalTransaksi;
            // if($checkJumlahKasMasuk < 0) {
            //     $hasilKM = $checkJumlahKasMasuk + -($checkJumlahKasMasuk*2);
            // } elseif($checkJumlahKasMasuk >= 0) {
            //     $hasilKM = $checkJumlahKasMasuk;
            // }
            // $data['upordownkasmasuk'] = $hasilKM;
            // $data['cekupordownkasmasuk'] = $LatestTotalKasMasuk;
            // $data['todaykasmasuk'] = $NowTotalKasMasuk;


        
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
            if($data['check']->grade == 1) {
                $data['barangHarian'] = $barang * 20;
            } elseif($data['check']->grade == 2) {
                $data['barangHarian'] = $barang * 2;
            } elseif($data['check']->grade == 3) {
                $data['barangHarian'] = $barang ;
            }

            $data['kas'] = $totalKasMasuk - $totalKasKeluar;
            $data['total_pegawai'] = User::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
            $data['total_retur_penjualan'] = ReturPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->sum('total_retur');
            $data['total_retur_pembelian'] = ReturPembelian::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->sum('total_retur');
            $data['cPerusahaan'] = $queryPerusahaan->where('id', auth()->user()->id_perusahaan)->first();

            // return $data;

            if(auth()->user()->hak_akses == 'admin'){
                return view('dashboard', $data);
            } else {
                $dataKasir['cPerusahaan'] = $queryPerusahaan->where('id', auth()->user()->id_perusahaan)->first();
                $dataKasir['transaksi'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->count();
                $dataKasir['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->whereMonth('created_at', date('m'))->count();

                $dataKasir['total_retur'] = ReturPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->sum('total_retur');
                $dataKasir['total_harga'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->sum('total_harga');
                
                return view('dashboardKasir', $dataKasir);
            }
        }
        
    }

    // public function indexSuperAdmin(){
    // }
}
