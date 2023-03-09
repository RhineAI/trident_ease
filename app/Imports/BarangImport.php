<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Merek;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Supplier;

use Maatwebsite\Excel\Concerns\ToModel;  
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;

use PhpOffice\PhpSpreadsheet\Shared\Date;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;


class BarangImport implements WithStartRow, ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // protected $rollback;
    public function  __construct($id_perusahaan, $rollback)
    {
        $this->id_perusahaan = $id_perusahaan;
        $this->rollback = $rollback;
    }

   public function startRow(): int
    {
        return 2;
    }
    
    public function collection(Collection $rows)
    {
        // $blank = true;
        foreach ($rows as $row) 
        {
            // if($row !== null) {
            //     $blank = false;
            // }

            // if($blank) {
            //     return null;
            // }
            DB::beginTransaction();
            try {
                // if ($row[1] != null) {
                    if(strlen($row[1]) <= 3) {
                        $kode = sprintf("%03d", $row[1]);
                    } else {
                        $kode = $row[1];
                    }
                    
                    if(strtolower($row[12]) == 'utama') {
                        $keterangan = 'utama';
                    } else {
                        $keterangan = 'konsinyasi';
                    }
        
                    if(strtolower($row[13]) == 'aktif') {
                        $status = 1;
                    } else {
                        $status = 0;
                    }
                    // dd($status);
                   
                    $compareK = Kategori::where('nama', 'LIKE', ucfirst($row[4]))->first();
                    if ($compareK == true) {
                        $kategori = Kategori::where('nama', ucfirst($row[4]))->first();
                    } else {
                        $kategori = Kategori::create([
                            'nama' => ucfirst($row[4]),
                            'id_perusahaan' => $this->id_perusahaan
                        ]);
                    }
        
                    $compareS = Satuan::where('nama', 'LIKE', ucfirst($row[5]))->first();
                    if ($compareS == true) {
                        $satuan = Satuan::where('nama', ucfirst($row[5]))->first();
                    } else {
                        $satuan = Satuan::create([
                            'nama' => ucfirst($row[5]),
                            'id_perusahaan' => $this->id_perusahaan
                        ]);
                    }
        
                    $compareM = Merek::where('nama', 'LIKE', ucfirst($row[6]))->first();
                    if ($compareM == true) {
                        $merek = Merek::where('nama', ucfirst($row[6]))->first();
                    } else {
                        $merek = Merek::create([
                            'nama' => ucfirst($row[6]),
                            'id_perusahaan' => $this->id_perusahaan
                        ]);
                    }           
                    
                    $compareSp = Supplier::where('nama', 'LIKE', ucfirst($row[7]))->first();
                    if ($compareSp == true) {
                        $supplier = Supplier::where('nama', ucfirst($row[7]))->first();
                    } else {
                        $supplier = Supplier::create([
                                    'nama' => ucfirst($row[7]),
                                    'alamat' => '',
                                    'tlp' => '',
                                    'salesman' => '',
                                    'bank' => '',
                                    'no_rekening' => '',
                                    'id_perusahaan' => $this->id_perusahaan
                                ]);
                    }           
                    
        
                    Barang::create([
                        'kode' => $kode,
                        'nama' => ucfirst($row[2]),
                        'barcode' => $row[4],
                        'id_kategori' => $kategori->id,
                        'id_supplier' => $supplier->id,
                        'id_satuan' => $satuan->id,
                        'id_merek' => $merek->id,
                        'id_perusahaan' => $this->id_perusahaan,
                        'tgl' => '',
                        'stock' => $row[8],
                        'stock_minimal' => $row[9],
                        'harga_beli' => $row[10],
                        'keuntungan' => $row[11],
                        'keterangan' => $keterangan,
                        'status' => $status,
                    ]);
                // } else {
                    // return null;
                // }
            } catch(QueryException | Exception | PDOException $e) {
                DB::rollBack();
                // $rollback = false;
                // return redirect()->back()->with(['error' => 'Terdapat Kesalahan saat Import file!']);
            }
            DB::commit();
    
           
        }
    }
}
