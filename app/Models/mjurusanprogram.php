<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mjurusanprogram extends Model
{
    use HasFactory;

    protected $table = 'mjurusanprograms';

    protected $fillable = [
        'NamaJurusanPrograms',
        'KodeJurusanProgram',
        'FakultasID',
        'UniversitasID',
        'StatusJurusanPrograms',
    ];

    public function fakultas()
    {
        return $this->belongsTo(mfakultas::class, 'FakultasID');
    }

    public function universitas()
    {
        return $this->belongsTo(muniversitas::class, 'UniversitasID');
    }
}
