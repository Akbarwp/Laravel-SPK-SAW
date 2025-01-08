<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubKriteriaRequest;
use App\Http\Resources\KriteriaResource;
use App\Http\Resources\SubKriteriaResource;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Sub Kriteria";
        $kriteria = KriteriaResource::collection(Kriteria::get()->sortBy('created_at', SORT_REGULAR, false));
        $subKriteria = SubKriteriaResource::collection(SubKriteria::get()->sortBy('bobot', SORT_REGULAR, true));
        return view('dashboard.sub-kriteria.index', compact('title', 'kriteria', 'subKriteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubKriteriaRequest $request)
    {
        $validated = $request->validated();

        $simpan = SubKriteria::create($validated);
        if ($simpan) {
            return to_route('sub-kriteria')->with('success', 'Sub Kriteria '.$request->kriteria_nama.' Berhasil Disimpan');
        } else {
            return to_route('sub-kriteria')->with('error', 'Sub Kriteria '.$request->kriteria_nama.' Gagal Disimpan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $subKriteria = SubKriteria::with('kriteria')->find($request->sub_kriteria_id);
        return $subKriteria;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubKriteriaRequest $request)
    {
        $validated = $request->validated();

        $perbarui = SubKriteria::where('id', $request->id)->update($validated);
        if ($perbarui) {
            return to_route('sub-kriteria')->with('success', 'Sub Kriteria '.$request->kriteria_nama.' Berhasil Diperbarui');
        } else {
            return to_route('sub-kriteria')->with('error', 'Sub Kriteria '.$request->kriteria_nama.' Gagal Diperbarui');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        Penilaian::where('sub_kriteria_id', $request->sub_kriteria_id)->update(['sub_kriteria_id' => null]);
        $hapus = SubKriteria::where('id', $request->sub_kriteria_id)->delete();
        if ($hapus) {
            return to_route('sub-kriteria')->with('success', 'Sub Kriteria '.$request->kriteria_nama.' Berhasil Dihapus');
        } else {
            return to_route('sub-kriteria')->with('error', 'Sub Kriteria '.$request->kriteria_nama.' Gagal Dihapus');
        }
    }
}
