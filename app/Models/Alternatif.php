<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'alternatif';
    protected $fillable = [
        'alternatif',
        'keterangan',
    ];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, "alternatif_id");
    }

    public function perhitungan()
    {
        return $this->hasMany(Perhitungan::class, "alternatif_id");
    }
}
