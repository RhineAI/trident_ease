<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    use HasFactory;
    protected $fillable = ['id_pembelian', 'tgl', 'total_bayar', 'id_user'];
    protected $table = 't_data_hutang';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
