<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perhitungan extends Model
{
    protected $table = 'perhitungan';
    protected $fillable = [
        'alternatif_id',
        'kriteria_id',
        'nilai',
    ];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, "alternatif_id");
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, "kriteria_id");
    }
}
