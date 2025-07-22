<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false;
    protected $fillable = [
        'nama', 'username', 'password', 'peran', 'no_hp'
    ];

    protected $hidden = [
        'password',
    ];

    public function adminDetail()
    {
        return $this->hasOne(PenggunaAdmin::class, 'id_pengguna', 'id_pengguna');
    }

    public function service() {
        return $this->hasMany(Service::class, 'id_pengguna', 'id_pengguna');
    }

} 