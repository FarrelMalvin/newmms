<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    public $timestamps = true;

    protected $fillable = [
        'judul_berita',
        'deskripsi',
        'foto',
        'konten',
        'judul',    
        'created_at',
        'updated_at'
    ];
}