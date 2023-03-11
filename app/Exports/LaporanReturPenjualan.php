<?php

namespace App\Exports;

use App\Models\DetailPenjualan;
use App\Models\ReturPenjualan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanReturPenjualan implements WithProperties, WithEvents, WithHeadings, FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id_perusahaan;
    protected $awal;
    protected $akhir;
    protected $lastRow;
    protected $totalRP;

    public function  __construct($id_perusahaan, $awal, $akhir, $model)
    {
        $this->id_perusahaan = $id_perusahaan;
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->lastRow = count($model) + 4;
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Muhamad Fadhil Allifah',
            'lastModifiedBy' => 'Muhamad Fadhil Allifah',
            'title'          => 'Export Excel Laporan Retur  Penjualan',
            'description'    => 'Export Excel Data Laporan Retur Penjualan',
            'subject'        => 'Export Excel Laporan Retur Penjualan',
            'keywords'       => 'templates,export,spreadsheet',
            'category'       => 'Export',
            'manager'        => 'Muhamad Fadhil Allifah',
            'company'        => 'SMKN 1 Cianjur',
        ];
    }

    public function title(): string
    {
        return 'Laporan Retur Penjualan';
    }

    public function headings() :array
    {
        return [
            'No',
            'Kode',
            'Nama Barang',
            'Qty',
            'Subtotal'
        ];
    }

    public function collection()
    {
        $returPenjualan = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')
                        ->leftJoin('t_barang AS B', 'B.id', 'DRP.id_barang')
                        ->whereBetween('t_retur_penjualan.tgl', [$this->awal, $this->akhir])
                        ->select('DRP.id_retur_penjualan', 'B.kode' ,'B.nama AS nama_barang', 'DRP.qty', 'DRP.sub_total')    
                        ->where('DRP.id_perusahaan', auth()->user()->id_perusahaan)
                        ->orderBy('DRP.id', 'desc')->get();

        foreach($returPenjualan as $item) {
            $this->totalRP += $item->sub_total;
        } 
    
        return $returPenjualan;
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

                $event->sheet->insertNewRowBefore(1, 2);
                $event->sheet->mergeCells('A1:E1');
                $event->sheet->setCellValue('A1', 'Data Retur Penjualan');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->insertNewRowBefore($this->lastRow, 1);
                $event->sheet->mergeCells(sprintf('A%s:E%s', $this->lastRow, $this->lastRow));
                $event->sheet->setCellValue(sprintf('A%s', $this->lastRow), 'Total Retur : Rp. '. $this->totalRP);
                $event->sheet->getStyle(sprintf('A%s', $this->lastRow))->getFont()->setBold(true);
                $event->sheet->getStyle(sprintf('A%s:E%s', $this->lastRow, $this->lastRow))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A3:E'.$event->sheet->getHighestRow())->applyFromArray([
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
