<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mjurusanprogram extends Model
{
    use HasFactory;

    protected $table = 'mjurusanprograms';

    protected $fillable = [
        'NamaJurusan',
    ];

    public function fakultas()
    {
        return $this->belongsTo(mfakultas::class, 'FakultasID');
    }
}
