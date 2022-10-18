<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;
    protected $table = 't_detail_pembelian';
    protected $fillable = ['tgl', 'id_pembelian', 'id_barang', 'harga_beli', 'qty'];
    protected $primaryKey = 'id';
}
