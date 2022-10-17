<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    protected $table = 't_satuan';
    protected $fillable = ['nama', 'id_perusahaan'];
    protected $primaryKey = 'id';
}
