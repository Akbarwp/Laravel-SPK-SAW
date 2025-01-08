<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
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

        return view('dashboard/index', compact('title', 'jmlKriteria', 'jmlSubKriteria', 'jmlAlternatif'));
    }

    public function ranking()
    {
        $title = "Perankingan";
        $perhitungan = Perhitungan::get();
        return view('dashboard/ranking', compact('title', 'perhitungan'));
    }
}
