<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\User;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\KasMasuk;
use App\Models\ReturPenjualan;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index(){
        $lastMonth = date('m', strtotime('-1month'));
        $month = date('m');
        $year = date('Y');

        $data['penjualan'] = TransaksiPenjualan::whereMonth('created_at', $month)->whereYear('created_at', $year)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('total_harga');
        $data['kas'] = KasMasuk::whereMonth('created_at', $month)->whereYear('created_at', $year)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
        $data['pegawai'] = User::count();
        $data['check'] = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();
        $data['cardBarang'] = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        $data['cardPenjualan'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->count();

        // return $limit;

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
        $LatestTotalTransaksi = TransaksiPenjualan::whereYear('tgl', $year)->whereMonth('tgl', $lastMonth)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('total_harga');
        $NowTotalTransaksi = TransaksiPenjualan::whereYear('created_at', $year)->whereMonth('created_at', $month)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('total_harga');
        // return $NowTotalTransaksi;
        //KAS MASUK
        $LatestTotalKasMasuk = KasMasuk::whereYear('tgl', $year)->whereMonth('tgl', $lastMonth)->where('id_perusahaan',  auth()->user()->id_perusahaan)->sum('jumlah');
        $NowTotalKasMasuk = KasMasuk::whereYear('created_at', $year)->whereMonth('created_at', $month)->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
        
        $data['percentage_barang'] = persentasePerbandingan($getDataBarangYesterday, $getDataBarangToday, $countDataBarang);
        $data['percentage_penghasilan'] = persentasePerbandinganHarga($LatestTotalTransaksi, $NowTotalTransaksi);
        $data['percentage_transaksi'] = persentasePerbandingan($getDataTransaksiYesterday, $getDataTransaksiToday, $countDataTransaksi);
        $data['percentage_kas_masuk'] = persentasePerbandinganHarga($LatestTotalKasMasuk, $NowTotalKasMasuk);

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

        //PERCENTAGE UP OR DOWN INCOME KAS
        $checkJumlahKasMasuk = $LatestTotalTransaksi - $NowTotalTransaksi;
        if($checkJumlahKasMasuk < 0) {
            $hasilKM = $checkJumlahKasMasuk + -($checkJumlahKasMasuk*2);
        } elseif($checkJumlahKasMasuk >= 0) {
            $hasilKM = $checkJumlahKasMasuk;
        }
        $data['upordownkasmasuk'] = $hasilKM;
        $data['cekupordownkasmasuk'] = $LatestTotalKasMasuk;
        $data['todaykasmasuk'] = $NowTotalKasMasuk;


       
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

        if(auth()->user()->hak_akses == 'admin' or auth()->user()->hak_akses == 'super_admin'){
            return view('dashboard', $data);
        } elseif(auth()->user()->hak_akses == 'owner') {
            return view('dashboard', $data);
        } else {
            $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
            $data['transaksi'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->count();
            $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->whereMonth('created_at', date('m'))->count();

            
            $data['total_retur'] = ReturPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->sum('total_retur');
            $data['total_harga'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->sum('total_harga');

            return view('dashboardKasir', $data);
        }
        // return view('dashboard', $data);
    }

    // public function indexKasir(){
    //     $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
    //     return view('dashboardKasir', $data);
    // }
}
