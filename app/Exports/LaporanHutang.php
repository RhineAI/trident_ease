<?php

namespace App\Exports;

use App\Models\DetailPembelian;
use App\Models\Hutang;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanHutang implements WithProperties, WithEvents, WithHeadings, FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id_perusahaan;
    protected $awal;
    protected $akhir;
    protected $lastRow;
    protected $totalH;

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
            'title'          => 'Export Excel Laporan Hutang',
            'description'    => 'Export Excel Data Laporan Hutang',
            'subject'        => 'Export Excel Laporan Hutang',
            'keywords'       => 'templates,export,spreadsheet',
            'category'       => 'Export',
            'manager'        => 'Muhamad Fadhil Allifah',
            'company'        => 'SMKN 1 Cianjur',
        ];
    }

    public function title(): string
    {
        return 'Laporan Hutang';
    }

    public function headings() :array
    {
        return [
            'Kode Pembelian',
            'Tanggal',
            'Supplier',
            'Status',
            'Dibayar',
        ];
    }

    public function collection()
    {
        $hutang = Hutang::whereBetween('t_data_hutang.tgl', [$this->awal, $this->akhir])
        ->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_data_hutang.id_pembelian')
        ->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')
        ->select('t_data_hutang.id_pembelian', 't_data_hutang.tgl', 'S.nama AS nama_supplier', 'TP.sisa', 't_data_hutang.total_bayar')  
        ->where('t_data_hutang.id_perusahaan', auth()->user()->id_perusahaan)
        ->orderBy('TP.id', 'desc')->get();

        foreach($hutang as $item) {
            $this->totalH += $item->total_bayar;
            if($item->sisa == 0){
                $item->sisa = 'Lunas';
            } else {
                $item->sisa = 'Belum Lunas';
            }
        } 

        return $hutang;
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
                $event->sheet->setCellValue('A1', 'Data Hutang');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->insertNewRowBefore($this->lastRow, 1);
                $event->sheet->mergeCells(sprintf('A%s:E%s', $this->lastRow, $this->lastRow));
                $event->sheet->setCellValue(sprintf('A%s', $this->lastRow), 'Total Hutang : Rp. '. $this->totalH);
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
