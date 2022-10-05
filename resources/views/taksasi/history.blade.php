@include('layout.header')

<div class="content-wrapper">

    <section class="content-header">
    </section>

    <section class="content">
        <div class="container-fluid ">
            <h3>History Taksasi Panen</h3>
            <div class="container-fluid">

                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <table id="yajra-table" style="margin: 0 auto;text-align:center"
                                class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">TANGGAl</th>
                                        <th scope="col">ESTATE</th>
                                        <th scope="col">AFDELING</th>
                                        <th scope="col">BLOK</th>
                                        <th scope="col">AKP (%)</th>
                                        <th scope="col">TAKSASI (KG)</th>
                                        <th scope="col">RITASE</th>
                                        <th scope="col">KEB.PEMANEN (ORG)</th>
                                        <th scope="col">Luas(HA)</th>
                                        <th scope="col">SPH (Pkk/HA)</th>
                                        <th scope="col">BJR (Kg/Jjg)</th>
                                        <th scope="col">SAMPEL PATH</th>
                                        <th scope="col">JANJANG SAMPEL</th>
                                        <th scope="col">POKOK SAMPEL</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>




            </div>

        </div><!-- /.container-fluid -->
    </section>

</div>
@include('layout.footer')

{{-- <script src="{{ asset('lottie/93121-no-data-preview.json') }}" type="text/javascript"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js"
    integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery -->
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>



<script>
    $(function() {
        $('#yajra-table').DataTable({
            "searching": true,
            scrollX: true,
            processing: true,
            serverSide: true,
            language: {
        searchPlaceholder: "Ketik untuk mencari ..."
    },
            ajax: "{{ route('tak_history') }}",
            columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'tanggal_upload', name: 'tanggal_upload' },
            { data: 'lokasi_kerja', name: 'lokasi_kerja' },
            { data: 'afdeling', name: 'afdeling' },
            { data: 'blok', name: 'blok' },
            { data: 'akp_round', name: 'akp_round' },
            { data: 'tak_round', name: 'tak_round' },
            { data: 'ritase', name: 'ritase' },
            { data: 'pemanen', name: 'pemanen' },
            { data: 'luas', name: 'luas' },
            { data: 'sph', name: 'sph' },
            { data: 'bjr', name: 'bjr' },
            { data: 'jumlah_path', name: 'jumlah_path' },
            { data: 'jumlah_janjang', name: 'jumlah_janjang' },
            { data: 'jumlah_pokok', name: 'jumlah_pokok' },
            { data: 'action', name: 'action' },
        ],
        });
    });
    $(document).ready(function () {             
  $('.dataTables_filter input[type="search"]').css(
     {'width':'350px','display':'inline-block'}
  );
});
</script>