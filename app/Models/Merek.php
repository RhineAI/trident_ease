<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merek extends Model
{
    use HasFactory;
    protected $table = 't_merek';
    protected $fillable = ['nama', 'id_perusahaan'];
    protected $primaryKey = 'id';
}
