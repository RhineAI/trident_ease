<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 't_supplier';
    protected $fillable = ['nama', 'alamat', 'tlp', 'salesman', 'bank', 'no_rekening', 'id_perusahaan'];
    protected $primaryKey = 'id';
    
}
