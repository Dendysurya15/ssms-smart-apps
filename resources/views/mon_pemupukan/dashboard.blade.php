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
                        <th rowspan="3">Jenis Pupuk</th>
                        <th colspan="4">Rekomendasi</th>
                        <th colspan="4">Aplikasi</th>
                        <th colspan="2">Achievement</th>
                        <th rowspan="3">Varian</th>
                        <th rowspan="3">Annual Achievement (%)</th>
                        <th rowspan="3">Kg/pokok</th>
                    </tr>
                    <tr>
                        <th colspan="2">SM1</th>
                        <th colspan="2">SM2</th>
                        <th colspan="2">SM1</th>
                        <th colspan="2">SM2</th>
                        <th rowspan="2">SM1</th>
                        <th rowspan="2">SM2</th>
                    </tr>
                    <tr>
                        <th>bi</th>
                        <th>sbi</th>
                        <th>bi</th>
                        <th>sbi</th>
                        <th>bi</th>
                        <th>sbi</th>
                        <th>bi</th>
                        <th>sbi</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($collection as $item)
                    <tr>
                        <td>{{$item->tanggal}}</td>
                        <td>{{$item->estate}}</td>
                        <td>{{$item->afdeling}}</td>
                        <td></td>
                        <td>{{$item->jumlah_pokok}}</td>
                        <td>{{$item->nama_pupuk}}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    @endforeach
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
    $(document).ready(function() {
        var table = $('#example').DataTable( {
        scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
        fixedColumns:   {
            left: 2,
        }
    } );
    
} );
</script>