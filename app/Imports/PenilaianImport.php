<?php

namespace App\Imports;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PenilaianImport implements ToModel, WithStartRow, WithHeadingRow
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
        $alternatif = Alternatif::where('alternatif', 'LIKE', '%'.$row['alternatif'].'%')->first();
        foreach (Kriteria::orderBy('id', 'asc')->get() as $item => $value) {
            $subKriteria = SubKriteria::where('kriteria_id', $value->id)->where('sub_kriteria', $row['kriteria'.$item+1])->first();
            Penilaian::query()
            ->where('kriteria_id', $value->id)
            ->where('alternatif_id', $alternatif->id)
            ->update([
                'alternatif_id' => $alternatif->id,
                'sub_kriteria_id' => $subKriteria->id,
                'kriteria_id' => $value->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        return;
    }
}
