<?php

namespace App\Http\Controllers;

use App\Exports\LaporanHutang;
use App\Exports\LaporanKasMasuk;
use App\Exports\LaporanKasKeluar;
use App\Exports\LaporanKas;
use App\Exports\LaporanPelangganTerbaik;
use App\Exports\LaporanPembelian;
use App\Exports\LaporanPenjualan;
use App\Exports\LaporanPiutang;
use App\Exports\LaporanStok;
use App\Exports\LaporanStokOpname;
use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelLaporanController extends Controller
{
    public function downloadLaporanKas($awal, $akhir) 
    {
        // return [$awal, $akhir];
        $cPerusahaan = auth()->user()->id_perusahaan;
        return Excel::download(new LaporanKas($cPerusahaan, $awal, $akhir), date('d-m-Y') . '_Laporan Kas.xlsx');
        // return Excel::download(new LaporanKasKeluar($cPerusahaan, $awal, $akhir), date('d-m-Y') . '_Laporan Kas.xlsx');
    }

    public function downloadLaporanPenjualan($awal, $akhir){
        $cPerusahaan = auth()->user()->id_perusahaan;
        $model = DetailPenjualan::leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
        ->select('t_detail_penjualan.id_penjualan as id', 't_detail_penjualan.tgl', 'B.kode', 'B.nama AS nama_barang', 't_detail_penjualan.qty', 't_detail_penjualan.diskon', 't_detail_penjualan.harga_beli', 't_detail_penjualan.harga_jual', DB::raw('(t_detail_penjualan.harga_jual * t_detail_penjualan.qty)'), DB::raw('((t_detail_penjualan.harga_jual - t_detail_penjualan.harga_beli) * t_detail_penjualan.qty) - ((t_detail_penjualan.harga_jual - t_detail_penjualan.harga_beli) * t_detail_penjualan.qty) * t_detail_penjualan.diskon / 100'))
        ->whereBetween('t_detail_penjualan.tgl', [$awal, $akhir])
        ->where('t_detail_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->get();

        return Excel::download(new LaporanPenjualan($cPerusahaan, $awal, $akhir, $model), date('d-m-Y').'_Laporan Penjualan.xlsx');
    }

    public function downloadLaporanPembelian($awal, $akhir){
        $cPerusahaan = auth()->user()->id_perusahaan;
        $model = DetailPembelian::leftJoin('t_barang AS B', 'B.id', 't_detail_pembelian.id_barang')
                                                ->select('t_detail_pembelian.*', 'B.nama AS nama_barang', 'B.kode')
                                                ->whereBetween('t_detail_pembelian.tgl', [$awal, $akhir])
                                                ->where('t_detail_pembelian.id_perusahaan', auth()->user()->id_perusahaan)
                                                ->orderBy('id', 'asc')->get();
                                                
        return Excel::download(new LaporanPembelian($cPerusahaan, $awal, $akhir, $model), date('d-m-Y').'_Laporan Pembelian.xlsx');
    }

    public function downloadLaporanStok($merek, $kategori){
        $cPerusahaan = auth()->user()->id_perusahaan;
        return Excel::download(new LaporanStok($cPerusahaan, $merek, $kategori), date('d-m-Y').'_Laporan Stok.xlsx');
    }

    public function downloadLaporanPelangganTerbaik($awal, $akhir){
        $cPerusahaan = auth()->user()->id_perusahaan;
        return Excel::download(new LaporanPelangganTerbaik($cPerusahaan, $awal, $akhir), date('d-m-Y').'_Laporan Pelanggan Terbaik.xlsx');
    }

    public function downloadLaporanStockOpname($awal, $akhir, $merek, $kategori){
        $cPerusahaan = auth()->user()->id_perusahaan;
        return Excel::download(new LaporanStokOpname($cPerusahaan, $awal, $akhir, $merek, $kategori), date('d-m-Y').'_Laporan Pelanggan Terbaik.xlsx');
    }

    public function downloadLaporanHutang($awal, $akhir){
        $cPerusahaan = auth()->user()->id_perusahaan;
        return Excel::download(new LaporanHutang($cPerusahaan, $awal, $akhir), date('d-m-Y').'_Laporan Hutang.xlsx');
    }

    public function downloadLaporanPiutang($awal, $akhir){
        $cPerusahaan = auth()->user()->id_perusahaan;
        return Excel::download(new LaporanPiutang($cPerusahaan, $awal, $akhir), date('d-m-Y').'_Laporan Piutang.xlsx');
    }
}
