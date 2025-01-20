<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\MatriksKeputusan;
use App\Models\Penilaian;
use App\Models\Perhitungan;
use Barryvdh\DomPDF\Facade\PDF;

class PDFController extends Controller
{
    public function pdf_hasil()
    {
        $judul = 'Laporan Hasil Akhir';
        $tabelPenilaian = Penilaian::with('kriteria', 'subKriteria', 'alternatif')->get();
        $tabelMatriks = MatriksKeputusan::with('kriteria', 'alternatif')->get();
        $tabelPerankingan = Perhitungan::selectRaw('alternatif_id, SUM(nilai) as nilai_preferensi')->groupBy('alternatif_id')->orderBy('nilai_preferensi', 'desc')->get();
        $tabelPreferensi = Perhitungan::with('kriteria', 'alternatif')->get();
        $kriteria = Kriteria::orderBy('id', 'asc')->get(['id', 'kriteria']);
        $alternatif = Alternatif::orderBy('id', 'asc')->get(['id', 'alternatif']);

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif'])->loadview('dashboard.pdf.hasil_akhir', [
            'judul' => $judul,
            'tabelPenilaian' => $tabelPenilaian,
            'tabelMatriks' => $tabelMatriks,
            'tabelPreferensi' => $tabelPreferensi,
            'tabelPerankingan' => $tabelPerankingan,
            'kriteria' => $kriteria,
            'alternatif' => $alternatif,
        ]);

        // return $pdf->download('laporan-penilaian.pdf');
        return $pdf->stream();
    }
}
