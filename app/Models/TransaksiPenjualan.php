<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    use HasFactory;
    protected $table = 't_transaksi_penjualan';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tgl', 'id_pelanggan', 'total_harga', 'diskon', 'total_bayar', 'kembalian', 'keuntungan', 'jenis_pembayaran', 'dp', 'sisa', 'id_user', 'id_perusahaan'];
}
