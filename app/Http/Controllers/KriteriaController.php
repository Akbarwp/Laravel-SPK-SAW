<?php

namespace App\Http\Controllers;

use App\Http\Requests\KriteriaRequest;
use App\Http\Resources\KriteriaResource;
use App\Imports\KriteriaImport;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Kriteria";
        $kriteria = KriteriaResource::collection(Kriteria::orderBy('created_at', 'asc')->get());
        $sumBobot = $kriteria->sum('bobot');
        return view('dashboard.kriteria.index', compact('title', 'kriteria', 'sumBobot'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KriteriaRequest $request)
    {
        $validated = $request->validated();

        $this->checkSumBobot($request->id, $validated['bobot']);

        $kriteria = Kriteria::create($validated);
        $createPenilaian = false;
        $alternatif = Alternatif::get('id');
        if ($alternatif->first()) {
            foreach ($alternatif as $item) {
                $createPenilaian = Penilaian::create([
                    'alternatif_id' => $item->id,
                    'kriteria_id' => $kriteria->id,
                    'sub_kriteria_id' => null,
                ]);
            }
        }

        if ($createPenilaian) {
            return to_route('kriteria')->with('success', 'Kriteria Berhasil Disimpan');
        } else {
            return to_route('kriteria')->with('error', 'Kriteria Gagal Disimpan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $kriteria = Kriteria::find($request->kriteria_id);
        return $kriteria;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KriteriaRequest $request)
    {
        $validated = $request->validated();

        $this->checkSumBobot($request->id, $validated['bobot']);

        $perbarui = Kriteria::where('id', $request->id)->update($validated);
        if ($perbarui) {
            return to_route('kriteria')->with('success', 'Kriteria Berhasil Diperbarui');
        } else {
            return to_route('kriteria')->with('error', 'Kriteria Gagal Diperbarui');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        Penilaian::where('kriteria_id', $request->kriteria_id)->delete();
        SubKriteria::where('kriteria_id', $request->kriteria_id)->delete();
        $hapus = Kriteria::where('id', $request->kriteria_id)->delete();
        if ($hapus) {
            return to_route('kriteria')->with('success', 'Kriteria Berhasil Dihapus');
        } else {
            return to_route('kriteria')->with('error', 'Kriteria Gagal Dihapus');
        }
    }

    public function checkSumBobot($kriteria_id, $bobot)
    {
        $sumBobot = Kriteria::where('id', '!=', $kriteria_id)->sum('bobot') + $bobot;
        if ($sumBobot > 1) {
            throw ValidationException::withMessages(['bobot' => 'Total bobot tidak boleh lebih dari 1']);
        }
        return true;
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_data' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('import_data');
        Excel::import(new KriteriaImport, $file);

        $kriteria = Kriteria::get('id');
        $alternatif = Alternatif::get('id');
        if ($alternatif->first()) {
            Penilaian::truncate();
            foreach ($kriteria as $value) {
                foreach ($alternatif as $item) {
                    $createPenilaian = Penilaian::create([
                        'alternatif_id' => $item->id,
                        'kriteria_id' => $value->id,
                        'sub_kriteria_id' => null,
                    ]);
                }
            }
        }

        if ($createPenilaian) {
            return to_route('kriteria')->with('success', 'Kriteria Berhasil Disimpan');
        } else {
            return to_route('kriteria')->with('error', 'Kriteria Gagal Disimpan');
        }
    }
}
