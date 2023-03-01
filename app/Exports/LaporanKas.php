<?php

namespace App\Exports;

use App\Exports\LaporanKasMasuk;
use App\Exports\LaporanKasKeluar;
use App\Models\KasKeluar;
use App\Models\KasMasuk;
use App\Models\Perusahaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

// use Maatwebsite\Excel\Concerns\FromView;

class LaporanKas implements FromArray, WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id_perusahaan;
    protected $awal;
    protected $akhir;
    protected $sheets;

    public function  __construct($id_perusahaan, $awal, $akhir)
    {
        // return $id_perusahaan;
        $this->id_perusahaan = $id_perusahaan;
        $this->awal = $awal;
        $this->akhir = $akhir;
    }

    public function array(): array
    {
        return $this->sheets;
    }

    public function sheets(): array
    {
        $sheets = [
            new LaporanKasMasuk($this->id_perusahaan, $this->awal, $this->akhir),
            new LaporanKasKeluar($this->id_perusahaan, $this->awal, $this->akhir)
        ];

        return $sheets;
    }
}



// public function collection(){
//     return KasMasuk::whereBetween('tgl', [$this->awal, $this->akhir])
//     ->leftJoin('t_users AS U', 'U.id', 't_kas_masuk.id_user')
//     ->select('t_kas_masuk.*', 'U.nama AS nama_user')  
//     ->where('t_kas_masuk.id_perusahaan', $this->id_perusahaan)
//     ->orderBy('id', 'asc')->get();
// }

// public function headings() :array
// {
//     return [
//         'No',
//         'Tanggal',
//         'Keterangan',
//         'Petugas',
//         'Jumlah',
//     ];
// }

// AfterSheet::class    => function(AfterSheet $event) {   
// public function registerEvents(): array
// {
//     return [
//             $event->sheet->getColumnDimension('A')->setAutoSize();
//             $event->sheet->getColumnDimension('B')->setAutoSize();
//             $event->sheet->getColumnDimension('C')->setAutoSize();
//             $event->sheet->getColumnDimension('D')->setAutoSize();
//             $event->sheet->getColumnDimension('E')->setAutoSize();
//             $event->sheet->getColumnDimension('F')->setAutoSize();
//             $event->sheet->getColumnDimension('G')->setAutoSize();
//         },
//     ];
// }

// public function view(): View
// {
//     $kasMasuk= KasMasuk::whereBetween('tgl', [$this->awal, $this->akhir])
//                         ->leftJoin('t_users AS U', 'U.id', 't_kas_masuk.id_user')
//                         ->select('t_kas_masuk.*', 'U.nama AS nama_user')  
//                         ->where('t_kas_masuk.id_perusahaan', $this->id_perusahaan)
//                         ->orderBy('id', 'asc')->get();
//     $totalKasMasuk = 0;
//     foreach($kasMasuk as $item) {
//         $totalKasMasuk += $item->jumlah;
//     }   

//     $kasKeluar= KasKeluar::whereBetween('tgl', [$this->awal, $this->akhir])
//                         ->leftJoin('t_users AS U', 'U.id', 't_kas_keluar.id_user')
//                         ->select('t_kas_keluar.*', 'U.nama AS nama_user')    
//                         ->where('t_kas_keluar.id_perusahaan', $this->id_perusahaan)
//                         ->orderBy('id', 'asc')->get();
//     $totalKasKeluar = 0;
//     foreach($kasKeluar as $item) {
//         $totalKasKeluar += $item->jumlah;
//     } 
//     $tglAwal = $this->awal;
//     $awal = $this->awal;
//     $akhir = $this->akhir;
//     $cPerusahaan = Perusahaan::select('*')->where('id', $this->id_perusahaan)->first();

//     return view('laporan.laporan-kas.excel', compact('tglAwal' ,'awal', 'akhir', 'totalKasMasuk', 'totalKasKeluar', 'kasMasuk','kasKeluar', 'cPerusahaan'));
// }