<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReturPenjualan extends Model
{
    use HasFactory;
    protected $fillable = ['id_retur_penjualan', 'id_barang', 'qty', 'harga_beli', 'harga_jual', 'sub_total', 'keuntungan', 'id_user'];
    protected $table = 't_det_retur_penjualan';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
