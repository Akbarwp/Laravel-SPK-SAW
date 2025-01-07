<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_kriteria';
    protected $fillable = [
        'sub_kriteria',
        'bobot',
        'kriteria_id',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, "kriteria_id");
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, "sub_kriteria_id");
    }
}
