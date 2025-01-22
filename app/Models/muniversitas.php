<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class muniversitas extends Model
{
    use HasFactory;

    protected $table = 'muniversitas';

    protected $fillable = [
        'NamaUniversitas',
        'KodeUniversitas',
        'AlamatUniversitas',
        'NoTelpUniversitas',
        'EmailUniversitas',
        'StatusUniversitas',
        'TipeInstitusi',
    ];
    
}
