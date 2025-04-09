@extends("dashboard.layouts.main")

@section("js")
    <script>
        $(document).ready(function() {
            $('#myTable1').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr',
                    },
                },
                order: [],
                pagingType: 'full_numbers',
            });

            $('#myTable2').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr',
                    },
                },
                order: [],
                pagingType: 'full_numbers',
            });
        });

        function perhitungan_button() {
            Swal.fire({
                title: 'Perhitungan Metode SAW',
                text: "Menghitung matriks keputusan dan perankingan",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#6419E6',
                cancelButtonColor: '#F87272',
                confirmButtonText: 'Hitung',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route("perhitungan.metode") }}",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Perhitungan metode berhasil dilakukan!',
                                icon: 'success',
                                confirmButtonColor: '#6419E6',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                title: 'Perhitungan metode gagal dilakukan!',
                                icon: 'error',
                                confirmButtonColor: '#6419E6',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            })
        }
    </script>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            <div role="alert" class="alert mb-5 flex items-center justify-between border-0 bg-secondary-color shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                <h6 class="font-bold text-primary-color-dark">Tabel-Tabel {{ $title }}</h6>
                <div>
                    <button class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-primary-color bg-transparent bg-white px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-primary-color shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2" onclick="return perhitungan_button()">
                        <i class="ri-add-fill"></i>
                        Perhitungan Metode
                    </button>
                </div>
            </div>

            {{-- Awal Tabel Matriks Keputusan --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-secondary-color bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color-dark">Tabel Matriks Keputusan</h6>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable1" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="bg-primary-color text-xs font-bold uppercase text-white dark:bg-primary-color-dark dark:text-secondary-color-dark">
                                    <th class="rounded-tl"></th>
                                    @foreach ($kriteria as $item)
                                        <th>
                                            {{ $item->kriteria }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$isSubKriteriaPenilaianNull)
                                    @foreach ($alternatif as $item)
                                        <tr class="border-b border-primary-color-dark bg-transparent">
                                            <td>
                                                <p class="text-left align-middle text-base font-semibold leading-tight text-primary-color-dark dark:text-primary-color-dark">
                                                    {{ $item->alternatif }}
                                                </p>
                                            </td>
                                            @if ($matriksKeputusan->first() == null)
                                                @foreach ($penilaian->where("alternatif_id", $item->id) as $value)
                                                    <td>
                                                        <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color-dark dark:text-primary-color-dark">
                                                            -
                                                        </p>
                                                    </td>
                                                @endforeach
                                            @else
                                                @foreach ($matriksKeputusan->where("alternatif_id", $item->id) as $value)
                                                    <td>
                                                        <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color-dark dark:text-primary-color-dark">
                                                            {{ round($value->nilai_rating, 3) }}
                                                        </p>
                                                    </td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="w-fit overflow-x-auto">
                            <table class="table table-xs">
                                <tr>
                                    <td class="text-base font-semibold text-primary-color-dark">Keterangan:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-base text-primary-color-dark">* Pastikan setiap alternatif telah terisi semua penilaian</td>
                                    <td class="text-base text-primary-color-dark"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Matriks Keputusan --}}

            {{-- Awal Tabel Perankingan --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-secondary-color bg-clip-border shadow-xl dark:bg-white dark:shadow-secondary-color-dark/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-primary-color-dark">Tabel Perankingan</h6>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable2" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="bg-primary-color text-xs font-bold uppercase text-white dark:bg-primary-color-dark dark:text-secondary-color-dark">
                                    <th class="rounded-tl"></th>
                                    @foreach ($kriteria as $item)
                                        <th>
                                            {{ $item->kriteria }}
                                        </th>
                                    @endforeach
                                    <th class="rounded-tr">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($matriksKeputusan->first() != null)
                                    @foreach ($alternatif as $item)
                                        <tr class="border-b border-primary-color-dark bg-transparent">
                                            <td>
                                                <p class="text-left align-middle text-base font-semibold leading-tight text-primary-color-dark dark:text-primary-color-dark">
                                                    {{ $item->alternatif }}
                                                </p>
                                            </td>
                                            @if ($perhitungan->first() == null)
                                                @foreach ($penilaian->where("alternatif_id", $item->id) as $value)
                                                    <td>
                                                        <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color-dark dark:text-primary-color-dark">
                                                            -
                                                        </p>
                                                    </td>
                                                @endforeach
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color-dark dark:text-primary-color-dark">
                                                        -
                                                    </p>
                                                </td>
                                            @else
                                                @foreach ($perhitungan->where("alternatif_id", $item->id) as $value)
                                                    <td>
                                                        <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color-dark dark:text-primary-color-dark">
                                                            {{ round($value->nilai, 3) }}
                                                        </p>
                                                    </td>
                                                @endforeach
                                                <td>
                                                    <p class="text-center align-middle text-base font-semibold leading-tight text-primary-color-dark dark:text-primary-color-dark">
                                                        {{ round($perhitungan->where("alternatif_id", $item->id)->sum("nilai"), 3) }}
                                                    </p>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Perankingan --}}
        </div>
    </div>
@endsection
