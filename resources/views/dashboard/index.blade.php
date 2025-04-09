@extends("dashboard.layouts.main")

@section("js")
    <script>
        let alternatif = [];
        let nilaiPreferensi = [];
        @foreach ($nilaiPreferensi as $item)
            alternatif.push(' {{ $item->alternatif->alternatif }} ');
            nilaiPreferensi.push(' {{ round($item->nilai_preferensi, 3) }} ');
        @endforeach

        let chart_perankingan = {
            chart: {
                height: 300,
                type: "line",
                stacked: true
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                data: nilaiPreferensi
            }, ],
            stroke: {
                curve: 'smooth',
                width: 4,
            },
            marker: {
                size: 10,
            },
            colors: ["#7F8A56"],
            xaxis: {
                categories: alternatif,
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                    color: "#1D2955"
                },
                labels: {
                    style: {
                        colors: "#1D2955"
                    }
                },
                title: {
                    text: "Alternatif",
                    style: {
                        color: "#7F8A56"
                    }
                }
            },
            yaxis: [{
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                    color: "#1D2955"
                },
                labels: {
                    style: {
                        colors: "#1D2955"
                    }
                },
                title: {
                    text: "Nilai",
                    style: {
                        color: "#7F8A56"
                    }
                }
            }, ],
            tooltip: {
                enabled: true,
                shared: false,
                followCursor: false,
                x: {
                    show: false,
                },
                y: {
                    formatter: undefined,
                    title: {
                        formatter: (seriesName) => "",
                    },
                },
            },
        };

        var chart1 = new ApexCharts(document.querySelector("#chart-perankingan"), chart_perankingan);
        chart1.render();
    </script>
@endsection

@section("container")
    <div>
        <!-- row 1 -->
        <div class="-mx-3 mb-5 flex flex-wrap">
            <!-- Kriteria -->
            <div class="mb-6 w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex min-w-0 flex-col break-words rounded-2xl bg-secondary-color bg-clip-border shadow-md dark:bg-secondary-color-dark dark:shadow-secondary-color-dark/20">
                    <div class="flex-auto p-4">
                        <div class="-mx-3 flex flex-row">
                            <div class="w-2/3 max-w-full flex-none px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold uppercase leading-normal dark:text-primary-color-dark">Kriteria</p>
                                    <h5 class="text-avodaco mb-2 font-bold dark:text-white">{{ $jmlKriteria }}</h5>
                                </div>
                            </div>
                            <div class="basis-1/3 px-3 text-right">
                                <div class="rounded-circle inline-block h-12 w-12 bg-gradient-to-tl from-primary-color to-secondary-color-dark text-center">
                                    <i class="ri-puzzle-line relative top-3 text-2xl leading-none text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub Kriteria -->
            <div class="mb-6 w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex min-w-0 flex-col break-words rounded-2xl bg-secondary-color bg-clip-border shadow-md dark:bg-secondary-color-dark dark:shadow-secondary-color-dark/20">
                    <div class="flex-auto p-4">
                        <div class="-mx-3 flex flex-row">
                            <div class="w-2/3 max-w-full flex-none px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold uppercase leading-normal dark:text-primary-color-dark">Sub Kriteria</p>
                                    <h5 class="text-avodaco mb-2 font-bold dark:text-white">{{ $jmlSubKriteria }}</h5>
                                </div>
                            </div>
                            <div class="basis-1/3 px-3 text-right">
                                <div class="rounded-circle inline-block h-12 w-12 bg-gradient-to-tl from-primary-color to-secondary-color-dark text-center">
                                    <i class="ri-puzzle-2-fill relative top-3 text-2xl leading-none text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alternatif -->
            <div class="mb-6 w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex min-w-0 flex-col break-words rounded-2xl bg-secondary-color bg-clip-border shadow-md dark:bg-secondary-color-dark dark:shadow-secondary-color-dark/20">
                    <div class="flex-auto p-4">
                        <div class="-mx-3 flex flex-row">
                            <div class="w-2/3 max-w-full flex-none px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold uppercase leading-normal dark:text-primary-color-dark">Alternatif</p>
                                    <h5 class="text-avodaco mb-2 font-bold dark:text-white">{{ $jmlAlternatif }}</h5>
                                </div>
                            </div>
                            <div class="basis-1/3 px-3 text-right">
                                <div class="rounded-circle inline-block h-12 w-12 bg-gradient-to-tl from-primary-color to-secondary-color-dark text-center">
                                    <i class="ri-survey-line relative top-3 text-2xl leading-none text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- row 2 -->
        <div class="-mx-3 mb-5 flex flex-wrap">
            <!-- SPK -->
            <div class="mb-6 w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:mb-0">
                <div class="min-w-0 rounded-lg bg-white bg-clip-border p-4 shadow-md dark:shadow-secondary-color-dark/20">
                    <h4 class="mb-4 font-semibold text-primary-color-dark">
                        Sistem Pendukung Keputusan
                    </h4>
                    <p class="mb-3 text-justify text-primary-color">
                        SAW sering juga dikenal dengan istilah metode penjumlahan terbobot.
                        Konsep dasar SAW adalah mencari penjumlahan terbobot dari rating kinerja pada setiap alternatif di semua atribut.
                        Metode SAW membutuhkan pprimary-colors normalisasi matriks keputusan (X) ke suatu skala yang dapat diperbandingkan dengan
                        semua rating alternatif.
                    </p>
                    <a class="group text-sm font-semibold leading-normal text-primary-color-dark" href="{{ route("kriteria") }}">
                        Mulai
                        <i class="ri-arrow-right-line ease-bounce group-hover:translate-x-1.25 ml-1 text-sm leading-normal transition-all duration-200"></i>
                    </a>
                </div>
            </div>

            <!-- Manfaat -->
            <div class="mb-6 w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:mb-0">
                <div class="min-w-0 rounded-lg bg-secondary-color p-4 text-white shadow-md dark:bg-secondary-color-dark dark:shadow-secondary-color-dark/20">
                    <h4 class="mb-4 font-semibold text-primary-color-dark">
                        Kegunaan SAW (Simple Additive Weighting):
                    </h4>
                    <ul style="list-style-type: square;" class="mx-5 mb-3 text-primary-color dark:text-white">
                        <li>Penilaian secara lebih tepat karena didasarkan pada nilai kriteria dan bobot preferensi yang sudah ditentukan.</li>
                        <li>Dapat menyeleksi alternatif terbaik dari sejumlah alternatif yang ada karena adanya pprimary-colors perankingan setelah menentukan nilai bobot untuk setiap atribut.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- row 4 -->
        <div class="-mx-3 mt-6 flex flex-wrap gap-y-2">
            <div class="mt-0 w-full max-w-full px-3 lg:flex-none">
                <div class="relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-primary-color-dark/10 bg-white bg-clip-border shadow-xl dark:shadow-secondary-color-dark/20">
                    <div class="mb-0 rounded-t-2xl border-b-0 border-solid border-primary-color-dark/10 p-6 pb-0 pt-4">
                        <h6 class="font-semibold capitalize text-primary-color-dark">Hasil Perhitungan SAW</h6>
                    </div>
                    <div class="flex-auto p-4">
                        <div id="chart-perankingan"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
