<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenilaianRequest;
use App\Http\Resources\PenilaianResource;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Penilaian Alternatif";
        $kriteria = Kriteria::get(['id', 'kriteria'])->sortBy('id', SORT_REGULAR, false);
        $subKriteria = SubKriteria::get()->sortBy('kriteria_id', SORT_REGULAR, false);
        $alternatif = Alternatif::get(['id', 'alternatif'])->sortBy('id', SORT_REGULAR, false);
        $penilaian = PenilaianResource::collection(Penilaian::get()->sortBy('kriteria_id', SORT_REGULAR, false));
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
}
