<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 't_transaksi_pembelian';
    protected $fillable = ['id','tgl', 'kode_invoice', 'id_supplier', 'total_pembelian', 'jenis_pembayaran', 'id_user'];
    protected $primaryKey = 'id';
}
