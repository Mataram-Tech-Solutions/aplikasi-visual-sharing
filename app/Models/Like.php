<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'fotoId',
    ];

    public function photo()
    {
        return $this->belongsTo(Foto::class);
    }

    public function likedby() {
        return $this->belongsTo(User::class, 'id');
    }
}
