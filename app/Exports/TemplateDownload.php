<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class TemplateDownload implements WithColumnWidths, WithProperties, WithEvents, WithHeadings, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Barang::leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')
    //                 ->leftJoin('t_supplier AS SP', 'SP.id', 't_barang.id_supplier')
    //                 ->leftJoin('t_satuan AS ST', 'ST.id', 't_barang.id_satuan')
    //                 ->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')
    //                 ->select('t_barang.kode', 't_barang.nama', 't_barang.barcode', 't_barang.tgl', 't_barang.stock', 't_barang.stock_minimal', 't_barang.harga_beli', 't_barang.keuntungan', 't_barang.keterangan', 't_barang.status', 'K.nama AS nama_kategori', 'SP.nama AS nama_supplier', 'ST.nama AS nama_satuan', 'M.nama AS nama_merek')     
    //                 ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan) 
    //                 ->orderBy('t_barang.id', 'desc')
    //                 ->get();
    // }

    public function properties(): array
    {
        return [
            'creator'        => 'Luhung Lugina',
            'lastModifiedBy' => 'Luhung Lugina',
            'title'          => 'Template Import',
            'description'    => 'Template for you before import some data from excel to this website',
            'subject'        => 'Templates',
            'keywords'       => 'templates,export,spreadsheet',
            'category'       => 'Templates',
            'manager'        => 'Luhung Lugina',
            'company'        => 'ZIE',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'B' => 14,
            'C' => 28,            
            'D' => 16,            
            'E' => 18,            
            'F' => 18,            
            'G' => 18,            
            'H' => 18,            
            'I' => 12,            
            'J' => 10,            
            'K' => 10,            
            'L' => 18,            
            'M' => 16,            
            'N' => 40,            
            'O' => 19,            
        ];
    }


    public function headings() :array
    {
        return [
            '',
            'Kode',
            'Produk',
            'Barcode',
            'Kategori',
            'Supplier',
            'Satuan',
            'Merek',
            'Tanggal',
            'Stok',
            'Min.Stok',
            'Harga Beli',
            'Keuntungan(%)',
            'Keterangan Barang(Utama/Konsinyasi)',
            'Status(Aktif/Tidak)',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getStyle('A1:O1')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
   
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
