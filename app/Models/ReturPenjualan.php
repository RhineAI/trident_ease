<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPenjualan extends Model
{
    use HasFactory;
    protected $fillable = ['id_penjualan', 'tgl', 'totar_retur', 'total_keuntungan', 'id_user'];
    protected $table = 't_retur_penjualan';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
