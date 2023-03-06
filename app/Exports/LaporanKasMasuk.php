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
    protected $lastRow;
    protected $totalKM;

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
            'title'          => 'Export Excel Laporan Kas',
            'description'    => 'Export Excel Data Laporan Kas',
            'subject'        => 'Export Excel Laporan Kas',
            'keywords'       => 'templates,export,spreadsheet',
            'category'       => 'Export',
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
        
        foreach($kasMasuk as $item) {
            $this->totalKM += $item->jumlah;
        } 

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

                $event->sheet->insertNewRowBefore($this->lastRow, 1);
                $event->sheet->mergeCells(sprintf('A%s:E%s', $this->lastRow, $this->lastRow));
                $event->sheet->setCellValue(sprintf('A%s', $this->lastRow), 'Total Kas Masuk : Rp. '. $this->totalKM);
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
