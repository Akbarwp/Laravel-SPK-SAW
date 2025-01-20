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

        function edit_button(alternatif_id) {
            // Loading effect start
            let loading = `<span class="loading loading-dots loading-md text-purple-600"></span>`;
            @foreach ($kriteria as $item)
                $("#loading_edit_{{ $item->id }}").html(loading);
            @endforeach

            $.ajax({
                type: "get",
                url: "{{ route("penilaian.edit") }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "alternatif_id": alternatif_id
                },
                success: function(data) {
                    console.log(data);

                    $("input[name='alternatif_id']").val(data[0].alternatif_id);
                    @foreach ($kriteria as $value => $item)
                        $("input[id='kriteria_id_{{ $item->id }}']").val(data[{{ $value }}].kriteria_id);
                        $("select[id='sub_kriteria_id_{{ $item->id }}']").val(data[{{ $value }}].sub_kriteria_id);
                    @endforeach

                    // Loading effect end
                    loading = "";
                    @foreach ($kriteria as $item)
                        $("#loading_edit_{{ $item->id }}").html(loading);
                    @endforeach
                }
            });
        }
    </script>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Awal Modal Edit --}}
            <input type="checkbox" id="edit_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Ubah {{ $title }}</h3>
                        <label for="edit_button" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <form action="{{ route("penilaian.update") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="alternatif_id" hidden>
                            @foreach ($kriteria as $item)
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text font-semibold">
                                            <x-label-input-required>{{ $item->kriteria }}</x-label-input-required>
                                        </span>
                                        <span class="label-text-alt" id="{{ "loading_edit_" . $item->id }}"></span>
                                    </div>
                                    <input type="text" name="kriteria_id[]" id="{{ "kriteria_id_" . $item->id }}" class="input input-bordered w-full bg-spring-wood text-regal-blue" hidden />
                                    <select name="sub_kriteria_id[]" id="{{ "sub_kriteria_id_" . $item->id }}" class="select select-bordered w-full bg-spring-wood text-regal-blue" required>
                                        <option disabled selected>Pilih Kriteria!</option>
                                        @foreach ($subKriteria->where("kriteria_id", $item->id) as $value)
                                            <option value="{{ $value->id }}">{{ $value->sub_kriteria }}</option>
                                        @endforeach
                                    </select>
                                    @error("sub_kriteria_id")
                                        <div class="label">
                                            <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </label>
                            @endforeach
                            <button type="submit" class="btn btn-warning mt-3 w-full text-regal-blue">Perbarui</button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Edit --}}

            {{-- Awal Modal Import --}}
            <input type="checkbox" id="import_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Impor {{ $title }}</h3>
                        <label for="import_button" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <form action="{{ route("penilaian.import") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>File Excel</x-label-input-required>
                                    </span>
                                </div>
                                <input type="file" name="import_data" class="file-input file-input-bordered w-full bg-spring-wood text-regal-blue" required />
                                @error("import_data")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>
                            <button type="submit" class="btn btn-success mt-3 w-full text-regal-blue">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Akhir Modal Import --}}

            {{-- Awal Tabel Penilaian --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-spring-wood bg-clip-border shadow-xl dark:bg-white dark:shadow-akaroa/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-regal-blue">Tabel {{ $title }}</h6>
                    <div class="w-1/2 max-w-full flex-none px-3 text-right">
                        <label for="import_button" class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2" onclick="return import_button()">
                            <i class="ri-file-excel-2-line"></i>
                            Impor
                        </label>
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
                                    <th class="rounded-tr">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatif as $item)
                                    <tr class="border-b border-slate-600 bg-transparent">
                                        <td>
                                            <p class="text-left align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                {{ $item->alternatif }}
                                            </p>
                                        </td>
                                        @foreach ($penilaian->where("alternatif_id", $item->id) as $value)
                                            <td>
                                                <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                    @if ($value->sub_kriteria_id == null)
                                                        -
                                                    @else
                                                        {{ $value->subKriteria->sub_kriteria }}
                                                    @endif
                                                </p>
                                            </td>
                                        @endforeach
                                        <td>
                                            <div class="text-center align-middle">
                                                <label for="edit_button" class="btn btn-outline btn-warning btn-sm" onclick="return edit_button('{{ $item->id }}')">
                                                    <i class="ri-pencil-fill text-base"></i>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="w-fit overflow-x-auto">
                            <table class="table table-xs">
                                <tr>
                                    <td class="text-base font-semibold text-regal-blue">Keterangan:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-base text-regal-blue">* Pastikan setiap alternatif terisi semua</td>
                                    <td class="text-base text-regal-blue"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Penilaian --}}
        </div>
    </div>
@endsection
