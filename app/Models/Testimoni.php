<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $table = 'testimoni';
    protected $primaryKey = 'id_testimoni';
    public $timestamps = true; // Aktifkan timestamps

    protected $fillable = [
        'id_pengguna',
        'id_service',
        'isi_testimoni',
        'menyoroti',
        'rating_bintang',
        'created_at',
        'updated_at'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
        
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service', 'id_service');
    }
}