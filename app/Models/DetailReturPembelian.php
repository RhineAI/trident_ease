<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReturPembelian extends Model
{
    use HasFactory;
    protected $fillable = ['id_retur_pembelian', 'id_barang', 'qty', 'harga_beli', 'harga_jual', 'sub_total', 'keuntungan', 'id_user'];
    protected $table = 't_det_retur_pembelian';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
