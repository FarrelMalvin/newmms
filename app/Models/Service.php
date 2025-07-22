<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';
    protected $primaryKey = 'id_service';
    public $timestamps = false;

    protected $fillable = [
        'tanggal',
        'id_cabang',
        'id_pengguna',
        'keluhan',
        'id_tipe_service',
        'jadwal',
        'started_at',
        'finished_at',
        'status',
        'lokasi',
        'tipe_service',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function typeService()
    {
        return $this->belongsTo(TypeService::class, 'id_tipe_service');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}