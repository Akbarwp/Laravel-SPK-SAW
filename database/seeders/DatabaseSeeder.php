<?php

namespace Database\Seeders;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Admin',
            'email' => 'admin@gmail.com',
        ]);

        $kriteria[] = Kriteria::factory()->create([
            'kriteria' => 'Rasa',
            'bobot' => '0.25',
        ]);
        $kriteria[] = Kriteria::factory()->create([
            'kriteria' => 'Harga',
            'bobot' => '0.25',
        ]);
        $kriteria[] = Kriteria::factory()->create([
            'kriteria' => 'Biji Kopi',
            'bobot' => '0.2',
        ]);
        $kriteria[] = Kriteria::factory()->create([
            'kriteria' => 'Kuantitas Kopi',
            'bobot' => '0.2',
        ]);
        $kriteria[] = Kriteria::factory()->create([
            'kriteria' => 'Metode Penyeduhan',
            'bobot' => '0.1',
        ]);

        $subKriteria = ['Sangat Baik', 'Baik', 'Cukup', 'Buruk', 'Sangat Buruk'];
        foreach ($kriteria as $item) {
            SubKriteria::factory()->create([
                'sub_kriteria' => $subKriteria[0],
                'bobot' => 5,
                'kriteria_id' => $item->id,
            ]);
            SubKriteria::factory()->create([
                'sub_kriteria' => $subKriteria[1],
                'bobot' => 4,
                'kriteria_id' => $item->id,
            ]);
            SubKriteria::factory()->create([
                'sub_kriteria' => $subKriteria[2],
                'bobot' => 3,
                'kriteria_id' => $item->id,
            ]);
            SubKriteria::factory()->create([
                'sub_kriteria' => $subKriteria[3],
                'bobot' => 2,
                'kriteria_id' => $item->id,
            ]);
            SubKriteria::factory()->create([
                'sub_kriteria' => $subKriteria[4],
                'bobot' => 1,
                'kriteria_id' => $item->id,
            ]);
        }

        $alternatif = Alternatif::factory(4)->create();

        foreach ($alternatif as $item) {
            foreach ($kriteria as $value) {
                Penilaian::create([
                    'alternatif_id' => $item->id,
                    'kriteria_id' => $value->id,
                    'sub_kriteria_id' => null,
                ]);
            }
        }
    }
}
