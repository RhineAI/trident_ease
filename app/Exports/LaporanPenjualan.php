<?php

namespace App\Exports;

use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanPenjualan implements WithProperties, WithEvents, WithHeadings, FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id_perusahaan;
    protected $awal;
    protected $akhir;
    protected $lastRow;
    protected $totalU;
    protected $totalO;

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
        return 'Laporan Penjualan';
    }

    public function headings() :array
    {
        return [
            'No',
            'Tanggal',
            'Kode',
            'Nama Barang',
            'Qty',
            'Diskon',
            'Harga Beli',
            'Harga Jual',
            'Omset',
            'Keuntungan'
        ];
    }

    public function collection()
    {
        $detPenjualan = DetailPenjualan::leftJoin('t_barang AS B', 'B.id', 't_detail_penjualan.id_barang')
                                ->select('t_detail_penjualan.id_penjualan as id', 't_detail_penjualan.tgl', 'B.kode', 'B.nama AS nama_barang', 't_detail_penjualan.qty', 't_detail_penjualan.diskon', 't_detail_penjualan.harga_beli', 't_detail_penjualan.harga_jual', DB::raw('(t_detail_penjualan.harga_jual * t_detail_penjualan.qty)'), DB::raw('((t_detail_penjualan.harga_jual - t_detail_penjualan.harga_beli) * t_detail_penjualan.qty) - ((t_detail_penjualan.harga_jual - t_detail_penjualan.harga_beli) * t_detail_penjualan.qty) * t_detail_penjualan.diskon / 100'))
                                ->whereBetween('t_detail_penjualan.tgl', [$this->awal, $this->akhir])
                                ->where('t_detail_penjualan.id_perusahaan', $this->id_perusahaan)->get();

        foreach($detPenjualan as $item) {
                $countUntung = (($item->harga_jual - $item->harga_beli) * $item->qty) - ( ($item->harga_jual - $item->harga_beli) * $item->qty) * $item->diskon/100;
                $this->totalU += $countUntung;

                $countOmset = $item->harga_jual * $item->qty;
                $this->totalO += $countOmset;
        } 
    
        return $detPenjualan;
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
                $event->sheet->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getColumnDimension('H')->setAutoSize(true);
                $event->sheet->getColumnDimension('I')->setAutoSize(true);
                $event->sheet->getColumnDimension('J')->setAutoSize(true);

                $event->sheet->insertNewRowBefore(1, 2);
                $event->sheet->mergeCells('A1:J1');
                $event->sheet->setCellValue('A1', 'Data Penjualan');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->insertNewRowBefore($this->lastRow, 1);
                $event->sheet->mergeCells(sprintf('A%s:J%s', $this->lastRow, $this->lastRow));
                $event->sheet->setCellValue(sprintf('A%s', $this->lastRow), 'Total : Rp. '. $this->totalO);
                $event->sheet->getStyle(sprintf('A%s', $this->lastRow))->getFont()->setBold(true);
                $event->sheet->getStyle(sprintf('A%s:J%s', $this->lastRow, $this->lastRow))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->insertNewRowBefore($this->lastRow + 1, 1);
                $event->sheet->mergeCells(sprintf('A%s:J%s', $this->lastRow + 1, $this->lastRow + 1));
                $event->sheet->setCellValue(sprintf('A%s', $this->lastRow + 1), 'Total Untung : Rp. '. $this->totalU);
                $event->sheet->getStyle(sprintf('A%s', $this->lastRow + 1))->getFont()->setBold(true);
                $event->sheet->getStyle(sprintf('A%s:J%s', $this->lastRow + 1, $this->lastRow + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A3:J'.$event->sheet->getHighestRow())->applyFromArray([
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
