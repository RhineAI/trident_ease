<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class BarangExport implements WithProperties, WithEvents, WithHeadings, FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id_perusahaan;
    protected $jumlahBarang;
    protected $lastRow;

    public function  __construct($id_perusahaan, $model)
    {
        $this->id_perusahaan = $id_perusahaan;
        $this->jumlahBarang = count($model);
        $this->lastRow = count($model) + 4;
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Muhamad Fadhil Allifah',
            'lastModifiedBy' => 'Muhamad Fadhil Allifah',
            'title'          => 'Export Excel Barang Export',
            'description'    => 'Export Excel Data Barang Export',
            'subject'        => 'Export Excel Barang Export',
            'keywords'       => 'templates,export,spreadsheet',
            'category'       => 'Export',
            'manager'        => 'Muhamad Fadhil Allifah',
            'company'        => 'SMKN 1 Cianjur',
        ];
    }

    public function title(): string
    {
        return 'Barang Export';
    }

    public function headings() :array
    {
        return [
            'No',
            'Kode',
            'Nama Barang',
            'Barcode',
            'Kategori',
            'Supplier',
            'Satuan',
            'Merek',
            'Stok',
            'Stok Minimal',
            'Harga Beli',
            'Keuntungan',
            'Keterangan Barang',
            'Status Barang',
        ];
    }

    public function collection()
    {
        $barang = Barang::leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')
                    ->leftJoin('t_supplier AS SP', 'SP.id', 't_barang.id_supplier')
                    ->leftJoin('t_satuan AS ST', 'ST.id', 't_barang.id_satuan')
                    ->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')
                    ->select('t_barang.id', 't_barang.kode', 't_barang.nama', 't_barang.barcode', 'K.nama AS nama_kategori', 'SP.nama AS nama_supplier', 'ST.nama AS nama_satuan', 'M.nama AS nama_merek', 't_barang.stock', 't_barang.stock_minimal', 't_barang.harga_beli', 't_barang.keuntungan', 't_barang.keterangan', 't_barang.status')     
                    ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan) 
                    ->orderBy('id', 'desc')
                    ->get();

        $index = 1;
        foreach($barang as $item) {
            $item->id = $index;
            $item->keuntungan = $item->keuntungan . '%';
            $item->harga_beli = 'Rp. ' . $item->harga_beli;

            if($item->keterangan === "utama"){
                $item->keterangan = 'Barang Utama';
            } else {
                $item->keterangan = 'Barang Konsinyasi';
            }
            
            if($item->status === 1){
                $item->status = 'Aktif';
            } else {
                $item->status = 'Tidak Aktif';
            }

            $index++;
        } 

        return $barang;
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
                $event->sheet->getColumnDimension('K')->setAutoSize(true);
                $event->sheet->getColumnDimension('L')->setAutoSize(true);
                $event->sheet->getColumnDimension('M')->setAutoSize(true);
                $event->sheet->getColumnDimension('N')->setAutoSize(true);

                $event->sheet->insertNewRowBefore(1, 2);
                $event->sheet->mergeCells('A1:N1');
                $event->sheet->setCellValue('A1', 'Data Produk');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->insertNewRowBefore($this->lastRow, 1);
                $event->sheet->mergeCells(sprintf('A%s:N%s', $this->lastRow, $this->lastRow));
                $event->sheet->setCellValue(sprintf('A%s', $this->lastRow), 'Total Produk : '. $this->jumlahBarang);
                $event->sheet->getStyle(sprintf('A%s', $this->lastRow))->getFont()->setBold(true);
                $event->sheet->getStyle(sprintf('A%s:N%s', $this->lastRow, $this->lastRow))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getStyle('A3:N'.$event->sheet->getHighestRow())->applyFromArray([
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
