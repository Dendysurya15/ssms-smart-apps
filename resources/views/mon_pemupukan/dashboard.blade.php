@include('layout.header')
<style>
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


            <table id="example" class="display" cellspacing="0" width="100%">
                <thead class="text-center">
                    <tr>
                        <th rowspan="3">Tanggal</th>
                        <th rowspan="3">Estate</th>
                        <th rowspan="3">Divisi</th>
                        <th rowspan="3">Luas (Ha)</th>
                        <th rowspan="3">Jumlah Pokok</th>
                        <th>Jenis Pupuk</th>
                        <th>Tanggal</th>
                        <th>Estate</th>
                        <th>Divisi</th>
                        <th>Luas (Ha)</th>
                        <th>Jumlah Pokok</th>
                        <th>Jenis Pupuk</th>
                        <th>Rekomendasi</th>
                        <th>Aplikasi</th>
                        <th>Achievement</th>
                        <th>Varian</th>
                        <th>Annual Achievement (%)</th>
                        <th>Kg/pokok</th>
                    </tr>
                    <tr>
                        <th>Jenis Pupuk</th>
                        <th>Tanggal</th>
                        <th>Estate</th>
                        <th>Divisi</th>
                        <th>Luas (Ha)</th>
                        <th>Jumlah Pokok</th>
                        <th>Jenis Pupuk</th>
                        <th>Rekomendasi</th>
                        <th>Aplikasi</th>
                        <th>Achievement</th>
                        <th>Varian</th>
                        <th>Annual Achievement (%)</th>
                        <th>Kg/pokok</th>
                    </tr>
                    <tr>

                        <th>Jenis Pupuk</th>
                        <th>Tanggal</th>
                        <th>Estate</th>
                        <th>Divisi</th>
                        <th>Luas (Ha)</th>
                        <th>Jumlah Pokok</th>
                        <th>Jenis Pupuk</th>
                        <th>Rekomendasi</th>
                        <th>Aplikasi</th>
                        <th>Achievement</th>
                        <th>Varian</th>
                        <th>Annual Achievement (%)</th>
                        <th>Kg/pokok</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>




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
            { data: 'estate', name: 'estate' },
            { data: 'jumlah_pokok', name: 'jumlah_pokok' },
            { data: 'nama_pupuk', name: 'nama_pupuk' },
            { data: 'estate', name: 'estate' },
            { data: 'estate', name: 'estate' },
            { data: 'estate', name: 'estate' },
            { data: 'estate', name: 'estate' },
            { data: 'estate', name: 'estate' },
            { data: 'estate', name: 'estate' },
            { data: 'estate', name: 'estate' },
            { data: 'estate', name: 'estate' },
            { data: 'estate', name: 'estate' },
            { data: 'estate', name: 'estate' },
            { data: 'estate', name: 'estate' },
            { data: 'estate', name: 'estate' },
        ],
        
        });
    });
</script>