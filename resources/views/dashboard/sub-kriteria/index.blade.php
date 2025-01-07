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
                        url: "#",
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
                                icon: 'error',
                                title: 'Data gagal dihapus!',
                            })
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
            {{-- Awal Tabel Kriteria --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-spring-wood bg-clip-border shadow-xl dark:bg-white dark:shadow-akaroa/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <h6 class="font-bold text-regal-blue">{{ $title }}</h6>
                    <div class="w-1/2 max-w-full flex-none px-3 text-right">
                        <a href="#" class="mb-0 inline-block cursor-pointer rounded-lg border border-solid border-success bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal tracking-tight text-success shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 active:opacity-90 md:px-8 md:py-2">
                            <i class="ri-add-fill"></i>
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="flex-auto px-0 pb-2 pt-0">
                    <div class="overflow-x-auto p-0 px-6 pb-6">
                        <table id="myTable" class="nowrap stripe mb-3 w-full max-w-full border-collapse items-center align-top" style="width: 100%;">
                            <thead class="align-bottom">
                                <tr class="bg-avocado text-xs font-bold uppercase text-white dark:bg-regal-blue dark:text-akaroa">
                                    <th class="rounded-tl">
                                        Waktu
                                    </th>
                                    <th>
                                        Kode
                                    </th>
                                    <th>
                                        Nama
                                    </th>
                                    <th>
                                        Nomor
                                    </th>
                                    <th class="rounded-tr">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-600 bg-transparent text-left align-middle">
                                    <td>
                                        <p class="text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                            {{ \Carbon\Carbon::now()->format("d F Y H:i:s") }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                            K0001
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                            Kriteria1
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-base font-semibold leading-tight text-regal-blue dark:text-regal-blue">
                                            {{ number_format(20000, 2, ",", ".") }}
                                        </p>
                                    </td>
                                    <td>
                                        <div>
                                            <a href="#" class="btn btn-outline btn-info btn-sm">
                                                <i class="ri-eye-line text-base"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline btn-warning btn-sm">
                                                <i class="ri-pencil-fill text-base"></i>
                                            </a>
                                            <label for="delete_button" class="btn btn-outline btn-error btn-sm" onclick="return delete_button('12')">
                                                <i class="ri-delete-bin-line text-base"></i>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Akhir Tabel Kriteria --}}
        </div>
    </div>
@endsection
