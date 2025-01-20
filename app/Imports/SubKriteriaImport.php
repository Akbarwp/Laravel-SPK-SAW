<?php

namespace App\Imports;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SubKriteriaImport implements ToModel, WithStartRow, WithHeadingRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function model(array $row)
    {
        $kriteria = Kriteria::where('kriteria', $row['kriteria'])->first();
        if ($kriteria) {
            return new SubKriteria([
                'kriteria_id' => $kriteria->id,
                'sub_kriteria' => $row['sub_kriteria'],
                'bobot' => $row['bobot'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            //
        }
    }
}
