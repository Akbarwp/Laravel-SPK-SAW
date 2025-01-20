@extends("dashboard.layouts.main")

@section("js")
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr',
                    },
                },
                ordering: false,
                pagingType: 'full_numbers',
            });
        });
    </script>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Awal Tabel Hasil Akhir --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-spring-wood bg-clip-border shadow-xl dark:bg-white dark:shadow-akaroa/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-regal-blue">Tabel {{ $title }}</h6>
                    <div class="w-1/2 max-w-full flex-none px-3 text-right">
                        <a href="{{ route('pdf.hasilAkhir') }}" target="_blank" class="mb-0 inline-block rounded-lg border border-solid border-error bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-error shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2">
                            <i class="ri-file-pdf-2-line"></i>
                            Cetak PDF
                        </a>
                    </div>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="bg-avocado text-xs font-bold uppercase text-white dark:bg-regal-blue dark:text-akaroa">
                                    <th class="rounded-tl">Alternatif</th>
                                    <th>Hasil</th>
                                    <th>Hasil Akhir</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($matriksKeputusan->first() != null)
                                    @php
                                        $totalNilaiPreferensi = $perhitungan->sum("nilai_preferensi");
                                        $hasilAkhirNilaiPreferensi = 0;
                                        $presentasiNilaiPreferensi = 0;
                                    @endphp
                                    @foreach ($perhitungan as $item)
                                        <tr class="border-b border-regal-blue bg-transparent">
                                            <td>
                                                <p class="text-left align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                    {{ $item->alternatif->alternatif }}
                                                </p>
                                            </td>
                                            @if ($perhitungan->first() == null)
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                        -
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                        -
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                        -
                                                    </p>
                                                </td>
                                            @else
                                                @php
                                                    $hasilAkhirNilaiPreferensi += round($item->nilai_preferensi / $totalNilaiPreferensi, 3);
                                                    $presentasiNilaiPreferensi += round(($item->nilai_preferensi / $totalNilaiPreferensi) * 100, 0);
                                                @endphp
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                        {{ round($item->nilai_preferensi, 3) }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                        {{ round($item->nilai_preferensi / $totalNilaiPreferensi, 3) }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                        {{ round(($item->nilai_preferensi / $totalNilaiPreferensi) * 100, 0) }}%
                                                    </p>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    <tr class="border-b border-regal-blue bg-transparent">
                                        <td>
                                            <p class="text-right align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                Jumlah:
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                {{ round($totalNilaiPreferensi, 3) }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                {{ $hasilAkhirNilaiPreferensi }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                {{ $presentasiNilaiPreferensi }}%
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Hasil Akhir --}}
        </div>
    </div>
@endsection
