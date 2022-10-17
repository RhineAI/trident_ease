<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 't_barang';
    protected $fillable = ['kode', 'nama', 'barcode', 'tebal', 'panjang', 'id_kategori', 'id_supplier', 'id_satuan', 'id_merek', 'id_perusahaan', 'stock', 'stock_minimal', 'harga_beli', 'keuntungan', 'keterangan', 'status'];
    protected $primaryKey = 'id';
}
