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
            <a href="{{ route('dash_pemupukan') }}"> <i class="nav-icon fa-solid fa-arrow-left "></i> Kembali</a>
            <div class="card mt-3">
                <div class="card-body">
                    <h3 class="mb-3">Detail Pemupukan {{$est}} - {{$afd}}</h3>

                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th rowspan="2">Tanggal</th>
                                <th rowspan="2">Blok</th>
                                <th rowspan="2">Jenis Pupuk</th>
                                <th rowspan="2">Jumlah Pokok</th>
                                <th colspan="4" class="text-center">Monitoring Pemupukan</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>Terpupuk / Pkk</th>
                                <th>Jenis pupuk / Pkk</th>
                                <th>Lokasi pupuk / Pkk</th>
                                <th>Sebaran / Pkk</th>
                                {{-- <th>Foto</th> --}}
                                {{-- <th>Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($queryAfdeling as $item)
                            <tr>
                                <td>{{$item->tanggal}}</td>
                                <td>{{$item->blok}}</td>
                                <td>{{$item->nama_pupuk}}</td>
                                <td>{{$item->jumlah_pokok}}</td>
                                <td>{{$item->terpupuk}}</td>
                                <td>{{$item->kesesuaian_jenis}}</td>
                                <td>{{$item->terlokasi}}</td>
                                <td>{{$item->tersebar}}</td>
                                <td>-</td>
                            </tr>
                            @endforeach
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
    $(document).ready(function () {
        $('#example').DataTable();
    });

    
</script>