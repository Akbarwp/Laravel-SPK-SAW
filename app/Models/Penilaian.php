<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaian';
    protected $fillable = [
        'alternatif_id',
        'kriteria_id',
        'sub_kriteria_id',
    ];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, "alternatif_id");
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, "kriteria_id");
    }

    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class, "sub_kriteria_id");
    }

    public function matriksKeputusan()
    {
        return $this->hasMany(MatriksKeputusan::class, "penilaian_id");
    }
}
