<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = ['id_penjualan', 'tgl', 'total_bayar', 'id_user'];
    protected $table = 't_pembayaran';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
