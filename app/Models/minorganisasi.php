<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class minorganisasi extends Model
{
    use HasFactory;

    protected $table = 'minorganisasis';

    // Mass assignable attributes
    protected $fillable = [
        'NamaInternalOrganisasi',
        'KodeInternalOrganisasi',
        'FakultasID',
        'JurusanProgramID',
        'UniversitasID',
        'StatusInternalOrganisasi',
        'TipeOrganisasi',
        'Keterangan',
    ];

    public function Universitas ()
    {
        return $this->belongsTo(muniversitas::class, 'UniversitasID');
    }

    public function Fakultas ()
    {
        return $this->belongsTo(mfakultas::class, 'FakultasID');
    }

    public function JurusanProgram ()
    {
        return $this->belongsTo(mjurusanprogram::class, 'JurusanProgramID');
    }
}
