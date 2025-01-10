<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatriksKeputusan extends Model
{
    protected $table = 'matriks_keputusan';
    protected $fillable = [
        'alternatif_id',
        'kriteria_id',
        'nilai_rating',
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, "penilaian_id");
    }

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, "alternatif_id");
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, "kriteria_id");
    }
}
