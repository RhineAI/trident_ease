<?php

namespace App\Http\Controllers;

use App\Exports\LaporanKasMasuk;
use App\Exports\LaporanKasKeluar;
use App\Exports\LaporanKas;
use App\Exports\LaporanPenjualan;
use Illuminate\Http\Request;
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
        return Excel::download(new LaporanPenjualan($cPerusahaan, $awal, $akhir), date('d-m-Y').'_Laporan Penjualan.xlsx');
    }
}
