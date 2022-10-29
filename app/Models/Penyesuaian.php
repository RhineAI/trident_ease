<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyesuaian extends Model
{
    use HasFactory;
    protected $table = 't_penyesuaian';
    protected $fillable = ['tgl', 'id_barang', 'stock_awal', 'stock_baru', 'id_user'];
    protected $primaryKey = 'id';
    protected $guarded = [];
}
