<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatriksKeputusan extends Model
{
    protected $table = 'matriks_keputusan';
    protected $fillable = [
        'penilaian_id',
        'nilai_rating',
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, "penilaian_id");
    }
}
