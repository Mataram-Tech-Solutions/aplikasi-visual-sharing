<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;
    protected $fillable = [
        'isikomen',
        'created_by',
        'fotoId'
    ];

    public function photo()
    {
        return $this->belongsTo(Foto::class);
    }

    public function komentarby() {
        return $this->belongsTo(User::class, 'id');
    }
}
