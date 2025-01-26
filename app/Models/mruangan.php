<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mruangan extends Model
{
    use HasFactory;

    protected $table = 'mruangans';

    protected $fillable = [
        'NamaRuang',
        'KodeRuang',
        'KapasitasRuang',
        'GedungID',
        'StatusRuang',
        'StatusBooked',
        'Keterangan',
    ];

    public function gedung()
    {
        return $this->belongsTo(mgedung::class, 'GedungID');
    }
}
