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

        function create_button() {
            $("input[name='id']").val("");
            $("input[name='kriteria']").val("");
            $("input[name='bobot']").val("");
        }

        function edit_button(kriteria_id) {
            // Loading effect start
            let loading = `<span class="loading loading-dots loading-md text-purple-600"></span>`;
            $("#loading_edit1").html(loading);
            $("#loading_edit2").html(loading);

            $.ajax({
                type: "get",
                url: "{{ route("kriteria.edit") }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kriteria_id": kriteria_id
                },
                success: function(data) {
                    // console.log(data);

                    $("input[name='id']").val(data.id);
                    $("input[name='kriteria']").val(data.kriteria);
                    $("input[name='bobot']").val(data.bobot);

                    // Loading effect end
                    loading = "";
                    $("#loading_edit1").html(loading);
                    $("#loading_edit2").html(loading);
                }
            });
        }

        function delete_button(kriteria_id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dipulihkan kembali!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6419E6',
                cancelButtonColor: '#F87272',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route("kriteria.delete") }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "kriteria_id": kriteria_id
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Data berhasil dihapus!',
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
                                title: 'Data gagal dihapus!',
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
            {{-- Awal Modal Create --}}
            <input type="checkbox" id="create_button" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box">
                    <div class="mb-3 flex justify-between">
                        <h3 class="text-lg font-bold">Tambah {{ $title }}</h3>
                        <label for="create_button" class="cursor-pointer">
                            <i class="ri-close-large-fill"></i>
                        </label>
                    </div>
                    <div>
                        <form action="{{ route("kriteria.store") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="id" hidden>
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Kriteria</x-label-input-required>
                                    </span>
                                </div>
                                <input type="text" name="kriteria" class="input input-bordered w-full bg-spring-wood text-regal-blue" value="{{ old("kriteria") }}" required />
                                @error("kriteria")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Bobot</x-label-input-required>
                                    </span>
                                </div>
                                <input type="number" min="0" max="1" step="0.01" name="bobot" class="input input-bordered w-full bg-spring-wood text-regal-blue" value="{{ old("bobot") }}" required />
                                @error("bobot")
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
            {{-- Akhir Modal Create --}}

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
                        <form action="{{ route("kriteria.update") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="id" hidden>
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Kriteria</x-label-input-required>
                                    </span>
                                    <span class="label-text-alt" id="loading_edit1"></span>
                                </div>
                                <input type="text" name="kriteria" class="input input-bordered w-full bg-spring-wood text-regal-blue" required />
                                @error("kriteria")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text font-semibold">
                                        <x-label-input-required>Bobot</x-label-input-required>
                                    </span>
                                    <span class="label-text-alt" id="loading_edit2"></span>
                                </div>
                                <input type="number" min="0" max="1" step="0.01" name="bobot" class="input input-bordered w-full bg-spring-wood text-regal-blue" required />
                                @error("bobot")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>
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
                        <form action="{{ route("kriteria.import") }}" method="POST" enctype="multipart/form-data">
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

            {{-- Awal Tabel Kriteria --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-spring-wood bg-clip-border shadow-xl dark:bg-white dark:shadow-akaroa/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-regal-blue">Tabel {{ $title }}</h6>
                    <div class="w-1/2 max-w-full flex-none px-3 text-right">
                        @if (number_format($sumBobot, 2) == 1)
                            <button class="mb-0 inline-block cursor-default rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success opacity-60 shadow-none md:px-8 md:py-2">
                                <i class="ri-add-fill"></i>
                                Tambah
                            </button>
                            <button class="mb-0 inline-block cursor-default rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success opacity-60 shadow-none md:px-8 md:py-2">
                                <i class="ri-file-excel-2-line"></i>
                                Impor
                            </button>
                        @else
                            <label for="create_button" class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2" onclick="return create_button()">
                                <i class="ri-add-fill"></i>
                                Tambah
                            </label>
                            <label for="import_button" class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2" onclick="return import_button()">
                                <i class="ri-file-excel-2-line"></i>
                                Impor
                            </label>
                        @endif
                    </div>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="bg-avocado text-xs font-bold uppercase text-white dark:bg-regal-blue dark:text-akaroa">
                                    <th class="rounded-tl">
                                        No.
                                    </th>
                                    <th>
                                        Nama Kriteria
                                    </th>
                                    <th>
                                        Bobot
                                    </th>
                                    <th class="rounded-tr">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriteria as $value => $item)
                                    <tr class="border-b border-regal-blue bg-transparent">
                                        <td>
                                            <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                {{ $value + 1 }}.
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-left align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                {{ $item->kriteria }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-center align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                                {{ $item->bobot }}
                                            </p>
                                        </td>
                                        <td>
                                            <div class="text-center align-middle">
                                                <label for="edit_button" class="btn btn-outline btn-warning btn-sm" onclick="return edit_button('{{ $item->id }}')">
                                                    <i class="ri-pencil-line text-base"></i>
                                                </label>
                                                <label for="delete_button" class="btn btn-outline btn-error btn-sm" onclick="return delete_button('{{ $item->id }}')">
                                                    <i class="ri-delete-bin-line text-base"></i>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tr>
                                <td></td>
                                <td class="text-right align-middle text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">Total Bobot:</td>
                                <td class="text-left align-middle text-base font-bold leading-tight text-regal-blue dark:text-regal-blue">
                                    {{ $sumBobot }} @if (number_format($sumBobot, 2) == 1) <span class="text-error">(max)</span>@endif
                                </td>
                                <td></td>
                            </tr>
                        </table>

                        <div class="w-fit overflow-x-auto">
                            <table class="table table-xs">
                                <tr>
                                    <td class="text-base font-semibold text-regal-blue">Keterangan:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-base text-regal-blue">Total bobot harus:</td>
                                    <td class="text-base text-regal-blue">1</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Kriteria --}}
        </div>
    </div>
@endsection
