<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mexorganisasi extends Model
{
    use HasFactory;

    protected $table = 'mexorganisasis';

    protected $fillable = [
        'NamaEksternalOrganisasi',
        'KodeEksternalOrganisasi',
        'FakultasID',
        'JurusanProgramID',
        'UniversitasID',
        'StatusEksternalOrganisasi',
        'Keterangan'
    ];

    public function Fakultas()
    {
        return $this->belongsTo(mfakultas::class, 'FakultasID');
    }

    public function Universitas()
    {
        return $this->belongsTo(muniversitas::class, 'UniversitasID');
    }

    public function JurusanProgram()
    {
        return $this->belongsTo(mjurusanprogram::class, 'JurusanProgramID');
    }
}
