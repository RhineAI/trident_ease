<?php

namespace App\Exports;

use App\Models\DetailPenjualan;
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
    protected $totalU;
    protected $totalO;

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
            'title'          => 'Import Excel Laporan Penjualan',
            'description'    => 'Import Excel Data Laporan Penjualan',
            'subject'        => 'Import Excel Laporan Penjualan',
            'keywords'       => 'templates,import,spreadsheet',
            'category'       => 'Import',
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
                                ->select('t_detail_penjualan.id_penjualan as id', 't_detail_penjualan.tgl', 'B.kode', 'B.nama AS nama_barang', 't_detail_penjualan.qty', 't_detail_penjualan.diskon', 't_detail_penjualan.harga_beli', 't_detail_penjualan.harga_jual')
                                ->whereBetween('t_detail_penjualan.tgl', [$this->awal, $this->akhir])
                                ->where('t_detail_penjualan.id_perusahaan', $this->id_perusahaan)->get();
        // $data['no'] = 0;
        $data['totalU'] = 0;
        $data['totalO'] = 0;
        foreach($detPenjualan as $item) {
            if($item->diskon != 0) {
                $countUntung = (($item->harga_jual - $item->harga_beli) * $item->qty) - ( ($item->harga_jual - $item->harga_beli) * $item->qty) * $item->diskon/100;
                $data['totalU'] += $countUntung;
            } else {
                $countUntung = ($item->harga_jual - $item->harga_beli) * $item->qty;
                $data['totalU'] += $countUntung;
            }
            $countOmset = $item->harga_jual * $item->qty;
            $data['totalO'] += $countOmset;
        }
        $this->totalO = $data['totalO'];
        $this->totalU = $data['totalU'];

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

                $event->sheet->insertNewRowBefore(1, 2);
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->setCellValue('A1', 'Data Penjualan');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // $event->sheet->insertNewRowBefore($this->countRow+1, $this->countRow+2);
                // $event->sheet->mergeCells('A{{  }}:E1');
                // $event->sheet->setCellValue('A1', 'Data Kas Keluar');
                // $event->sheet->getStyle('A1')->getFont()->setBold(true);
                // $event->sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getStyle('A3:H'.$event->sheet->getHighestRow())->applyFromArray([
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
