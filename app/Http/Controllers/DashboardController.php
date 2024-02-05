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
        $data['cPerusahaan'] = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();
        // GRAFIK HARGA 
        $firstMonth = Carbon::now()->startOfMonth();
        $month = date('m');
        $year = date('Y');  
        if(auth()->user()->hak_akses == 'super_admin') {
            $data['free'] = Perusahaan::whereMonth('created_at', date('m'))->where('grade', 1)->count();
            $data['plus'] = Perusahaan::whereMonth('created_at', date('m'))->where('grade', 2)->count();
            $data['pro'] = Perusahaan::whereMonth('created_at', date('m'))->where('grade', 3)->count();

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
        } elseif(auth()->user()->hak_akses == 'admin' || auth()->user()->hak_akses == 'owner') {
            $lastMonth = date('m', strtotime('-1month'));
            for ($month = 1; $month <= 12; $month++) {
                $data['bulan'.$month] = TransaksiPenjualan::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->where('id_perusahaan', auth()->user()->id_perusahaan)
                    ->sum('total_harga');
            }  
            $barang = Barang::where('id_perusahaan', auth()->user()->id_perusahaan);
            $transaksiPenjualan = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan);
            $data['cardBarang'] = $barang->count();
            $data['cardPenjualan'] = $transaksiPenjualan->where('tgl', date('Y-m-d'))->count();
            $data['cardLaba'] = $transaksiPenjualan->where('tgl', date('Y-m-d'))->sum('keuntungan');
            $data['cardOmset'] = $transaksiPenjualan->where('tgl', date('Y-m-d'))->sum('total_harga');
            
            $data['informasi_peningkatan_barang'] = $barang->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->count();
            $data['informasi_peningkatan_transaksi'] = $transaksiPenjualan->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->count();

            $totalKasMasuk = KasMasuk::whereMonth('created_at', date('m'))->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
            $totalKasKeluar = KasKeluar::whereMonth('created_at', date('m'))->where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');

            $data['cardKas'] = $totalKasMasuk - $totalKasKeluar;
            $data['cardTotalPegawai'] = User::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
            $data['cardTotalReturPenjualan'] = ReturPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->sum('total_retur');
            $data['cardTotalReturPembelian'] = ReturPembelian::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->sum('total_retur');

            // Ngambil Persentase Kenaikan untuk Barang dan Transaksi
            $yesterday = date('Y-m-d', strtotime('-1days'));
            $today = date('Y-m-d');
            $now = now();


            // PERSENTASE NAIK ATAU TURUN (BARANG)
            $data['jumlahBarangKemarin'] = $barang->whereDate('created_at', $yesterday)->count();
            $data['jumlahBarangSaatIni'] = $barang->whereDate('created_at', $today)->count();

            $checkJumlahBarang = $data['jumlahBarangKemarin'] - $data['jumlahBarangSaatIni'];
            if($checkJumlahBarang < 0) {
                $data['peningkatanBarang'] = $checkJumlahBarang + -($checkJumlahBarang*2);
            } elseif($checkJumlahBarang >= 0) {
                $data['peningkatanBarang'] = $checkJumlahBarang;
            }


            // PERSENTASE NAIK ATAU TURUN (TRANSAKSI PENJUALAN)
            $data['jumlahTransaksiKemarin'] = $transaksiPenjualan->whereDate('created_at', $yesterday)->count();
            $data['jumlahTransaksiSaatIni'] = $transaksiPenjualan->whereDate('created_at', $today)->count();

            $checkJumlahTransaksi = $data['jumlahTransaksiKemarin'] - $data['jumlahTransaksiSaatIni'];
            if($checkJumlahTransaksi < 0) {
                $data['peningkatanTransaksi'] = $checkJumlahTransaksi + -($checkJumlahTransaksi*2);
            } elseif($checkJumlahTransaksi >= 0) {
                $data['peningkatanTransaksi'] = $checkJumlahTransaksi;
            }


            // PERSENTASE NAIK ATAU TURUN (OMSET)
            $data['totalOmsetKemarin'] = $transaksiPenjualan->whereYear('tgl', $year)->whereMonth('tgl', $lastMonth)->sum('total_harga');
            $data['totalOmsetSaatIni'] = $transaksiPenjualan->whereYear('created_at', $year)->whereMonth('created_at', $month)->sum('total_harga');
            $data['persentaseOmset'] = persentasePerbandinganHarga($data['totalOmsetKemarin'], $data['totalOmsetSaatIni']);

            $data['peningkatanOmset'] = $data['jumlahTransaksiKemarin'] - $data['jumlahTransaksiSaatIni'];
            

            //PERSENTASE NAIK ATAU TURUN (LABA)
            $data['totalLabaKemarin'] = $transaksiPenjualan->whereYear('tgl', $year)->whereMonth('tgl', $lastMonth)->sum('keuntungan');
            $data['totalLabaSaatIni'] = $transaksiPenjualan->whereYear('created_at', $year)->whereMonth('created_at', $month)->sum('keuntungan');
            $data['persentaseLaba'] = persentasePerbandinganHarga($data['totalLabaKemarin'], $data['totalLabaSaatIni']);

            $data['peningkatanLaba'] = $data['jumlahTransaksiKemarin'] - $data['jumlahTransaksiSaatIni'];

        
            // BAR PROGRESS LIMIT
            $data['penjualanHarian'] = $transaksiPenjualan->where('tgl', date('Y-m-d'))->count();
            if(auth()->user()->perusahaan->grade == 1) {
                $data['penjualanHarian'] *= 20;
            } elseif(auth()->user()->perusahaan->grade == 2) {
                $data['penjualanHarian'] *= 2;
            }

            $data['barangHarian'] = $barang->whereDate('created_at', $now)->count();
            if(auth()->user()->perusahaan->grade == 1) {
                $data['barangHarian'] *= 20;
            } elseif(auth()->user()->perusahaan->grade == 2) {
                $data['barangHarian'] *= 2;
            } 

            return view('dashboard', $data);
        } else {
            $data['transaksi'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->count();
            $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->whereMonth('created_at', date('m'))->count();

            $data['total_retur'] = ReturPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->sum('total_retur');
            $data['total_harga'] = TransaksiPenjualan::where('id_perusahaan', auth()->user()->id_perusahaan)->where('id_user', auth()->user()->id)->whereMonth('created_at', date('m'))->sum('total_harga');
            
            return view('dashboardKasir', $data);
        }
        
    }

    // public function indexSuperAdmin(){
    // }
}
