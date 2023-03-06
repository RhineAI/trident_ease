<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanStok implements WithProperties, WithEvents, WithHeadings, FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id_perusahaan;
    protected $merek;
    protected $kategori;

    public function  __construct($id_perusahaan, $merek, $kategori)
    {
        $this->id_perusahaan = $id_perusahaan;
        $this->merek = $merek;
        $this->kategori = $kategori;
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Muhamad Fadhil Allifah',
            'lastModifiedBy' => 'Muhamad Fadhil Allifah',
            'title'          => 'Export Excel Laporan Stok',
            'description'    => 'Export Excel Data Laporan Stok',
            'subject'        => 'Export Excel Laporan Stok',
            'keywords'       => 'templates,export,spreadsheet',
            'category'       => 'Export',
            'manager'        => 'Muhamad Fadhil Allifah',
            'company'        => 'SMKN 1 Cianjur',
        ];
    }

    public function title(): string
    {
        return 'Laporan Stok';
    }

    public function headings() :array
    {
        return [
            'No',
            'Kode',
            'Nama Barang',
            'Merek',
            'Kategori',
            'Stok Minimal',
            'Stok Sekarang'
        ];
    }

    public function collection()
    {
        $stok = Barang::where('id_merek', $this->merek)
            ->orWhere('id_kategori', $this->kategori)
            ->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')
            ->leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')
            ->select('t_barang.id', 't_barang.kode', 't_barang.nama', 'M.nama AS nama_merek', 'K.nama AS nama_kategori', 't_barang.stock_minimal', 't_barang.stock')    
            ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan)
            ->orderBy('kode', 'asc')->get();
    
        return $stok;
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
                $event->sheet->setCellValue('A1', 'Data Stok');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
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
