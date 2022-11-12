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

    protected function type(): Attribute 
    {
        // dd($value);
        return new Attribute(
            get: fn($value) => ['super-admin', 'owner', 'admin', 'cashier']
        );
    }

    // public function scopeIsNotAdmin() {
    //     return $querry->where('hak_akses', '!=' , 1);
    // }

    public function isSuperAdmin() {
        if ($this->hak_akses == 'super_admin') {
            return true;
        }
        return false;
    }

    public function isAdmin() {
        if ($this->hak_akses == 'admin') {
            return true;
        }
        return false;
    }

    public function isOwner() {
        if ($this->hak_akses == 'owner') {
            return true;
        }
        return false;
    }

    public function isCashier() {
        if ($this->hak_akses == 'kasir') {
            return true;
        }
        return false;
    }
}
