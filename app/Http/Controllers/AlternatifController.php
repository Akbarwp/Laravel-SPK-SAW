<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlternatifRequest;
use App\Http\Resources\AlternatifResource;
use App\Models\Alternatif;
use App\Models\MatriksKeputusan;
use App\Models\Penilaian;
use App\Models\Perhitungan;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Alternatif";
        $alternatif = AlternatifResource::collection(Alternatif::all()->sortBy('created_at', SORT_REGULAR, true));
        return view('dashboard.alternatif.index', compact('title', 'alternatif'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlternatifRequest $request)
    {
        $validated = $request->validated();

        $simpan = Alternatif::create($validated);
        if ($simpan) {
            return to_route('alternatif')->with('success', 'Alternatif Berhasil Disimpan');
        } else {
            return to_route('alternatif')->with('error', 'Alternatif Gagal Disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $alternatif = new AlternatifResource(Alternatif::find($request->alternatif_id));
        return $alternatif;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $alternatif = Alternatif::find($request->alternatif_id);
        return $alternatif;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlternatifRequest $request)
    {
        $validated = $request->validated();

        $perbarui = Alternatif::where('id', $request->id)->update($validated);
        if ($perbarui) {
            return to_route('alternatif')->with('success', 'Alternatif Berhasil Diperbarui');
        } else {
            return to_route('alternatif')->with('error', 'Alternatif Gagal Diperbarui');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $penilaian = Penilaian::where('alternatif_id', $request->alternatif_id)->first();
        if ($penilaian) {
            MatriksKeputusan::where('penilaian_id', $penilaian->penilaian_id)->delete();
            $penilaian->delete();
        }
        Perhitungan::where('alternatif_id', $request->alternatif_id)->delete();
        $hapus = Alternatif::where('id', $request->alternatif_id)->delete();
        if ($hapus) {
            return to_route('alternatif')->with('success', 'Alternatif Berhasil Dihapus');
        } else {
            return to_route('alternatif')->with('error', 'Alternatif Gagal Dihapus');
        }
    }
}
