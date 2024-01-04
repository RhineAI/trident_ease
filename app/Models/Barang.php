<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 't_barang';
    protected $fillable = ['kode', 'nama', 'barcode', 'id_kategori', 'id_supplier', 'id_satuan', 'id_merek', 'id_perusahaan', 
    'stock', 'stock_minimal', 'harga_beli', 'keuntungan', 'keterangan', 'status'];
    protected $primaryKey = 'id';

    public $with = ['merek', 'kategori', 'satuan'];
    // private $key = 'modifier';

    /**
     * Get all of the comments for the Barang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function merek()
    {
        return $this->hasOne(Merek::class, 'id', 'id_merek');
    }

    public function kategori()
    {
        return $this->hasOne(Kategori::class, 'id', 'id_kategori');
    }

    public function satuan()
    {
        return $this->hasOne(Satuan::class, 'id', 'id_satuan');
    }
}
