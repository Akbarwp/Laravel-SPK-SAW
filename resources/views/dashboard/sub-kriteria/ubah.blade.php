@extends("dashboard.layouts.main")

@section("js")
    <script>
        function updateData() {
            $.ajax({
                type: "post",
                url: "#",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    Swal.fire({
                        title: "Berhasil",
                        text: "Transaksi Berhasil Diperbarui",
                        icon: "success",
                        confirmButtonColor: '#6419E6',
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            return window.location.href = "{{ route('dashboard') }}";
                        }
                    });
                },
                error: function(data) {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Transaksi gagal Diperbarui',
                        icon: 'error',
                        confirmButtonColor: '#6419E6',
                        confirmButtonText: 'OK',
                    });
                }
            });
        }
    </script>
@endsection

@section("container")
    <div class="-mx-3 flex flex-wrap">
        <div class="w-full max-w-full flex-none px-3">
            {{-- Awal Form Ubah --}}
            <div class="relative mb-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-xl dark:shadow-akaroa/20">
                <div class="border-b-solid mb-0 flex items-center justify-between rounded-t-2xl border-b-0 border-b-transparent p-6 pb-3">
                    <div class="mb-3">
                        <h6 class="font-bold text-avocado dark:text-regal-blue">{{ $title }}</h6>
                    </div>
                    <div>
                        <a href="#" class="bg-150 active:opacity-85 tracking-tight-rem bg-x-25 mb-0 inline-block cursor-pointer rounded-lg border border-solid border-neutral bg-transparent px-4 py-1 text-center align-middle text-sm font-bold leading-normal text-neutral shadow-none transition-all ease-in hover:-translate-y-px hover:opacity-75 md:px-8 md:py-2">
                            <i class="ri-arrow-left-line"></i>
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="flex-auto px-6 pb-6 pt-0">
                    <div class="w-full flex flex-wrap justify-center gap-2 lg:flex-nowrap">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold text-avocado dark:text-regal-blue">
                                    <x-label-input-required :value="'Kode'" />
                                </span>
                            </div>
                            <input type="text" name="kode" class="input input-bordered w-full bg-spring-wood text-regal-blue" value="asd" readonly />
                        </label>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="w-full flex flex-wrap justify-center gap-2 lg:flex-nowrap">
                            <label class="form-control w-full lg:w-1/2">
                                <div class="label">
                                    <span class="label-text font-semibold text-avocado dark:text-regal-blue">
                                        <x-label-input-required :value="'Nama'" />
                                    </span>
                                </div>
                                <input type="text" name="nama" class="input input-bordered w-full text-regal-blue" value="Kriteria1" required />
                                @error("nama")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>
                            <label class="form-control w-full lg:w-1/2">
                                <div class="label">
                                    <span class="label-text font-semibold text-avocado dark:text-regal-blue">
                                        <x-label-input-required :value="'Nomor'" />
                                    </span>
                                </div>
                                <input type="number" min="0" step="0.1" name="nomor" class="input input-bordered w-full text-regal-blue" value="0.5" required />
                                @error("nomor")
                                    <div class="label">
                                        <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                    </div>
                                @enderror
                            </label>
                        </div>

                        <div class="my-5 flex flex-wrap justify-start">
                            <button onclick="return updateData()" type="button" class="btn btn-warning w-full max-w-xs">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Akhir Form Ubah --}}
        </div>
    </div>
@endsection
