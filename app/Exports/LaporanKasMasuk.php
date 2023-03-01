<?php

namespace App\Exports;

use App\Models\KasMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;

class LaporanKasMasuk implements WithProperties, WithEvents, WithHeadings, FromCollection, WithTitle
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
            'title'          => 'Import Excel Laporan Kas',
            'description'    => 'Import Excel Data Laporan Kas',
            'subject'        => 'Import Excel Laporan Kas',
            'keywords'       => 'templates,import,spreadsheet',
            'category'       => 'Import',
            'manager'        => 'Muhamad Fadhil Allifah',
            'company'        => 'SMKN 1 Cianjur',
        ];
    }

    public function title(): string
    {
        return 'Kas Masuk';
    }

    public function headings() :array
    {
        return [
            'No',
            'Tanggal',
            'Keterangan',
            'Petugas',
            'Jumlah',
        ];
    }

    public function collection()
    {
        $kasMasuk = KasMasuk::whereBetween('tgl', [$this->awal, $this->akhir])
            ->leftJoin('t_users AS U', 'U.id', 't_kas_masuk.id_user')
            ->select('t_kas_masuk.id', 't_kas_masuk.tgl', 't_kas_masuk.keterangan', 'U.nama AS nama_user', 't_kas_masuk.jumlah')  
            ->where('t_kas_masuk.id_perusahaan', auth()->user()->id_perusahaan)
            ->orderBy('id', 'asc')->get();
        // $totalKasData = 0;
        // foreach($kasKeluar as $item) {
        //     $totalKasData += $item->jumlah;
        // } 

        // $this->totalKasKeluar = $totalKasData;
        // $this->countRow = count($kasKeluar);
        return $kasMasuk;
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
                $event->sheet->setCellValue('A1', 'Data Kas Masuk');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // $event->sheet->insertNewRowBefore($this->countRow+1, $this->countRow+2);
                // $event->sheet->mergeCells('A{{  }}:E1');
                // $event->sheet->setCellValue('A1', 'Data Kas Keluar');
                // $event->sheet->getStyle('A1')->getFont()->setBold(true);
                // $event->sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
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
