<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanHarian implements FromArray, WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id_perusahaan;
    protected $awal;
    protected $akhir;
    protected $sheets;
    protected $penjualan;
    protected $pembelian;
    protected $hutang;
    protected $piutang;
    protected $kasMasuk;
    protected $kasKeluar;

    public function  __construct($id_perusahaan, $awal, $akhir, $penjualan, $pembelian, $hutang, $piutang, $kasMasuk, $kasKeluar)
    {
        // return $id_perusahaan;
        $this->id_perusahaan = $id_perusahaan;
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->penjualan = $penjualan;
        $this->pembelian = $pembelian;
        $this->hutang = $hutang;
        $this->piutang = $piutang;
        $this->kasMasuk = $kasMasuk;
        $this->kasKeluar = $kasKeluar;
    }

    public function array(): array
    {
        return $this->sheets;
    }

    public function sheets(): array
    {
        $sheets = [
            new LaporanPenjualan($this->id_perusahaan, $this->awal, $this->akhir, $this->penjualan),
            new LaporanPembelian($this->id_perusahaan, $this->awal, $this->akhir, $this->pembelian),
            new LaporanHutang($this->id_perusahaan, $this->awal, $this->akhir, $this->hutang),
            new LaporanPiutang($this->id_perusahaan, $this->awal, $this->akhir, $this->piutang),
            new LaporanKasMasuk($this->id_perusahaan, $this->awal, $this->akhir, $this->kasMasuk),
            new LaporanKasKeluar($this->id_perusahaan, $this->awal, $this->akhir, $this->kasKeluar)
        ];

        return $sheets;
    }
}
