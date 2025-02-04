<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    public function createdby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function fotoalbum()
    {
        return $this->hasMany(Foto::class, 'id');
    }
    
    public function onalbum()
    {
        return $this->hasMany(Foto::class, 'id');
    }
}
