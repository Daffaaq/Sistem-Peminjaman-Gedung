<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mprodi extends Model
{
    use HasFactory;

    protected $table = 'mprodis';
    
    protected $fillable = [
        'NamaProdi',
        'KodeProdi',
        'JurusanProgramID',
        'FakultasID',
        'strata',
        'StatusProdi',
    ];

    public function JurusanPrograms()
    {
        return $this->belongsTo(mjurusanprogram::class, 'JurusanProgramID');
    }

    public function Fakultas()
    {
        return $this->belongsTo(mfakultas::class, 'FakultasID');
    }
}
