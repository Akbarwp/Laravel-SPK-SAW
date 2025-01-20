<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenilaianRequest;
use App\Http\Resources\PenilaianResource;
use App\Imports\PenilaianImport;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Penilaian Alternatif";
        $kriteria = Kriteria::orderBy('id', 'asc')->get(['id', 'kriteria']);
        $subKriteria = SubKriteria::orderBy('kriteria_id', 'asc')->get();
        $alternatif = Alternatif::orderBy('id', 'asc')->get(['id', 'alternatif']);
        $penilaian = PenilaianResource::collection(Penilaian::orderBy('kriteria_id', 'asc')->get());
        return view('dashboard.penilaian.index', compact('title', 'kriteria', 'subKriteria', 'alternatif', 'penilaian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $penilaian = Penilaian::where('alternatif_id', $request->alternatif_id)->get();
        return $penilaian;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenilaianRequest $request)
    {
        $validated = $request->validated();

        foreach ($validated['kriteria_id'] as $value => $item) {
            $perbarui = Penilaian::query()
                ->where('alternatif_id', $validated['alternatif_id'])
                ->where('kriteria_id', $validated['kriteria_id'][$value])
                ->update([
                    'sub_kriteria_id' => $validated['sub_kriteria_id'][$value],
                ]);
        }

        if ($perbarui) {
            return to_route('penilaian')->with('success', 'Penilaian Alternatif Berhasil Diperbarui');
        } else {
            return to_route('penilaian')->with('error', 'Penilaian Alternatif Gagal Diperbarui');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_data' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('import_data');
        $import = Excel::import(new PenilaianImport, $file);

        if ($import) {
            return to_route('penilaian')->with('success', 'Penilaian Berhasil Disimpan');
        } else {
            return to_route('penilaian')->with('error', 'Penilaian Gagal Disimpan');
        }
    }
}
