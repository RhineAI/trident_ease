<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 't_users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama', 
        'alamat', 
        'tlp',
        'username',
        'password',
        'hak_akses',
        'id_perusahaan'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function role(): Attribute 
    {
        return new Attribute(
            get: fn($value) => ['super-admin']['$value']
        );
    }

    public function scopeIsNotAdmin() {
        // if($querry['hak_akses'] != 1) {
        //     return $query;
        // } elseif($querry['hak_akses'] !=3) {
        //     return $query;
        // }
        return $querry->where('hak_akses', '!=' , 1)->orWhere('hak_akses', '!=', 3);
    }

    // public function scopeIsNotSuperAdmin() {
    //     return $query->where('hak_akses', '!=' , 3);
    // }

}
