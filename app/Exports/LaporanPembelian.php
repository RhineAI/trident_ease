<?php

namespace App\Exports;

use App\Models\DetailPembelian;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanPembelian implements WithProperties, WithEvents, WithHeadings, FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id_perusahaan;
    protected $awal;
    protected $akhir;
    protected $lastRow;
    protected $totalP;

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
            'title'          => 'Export Excel Laporan Pembelian',
            'description'    => 'Export Excel Data Laporan Pembelian',
            'subject'        => 'Export Excel Laporan Pembelian',
            'keywords'       => 'templates,export,spreadsheet',
            'category'       => 'Export',
            'manager'        => 'Muhamad Fadhil Allifah',
            'company'        => 'SMKN 1 Cianjur',
        ];
    }

    public function title(): string
    {
        return 'Laporan Pembelian';
    }

    public function headings() :array
    {
        return [
            'No',
            'Tanggal',
            'Kode',
            'Nama Barang',
            'Qty',
            'Harga Beli',
            'Subtotal'
        ];
    }

    public function collection()
    {
        $detPembelian = DetailPembelian::leftJoin('t_barang AS B', 'B.id', 't_detail_pembelian.id_barang')
                                ->select('t_detail_pembelian.id_pembelian as id', 't_detail_pembelian.tgl', 'B.kode', 'B.nama AS nama_barang', 't_detail_pembelian.qty', 't_detail_pembelian.harga_beli', DB::raw('t_detail_pembelian.harga_beli * t_detail_pembelian.qty'))
                                ->whereBetween('t_detail_pembelian.tgl', [$this->awal, $this->akhir])
                                ->where('t_detail_pembelian.id_perusahaan', $this->id_perusahaan)->get();

        foreach($detPembelian as $item) {
            $countOmset = ($item->harga_beli * $item->qty) - (($item->harga_beli * $item->qty) * $item->diskon/100);
            $this->totalP += $countOmset;
        }  
        return $detPembelian;
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

                $event->sheet->insertNewRowBefore(1, 2);
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->setCellValue('A1', 'Data Pembelian');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->insertNewRowBefore($this->lastRow, 1);
                $event->sheet->mergeCells(sprintf('A%s:G%s', $this->lastRow, $this->lastRow));
                $event->sheet->setCellValue(sprintf('A%s', $this->lastRow), 'Total Pembelian : Rp. '. $this->totalP);
                $event->sheet->getStyle(sprintf('A%s', $this->lastRow))->getFont()->setBold(true);
                $event->sheet->getStyle(sprintf('A%s:G%s', $this->lastRow, $this->lastRow))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getStyle('A3:G'.$event->sheet->getHighestRow())->applyFromArray([
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
