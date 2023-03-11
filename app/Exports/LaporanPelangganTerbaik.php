<?php

namespace App\Exports;

use App\Models\Barang;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanPelangganTerbaik implements WithProperties, WithEvents, WithHeadings, FromCollection, WithTitle
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
            'title'          => 'Export Excel Laporan Pelanggan Terbaik',
            'description'    => 'Export Excel Data Laporan Pelanggan Terbaik',
            'subject'        => 'Export Excel Laporan Pelanggan Terbaik',
            'keywords'       => 'templates,export,spreadsheet',
            'category'       => 'Export',
            'manager'        => 'Muhamad Fadhil Allifah',
            'company'        => 'SMKN 1 Cianjur',
        ];
    }

    public function title(): string
    {
        return 'Laporan Pelanggan Terbaik';
    }

    public function headings() :array
    {
        return [
            'No',
            'Nama Pelanggan',
            'Telepon',
            'Alamat',
            'Jumlah Beli',
            'Total Beli'
        ];
    }

    public function collection()
    {
        $pelangganTerbaik = Pelanggan::whereBetween('DTP.tgl', [$this->awal, $this->akhir])
        ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id_pelanggan', 't_pelanggan.id')
        ->leftJoin('t_detail_penjualan AS DTP', 'DTP.id_penjualan', 'TP.id')
        ->select('t_pelanggan.id AS id_pelanggan', 't_pelanggan.nama AS nama_pelanggan', 't_pelanggan.tlp AS tlp_pelanggan', 't_pelanggan.alamat AS alamat_pelanggan', DB::raw('sum(DTP.qty) as jumlahBeliBarang'), DB::raw('sum(DTP.qty*DTP.harga_jual) as jumlahBayarBarang'))
        ->where('TP.id_perusahaan', auth()->user()->id_perusahaan)
        ->where('TP.id', '!=', 1)
        ->groupBy('t_pelanggan.id')
        ->orderBy('jumlahBayarBarang', 'DESC')
        ->get();
        // $no = 1;

        // foreach($pelangganTerbaik as $item) {
        // // return $key;
        // $pelangganTerbaik['id_pelanggan'] = $no++;
        // // $pelangganTerbaik['id_pelanggan'] = $item['id_pelanggan'];
        // $pelangganTerbaik['nama_pelanggan'] = $item['nama_pelanggan'];
        // $pelangganTerbaik['tlp_pelanggan'] = $item['tlp_pelanggan'];
        // $pelangganTerbaik['alamat_pelanggan'] = $item['alamat_pelanggan'];
        // $pelangganTerbaik['jumlahBeliBarang'] = $item['jumlahBeliBarang'];
        // $pelangganTerbaik['jumlahBayarBarang'] = 'RP. '. format_uang($item['jumlahBayarBarang']);

        // }      
    
        return $pelangganTerbaik;
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

                $event->sheet->insertNewRowBefore(1, 2);
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->setCellValue('A1', 'Data Pelanggan Terbaik');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getStyle('A3:F'.$event->sheet->getHighestRow())->applyFromArray([
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
