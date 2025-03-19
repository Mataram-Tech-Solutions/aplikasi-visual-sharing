<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;
    protected $fillable = [
        'uploaded_by',
        'judul',
        'unique',
        'namaFile',
        'deskripsi',
        'albumId',
    ];

    public function uploadby()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function fotoalbum()
    {
        return $this->belongsTo(Album::class, 'id');
    }

    public function onalbum()
    {
        return $this->belongsTo(Album::class, 'albumId');
    }

    public function countlikes()
    {
        return $this->hasMany(Like::class, 'fotoId');
    }

    public function countcoment() 
    {
        return $this->hasMany(Komentar::class, 'fotoId');
    }
}
