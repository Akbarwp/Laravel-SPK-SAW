<?php

namespace App\Http\Controllers;

use App\Http\Resources\MatriksKeputusanResource;
use App\Http\Resources\PenilaianResource;
use App\Http\Resources\PerhitunganResource;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\MatriksKeputusan;
use App\Models\Penilaian;
use App\Models\Perhitungan;

class SAWController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexMatriks()
    {
        $title = "Matriks Keputusan";
        $matriksKeputusan = MatriksKeputusanResource::collection(MatriksKeputusan::get());
        $penilaian = PenilaianResource::collection(Penilaian::get());
        $kriteria = Kriteria::orderBy('id', 'asc')->get(['id', 'kriteria']);
        $alternatif = Alternatif::orderBy('id', 'asc')->get(['id', 'alternatif']);
        $isSubKriteriaPenilaianNull = Penilaian::where('sub_kriteria_id', null)->first();
        return view('dashboard.matriks-keputusan.index', compact('title', 'matriksKeputusan', 'penilaian', 'kriteria', 'alternatif', 'isSubKriteriaPenilaianNull'));
    }

    public function hitungMatriksKeputusan()
    {
        $alternatif = Alternatif::get();
        $kriteria = Kriteria::get();
        $penilaian = Penilaian::with('subKriteria')->get();

        MatriksKeputusan::truncate();

        $maxMinBobot = Penilaian::query()
            ->join('kriteria as k', 'penilaian.kriteria_id', '=', 'k.id')
            ->join('sub_kriteria as sk', 'penilaian.sub_kriteria_id', '=', 'sk.id')
            ->groupBy('k.id', 'k.kriteria')
            ->selectRaw("k.id as kriteria_id, k.kriteria as kriteria, MAX(sk.bobot) as max_bobot, MIN(sk.bobot) as min_bobot")
            ->get();

        foreach ($alternatif as $item) {
            foreach ($kriteria as $value) {
                $penilaianAlternatif = $penilaian->where('alternatif_id', $item->id)->where('kriteria_id', $value->id)->first();

                if ($value->jenis_kriteria == 'benefit') {
                    $nilaiRating = $penilaianAlternatif->subKriteria->bobot / $maxMinBobot->where('kriteria_id', $value->id)->first()->max_bobot;
                } else if ($value->jenis_kriteria == 'cost') {
                    $nilaiRating = $maxMinBobot->where('kriteria_id', $value->id)->first()->min_bobot / $penilaianAlternatif->subKriteria->bobot;
                }

                $createMatriks = MatriksKeputusan::create([
                    'alternatif_id' => $item->id,
                    'kriteria_id' => $value->id,
                    'nilai_rating' => $nilaiRating,
                ]);
            }
        }

        if ($createMatriks) {
            return to_route('matriks-keputusan')->with('success', 'Matriks Keputusan Berhasil Dilakukan');
        } else {
            return to_route('matriks-keputusan')->with('error', 'Matriks Keputusan Gagal Dilakukan');
        }
    }

    public function indexRanking()
    {
        $title = "Perankingan";
        $perhitungan = PerhitunganResource::collection(Perhitungan::get());
        $penilaian = PenilaianResource::collection(Penilaian::get());
        $matriksKeputusan = MatriksKeputusanResource::collection(MatriksKeputusan::get());
        $kriteria = Kriteria::orderBy('id', 'asc')->get(['id', 'kriteria']);
        $alternatif = Alternatif::orderBy('id', 'asc')->get(['id', 'alternatif']);
        return view('dashboard.perankingan.index', compact('title', 'perhitungan', 'penilaian', 'matriksKeputusan', 'kriteria', 'alternatif'));
    }

    public function hitungRanking()
    {
        $alternatif = Alternatif::get();
        $kriteria = Kriteria::get();
        $matriksKeputusan = MatriksKeputusan::get();

        Perhitungan::truncate();

        foreach ($alternatif as $item) {
            foreach ($kriteria as $value) {
                $nilaiPreferensi = $value->bobot * $matriksKeputusan->where('alternatif_id', $item->id)->where('kriteria_id', $value->id)->first()->nilai_rating;
                $createRanking = Perhitungan::create([
                    'alternatif_id' => $item->id,
                    'kriteria_id' => $value->id,
                    'nilai' => $nilaiPreferensi,
                ]);
            }
        }

        if ($createRanking) {
            return to_route('ranking')->with('success', 'Perankingan Berhasil Dilakukan');
        } else {
            return to_route('ranking')->with('error', 'Perankingan Gagal Dilakukan');
        }
    }

    public function indexPerhitungan()
    {
        $title = "Perhitungan Metode";

        $isSubKriteriaPenilaianNull = Penilaian::where('sub_kriteria_id', null)->first();
        $perhitungan = PerhitunganResource::collection(Perhitungan::get());

        $matriksKeputusan = MatriksKeputusanResource::collection(MatriksKeputusan::get());
        $kriteria = Kriteria::orderBy('id', 'asc')->get(['id', 'kriteria']);
        $alternatif = Alternatif::orderBy('id', 'asc')->get(['id', 'alternatif']);
        $penilaian = PenilaianResource::collection(Penilaian::get());

        return view('dashboard.perhitungan.index', compact('title', 'matriksKeputusan', 'perhitungan', 'penilaian', 'kriteria', 'alternatif', 'isSubKriteriaPenilaianNull'));
    }

    public function perhitunganMetode()
    {
        $this->hitungMatriksKeputusan();
        $perhitunganMetode = $this->hitungRanking();

        if ($perhitunganMetode) {
            return to_route('perhitungan')->with('success', 'Perhitungan Metode SAW Berhasil Dilakukan');
        } else {
            return to_route('perhitungan')->with('error', 'Perhitungan Metode SAW Gagal Dilakukan');
        }
    }
}
