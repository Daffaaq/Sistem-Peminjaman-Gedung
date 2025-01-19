<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mfakultas extends Model
{
    use HasFactory;

    protected $table = 'mfakultas';

    protected $fillable = [
        'id',
        'NamaFakultas',
        'KodeFakultas',
        'UniversitasID'
    ];

    public function universitas()
    {
        return $this->belongsTo(muniversitas::class, 'UniversitasID');
    }
}
