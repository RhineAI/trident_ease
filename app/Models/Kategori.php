<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 't_kategori';
    protected $fillable = ['nama', 'id_perusahaan'];
    protected $primaryKey = 'id';
}
