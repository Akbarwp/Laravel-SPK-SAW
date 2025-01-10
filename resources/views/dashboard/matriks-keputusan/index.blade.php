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
                order: [],
                pagingType: 'full_numbers',
            });
        });

        function hitungMatriks_button() {
            Swal.fire({
                title: 'Matriks Keputusan',
                text: "Menghitung nilai normalisasi dari penilaian alternatif",
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
                        url: "{{ route("matriks-keputusan.hitungMatriksKeputusan") }}",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Matriks Keputusan berhasil dilakukan!',
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
                                title: 'Matriks Keputusan gagal dilakukan!',
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
            {{-- Awal Tabel Matriks Keputusan --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-spring-wood bg-clip-border shadow-xl dark:bg-white dark:shadow-akaroa/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-regal-blue">Tabel {{ $title }}</h6>
                    <div class="w-1/2 max-w-full flex-none px-3 text-right">
                        @if ($isSubKriteriaPenilaianNull || $penilaian->first() == null)
                            <button class="mb-0 inline-block cursor-default rounded-lg border border-solid border-avocado bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-avocado opacity-60 shadow-none md:px-8 md:py-2">
                                <i class="ri-add-fill"></i>
                                Hitung Matriks Keputusan
                            </button>
                        @else
                            <label for="create_button" class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-avocado bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-avocado shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2" onclick="return hitungMatriks_button()">
                                <i class="ri-add-fill"></i>
                                Hitung Matriks Keputusan
                            </label>
                        @endif
                    </div>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="bg-avocado text-xs font-bold uppercase text-white dark:bg-regal-blue dark:text-akaroa">
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
                                        <tr class="border-b border-regal-blue bg-transparent">
                                            <td>
                                                <p class="text-left align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                    {{ $item->alternatif }}
                                                </p>
                                            </td>
                                            @if ($matriksKeputusan->first() == null)
                                                @foreach ($penilaian->where("alternatif_id", $item->id) as $value)
                                                    <td>
                                                        <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                            -
                                                        </p>
                                                    </td>
                                                @endforeach
                                            @else
                                                @foreach ($matriksKeputusan->where("alternatif_id", $item->id) as $value)
                                                    <td>
                                                        <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
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
                                    <td class="text-base font-semibold text-regal-blue">Keterangan:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-base text-regal-blue">* Pastikan setiap alternatif telah terisi semua penilaian</td>
                                    <td class="text-base text-regal-blue"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Matriks Keputusan --}}
        </div>
    </div>
@endsection
