<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Merek;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class BarangImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function  __construct($id_perusahaan)
    {
        $this->id_perusahaan = $id_perusahaan;
    }
    

    public function model(array $row)
    {
        // return new Barang([
        //     'kode' => $row[1],
        //     'nama' => $row[2],
        //     'barcode' => $row[3],
        //     'id_kategori' => $row[4],
        //     'id_supplier' => $row[5],
        //     'id_satuan' => $row[6],
        //     'id_merek' => $row[7],
        //     'id_perusahaan' => $row[8],
        //     'tgl' => $row[8],
        //     'stock' => $row[9],
        //     'stock_minimal' => $row[10],
        //     'harga_beli' => $row[11],
        //     'keterangan' => $row[12],
        //     'status' => $row[13],
        // ]);

        $kategori = Kategori::create([
            'nama' => $row[4],
            'id_perusahaan' => $this->id_perusahaan
        ]);

        $satuan = Satuan::create([
            'nama' => $row[5],
            'id_perusahaan' => $this->id_perusahaan
        ]);

        $merek = Merek::create([
            'nama' => $row[6],
            'id_perusahaan' => $this->id_perusahaan
        ]);
        
        $supplier = Supplier::create([
            'nama' => $row[7],
            'alamat' => '',
            'tlp' => '',
            'salesman' => '',
            'bank' => '',
            'no_rekening' => '',
            'id_perusahaan' => $this->id_perusahaan
        ]);

        if ($row[13] == 'aktif' or $row[13] == 'Aktif' or $row[13] == 'AKTIF' ) {
            $status = 1;
        } elseif($row[13] == 'Status' or $row[13] == 'status') {
            $status = 3;
        } else {
            $status = 2;
        }

        $barang = Barang::create([
            'kode' => $row[1],
            'nama' => $row[2],
            'barcode' => $row[3],
            'id_kategori' => $kategori->id,
            'id_supplier' => $supplier->id,
            'id_satuan' => $satuan->id,
            'id_merek' => $merek->id,
            'id_perusahaan' => $this->id_perusahaan,
            'tgl' => 1,
            'stock' => $row[8],
            'stock_minimal' => $row[9],
            'harga_beli' => $row[10],
            'keuntungan' => $row[11],
            'keterangan' => $row[12],
            'status' => $status,
        ]);

        $barang = Barang::where('status', 3)->delete();
        // $delete = $barang->id;
        // $delete->destroy();
    }
}
