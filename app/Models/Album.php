<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'created_by',
        'deskripsi'
    ];

    public function createdby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function fotoalbum()
    {
        return $this->hasMany(Foto::class, 'albumId');
    }
    
    public function onalbum()
    {
        return $this->hasMany(Foto::class, 'id');
    }

    
    public function countlikesalbum()
    {
        return $this->hasMany(Like::class, 'albumId');
    }
}
