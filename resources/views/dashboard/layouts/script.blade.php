{{-- Script Argon --}}
<script src="{{ asset("js/argon-dashboard-tailwind.js") }}"></script>
<script src="{{ asset("js/dropdown.js") }}"></script>
<script src="{{ asset("js/sidenav-burger.js") }}"></script>

{{-- ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

{{-- JQuery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- DataTables --}}
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>

<script src="https://cdn.datatables.net/searchbuilder/1.7.1/js/dataTables.searchBuilder.js"></script>
<script src="https://cdn.datatables.net/searchbuilder/1.7.1/js/searchBuilder.dataTables.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>

{{-- Alphine Init --}}
<script src="{{ asset("js/init-alpine.js") }}"></script>

{{-- Sweetalert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session()->has("success"))
        Swal.fire({
            title: 'Berhasil',
            text: '{{ session("success") }}',
            icon: 'success',
            confirmButtonColor: '#6419E6',
            confirmButtonText: 'OK',
        });
    @endif

    @if (session()->has("error"))
        Swal.fire({
            title: 'Gagal',
            text: '{{ session("error") }}',
            icon: 'error',
            confirmButtonColor: '#6419E6',
            confirmButtonText: 'OK',
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            title: 'Gagal',
            text: 'Terjadi kesalahan, silakan coba kembali',
            icon: 'error',
            confirmButtonColor: '#6419E6',
            confirmButtonText: 'OK',
        })
    @endif
</script>
