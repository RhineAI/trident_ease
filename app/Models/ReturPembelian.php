<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPembelian extends Model
{
    use HasFactory;
    protected $fillable = ['id_pembelian', 'tgl', 'totar_retur', 'total_keuntungan', 'id_user'];
    protected $table = 't_retur_pembelian';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
