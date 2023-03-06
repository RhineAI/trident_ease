<?php

namespace App\Exports;

use App\Models\Barang;
use App\Models\Penyesuaian;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanStokOpname implements WithProperties, WithEvents, WithHeadings, FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id_perusahaan;
    protected $awal;
    protected $akhir;
    protected $merek;
    protected $kategori;

    public function  __construct($id_perusahaan, $awal, $akhir, $merek, $kategori)
    {
        $this->id_perusahaan = $id_perusahaan;
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->merek = $merek;
        $this->kategori = $kategori;
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Muhamad Fadhil Allifah',
            'lastModifiedBy' => 'Muhamad Fadhil Allifah',
            'title'          => 'Export Excel Laporan Stok Opname',
            'description'    => 'Export Excel Data Laporan Stok Opname',
            'subject'        => 'Export Excel Laporan Stok Opname',
            'keywords'       => 'templates,export,spreadsheet',
            'category'       => 'Export',
            'manager'        => 'Muhamad Fadhil Allifah',
            'company'        => 'SMKN 1 Cianjur',
        ];
    }

    public function title(): string
    {
        return 'Laporan Stok Opname';
    }

    public function headings() :array
    {
        return [
            'No',
            'Tanggal',
            'Kode',
            'Nama Barang',
            'Merek',
            'Kategori',
            'Stok Sistem',
            'Stok Baru',
            'Selisih'
        ];
    }

    public function collection()
    {
        $stokOpname = Penyesuaian::whereBetween('t_penyesuaian.tgl', [$this->awal, $this->akhir])
        ->where('id_merek', $this->merek)
        ->where('id_kategori', $this->kategori)
        ->leftJoin('t_barang AS B', 'B.id', 't_penyesuaian.id_barang')
        ->leftJoin('t_kategori AS K', 'K.id', 'B.id_kategori')
        ->leftJoin('t_merek AS M', 'M.id', 'B.id_merek')
        ->select('B.id', 't_penyesuaian.tgl', 'B.kode', 'B.nama', 'M.nama AS nama_merek', 'K.nama AS nama_kategori',  't_penyesuaian.stock_awal', 't_penyesuaian.stock_baru', DB::raw('t_penyesuaian.stock_baru - t_penyesuaian.stock_awal'))
        ->where('t_penyesuaian.id_perusahaan', auth()->user()->id_perusahaan)
        ->orderBy('id', 'DESC')->get();
    
        return $stokOpname;
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

                $event->sheet->insertNewRowBefore(1, 2);
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->setCellValue('A1', 'Data Stok Opname');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getStyle('A3:I'.$event->sheet->getHighestRow())->applyFromArray([
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
