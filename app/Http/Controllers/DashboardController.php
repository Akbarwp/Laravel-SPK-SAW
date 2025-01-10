<?php

namespace App\Http\Controllers;

use App\Http\Resources\MatriksKeputusanResource;
use App\Http\Resources\PerhitunganResource;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\MatriksKeputusan;
use App\Models\Perhitungan;
use App\Models\SubKriteria;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";

        $jmlKriteria = Kriteria::count();
        $jmlSubKriteria = SubKriteria::count();
        $jmlAlternatif = Alternatif::count();

        $nilaiPreferensi = Perhitungan::selectRaw('alternatif_id, SUM(nilai) as nilai_preferensi')->groupBy('alternatif_id')->orderBy('alternatif_id', 'asc')->get();

        return view('dashboard/index', compact('title', 'jmlKriteria', 'jmlSubKriteria', 'jmlAlternatif', 'nilaiPreferensi'));
    }

    public function hasilAkhir()
    {
        $title = "Hasil Akhir";
        $perhitungan = PerhitunganResource::collection(Perhitungan::selectRaw('alternatif_id, SUM(nilai) as nilai_preferensi')->groupBy('alternatif_id')->orderBy('nilai_preferensi', 'desc')->get());
        $matriksKeputusan = MatriksKeputusanResource::collection(MatriksKeputusan::get());
        return view('dashboard.hasil-akhir.index', compact('title', 'perhitungan', 'matriksKeputusan'));
    }
}
