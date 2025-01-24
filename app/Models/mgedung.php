<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mgedung extends Model
{
    use HasFactory;

    protected $table = 'mgedungs';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'NamaGedung',
        'KodeGedung',
        'JumlahLantaiGedung',
        'kapasitasGedung',
        'FakultasID',
        'JurusanProgramID',
        'UniversitasID',
        'StatusGedung',
        'TipeGedung',
        'Keterangan',
        'statusGedungMandiri',
    ];

    public function universitas()
    {
        return $this->belongsTo(muniversitas::class, 'UniversitasID');
    }

    public function JurusanPrograms()
    {
        return $this->belongsTo(mjurusanprogram::class, 'JurusanProgramID');
    }

    public function Fakultas()
    {
        return $this->belongsTo(mfakultas::class, 'FakultasID');
    }
}
