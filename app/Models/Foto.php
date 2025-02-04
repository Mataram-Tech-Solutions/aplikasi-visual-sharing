<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    public function uploadby()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function fotoalbum()
    {
        return $this->belongsTo(Album::class, 'albumId');
    }

    public function onalbum()
    {
        return $this->belongsTo(Album::class, 'albumId');
    }
}
