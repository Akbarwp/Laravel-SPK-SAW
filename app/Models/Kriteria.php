<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $fillable = [
        'kriteria',
        'bobot',
        'jenis_kriteria',
    ];

    public function subKriteria()
    {
        return $this->hasMany(SubKriteria::class, "kriteria_id");
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, "kriteria_id");
    }

    public function matriksKeputusan()
    {
        return $this->hasMany(MatriksKeputusan::class, "alternatif_id");
    }

    public function perhitungan()
    {
        return $this->hasMany(Perhitungan::class, "kriteria_id");
    }
}
