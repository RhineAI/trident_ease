<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'alamat', 'tlp', 'pemilik', 'bank', 'no_rekening', 'npwp', 'slogan', 'email', 'logo', 'grade', 'startDate', 'expiredDate'];
    protected $table = 't_perusahaan';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
