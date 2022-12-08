<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $table = 't_detail_penjualan';
    protected $primaryKey = 'id';
    // protected $fillable = ['tgl', 'id_penjualan', 'id_barang', 'harga_jual', 'qty'];
    protected $guarded = [];
}
