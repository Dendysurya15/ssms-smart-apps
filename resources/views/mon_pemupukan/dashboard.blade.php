@include('layout.header')
<style>
    .content {
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        font-size: 15px;
    }

    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        /* width: 800px; */
        margin: 0 auto;
    }

    table.dataTable thead tr th {
        border: 1px solid black;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <section class="content">
        <div class="container-fluid">
            <h3>Dashboard Pemupukan</h3>

            <div class="card">
                <div class="card-body">

                    <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="3">Tanggal Update </th>
                                <th rowspan="3">Estate</th>
                                <th rowspan="3">Divisi</th>
                                {{-- <th rowspan="3">Luas (Ha)</th> --}}
                                {{-- <th rowspan="3">Jumlah Pokok</th> --}}
                                <th rowspan="3">Jenis Pupuk</th>
                                <th colspan="4">Rokemendasi</th>
                                {{-- <th>Estate</th> --}}
                                {{-- <th>Divisi</th> --}}
                                {{-- <th>Luas (Ha)</th> --}}
                                <th colspan="4">Aplikasi</th>
                                {{-- <th>Jenis Pupuk</th> --}}
                                {{-- <th>Rekomendasi</th> --}}
                                {{-- <th>Aplikasi</th> --}}
                                <th rowspan="3">Achievement</th>
                                <th rowspan="3">Varian</th>
                                <th rowspan="3">Annual Achievement (%)</th>
                                <th rowspan="3">Kg/pokok</th>
                                {{-- <th rowspan="3">Aksi</th> --}}
                            </tr>
                            <tr>
                                {{-- <th>Jenis Pupuk</th> --}}
                                <th colspan="2">SM1</th>
                                {{-- <th>Estate</th> --}}
                                <th colspan="2">SM2</th>
                                {{-- <th>Luas (Ha)</th> --}}
                                <th colspan="2">SM1</th>
                                {{-- <th>Jenis Pupuk</th> --}}
                                <th colspan="2">SM2</th>
                                {{-- <th>Aplikasi</th> --}}
                                {{-- <th>Achievement</th> --}}
                                {{-- <th>Varian</th> --}}
                                {{-- <th>Annual Achievement (%)</th> --}}
                                {{-- <th>Kg/pokok</th> --}}
                            </tr>
                            <tr>

                                {{-- <th>Jenis Pupuk</th> --}}
                                <th>BI</th>
                                <th>SBI</th>
                                <th>BI</th>
                                <th>SBI</th>
                                <th>BI</th>
                                <th>SBI</th>
                                <th>BI</th>
                                <th>SBI</th>
                                {{-- <th>Achievement</th> --}}
                                {{-- <th>Varian</th> --}}
                                {{-- <th>Annual Achievement (%)</th> --}}
                                {{-- <th>Kg/pokok</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>


                </div>
            </div>


        </div>
    </section>

</div>
@include('layout.footer')

{{-- <script src=" {{ asset('lottie/93121-no-data-preview.json') }}" type="text/javascript">
</script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js"
    integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery -->
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}">
</script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>



<script>
    $(function() {
        $('#example').DataTable({
            "scrollX": true,
            "searching": true,
            "pageLength": 10,
            processing: true,
            serverSide: true,
            ajax: "{{ route('data') }}",
            columns: [
            { data: 'tanggal', name: 'tanggal' },
            { data: 'estate', name: 'estate' },
            { data: 'afdeling', name: 'afdeling' },
            // { data: 'estate', name: 'estate' },
            // { data: 'jumlah_pokok', name: 'jumlah_pokok' },
            { data: 'jenis_pupuk', name: 'jenis_pupuk' },
            { data: 'biSm1Rekom', name: 'biSm1Rekom' },
            { data: 'sbiSm1Rekom', name: 'sbiSm1Rekom' },
            { data: 'biSm2Rekom', name: 'biSm2Rekom' },
            { data: 'sbiSm2Rekom', name: 'sbiSm2Rekom' },
            { data: 'biSm1Apl', name: 'biSm1Apl' },
            { data: 'sbiSm1Apl', name: 'sbiSm1Apl' },
            { data: 'biSm2Apl', name: 'biSm2Apl' },
            { data: 'sbiSm2Apl', name: 'sbiSm2Apl' },
            { data: 'achieve', name: 'achieve' },
            { data: 'varian', name: 'varian' },
            { data: 'annual', name: 'annual' },
            { data: 'kgpokok', name: 'kgpokok' },
            // { data: 'action', name: 'action' },
        ],
        
        });
    });
</script>