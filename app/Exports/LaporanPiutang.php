<?php

namespace App\Exports;

use App\Models\DetailPembelian;
use App\Models\Piutang;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanPiutang implements WithProperties, WithEvents, WithHeadings, FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id_perusahaan;
    protected $awal;
    protected $akhir;

    public function  __construct($id_perusahaan, $awal, $akhir)
    {
        $this->id_perusahaan = $id_perusahaan;
        $this->awal = $awal;
        $this->akhir = $akhir;
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Muhamad Fadhil Allifah',
            'lastModifiedBy' => 'Muhamad Fadhil Allifah',
            'title'          => 'Export Excel Laporan Penjualan',
            'description'    => 'Export Excel Data Laporan Penjualan',
            'subject'        => 'Export Excel Laporan Penjualan',
            'keywords'       => 'templates,export,spreadsheet',
            'category'       => 'Export',
            'manager'        => 'Muhamad Fadhil Allifah',
            'company'        => 'SMKN 1 Cianjur',
        ];
    }

    public function title(): string
    {
        return 'Laporan Piutang';
    }

    public function headings() :array
    {
        return [
            'No',
            'Kode Penjualan',
            'Tanggal',
            'Pelanggan',
            'Status',
            'Dibayar',
        ];
    }

    public function collection()
    {
        $piutang = Piutang::whereBetween('t_data_piutang.tgl', [$this->awal, $this->akhir])
        ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_data_piutang.id_penjualan')
        ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
        ->select('t_data_piutang.*', 'TP.id as kode_invoice', 'TP.sisa', 'P.nama AS nama_pelanggan')  
        ->where('t_data_piutang.id_perusahaan', auth()->user()->id_perusahaan)
        ->orderBy('TP.id', 'desc')->get();   
    
        return $piutang;
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getColumnDimension('F')->setAutoSize(true);

                $event->sheet->insertNewRowBefore(1, 2);
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->setCellValue('A1', 'Data Piutang');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getStyle('A3:F'.$event->sheet->getHighestRow())->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000']
                        ]
                    ]
                ]);
            }
        ];
    }
}
