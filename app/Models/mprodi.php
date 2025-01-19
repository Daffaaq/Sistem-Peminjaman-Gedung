<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mprodi extends Model
{
    use HasFactory;

    protected $table = 'mprodi';
    
    protected $fillable = [
        'NamaProdi',
        'KodeProdi',
        'FakultasID',
    ];

    public function fakultas()
    {
        return $this->belongsTo(mfakultas::class, 'FakultasID');
    }
}
