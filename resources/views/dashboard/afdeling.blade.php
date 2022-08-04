@include('layout.header')
<style>
    @media only screen and (min-width: 992px) {
        .piechart_div {
            height: 590px;
        }

    }



    @media only screen and (min-width: 1366px) {

        .piechart_div {
            height: 800px;
        }
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="col-12 col-lg-3">
                Pilih Tanggal
                <form class="" action="{{ route('dash_afd') }}" method="get">
                    <input class="form-control" type="date" name="tgl" onchange="this.form.submit()">
                </form>
            </div>
            <br>

            <div class="row">

                <div class="col-md-12">
                    <!-- Curah Hujan -->
                    <div class="card">
                        <div class="card-header" style="background-color: #013C5E;color:white">
                            <div class=" card-title">
                                <i class="fas fa-chart-line pr-2"></i> Taksasi Afdeling
                            </div>

                            <div class="float-right ml-2">
                                <div class="list-inline">
                                    <select name="lokasi" class="form-control">
                                        <option selected disabled>Pilih regional</option>
                                        @foreach($reg as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="float-right">
                                <div class="list-inline">
                                    <select name="reg" class="form-control">
                                        @foreach($reg as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-12">

                                    <div id="taksasiafdeling" style="height: 250px" {{--
                                        style="width: 100%; height: 300px;" --}}>
                                    </div>

                                </div>



                            </div>

                        </div><!-- /.card-body -->
                    </div><!-- Curah Hujan -->


                </div>
            </div>





            {{-- afdeling --}}
            <div class="row">

                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header" style="background-color: #013C5E;color:white">
                            <div class=" card-title">
                                <i class="fas fa-chart-line pr-2"></i> Kebutuhan Pemanen Afdeling
                            </div>

                            <div class="float-right">
                                <div class="list-inline">
                                    <select name="lokasi" class="form-control">
                                        {{-- @foreach($wl_loc as $loc) --}}
                                        <option value="">KNE</option>
                                        <option value="">RGE</option>
                                        <option value="">BKE</option>
                                        <option value="">SGE</option>
                                        <option value="">KDE</option>
                                        <option value="">RDE</option>
                                        <option value="">SLE</option>
                                        <option value="">SYE</option>
                                        <option value="">UPE</option>
                                        {{-- @endforeach --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-12">

                                    <div id="pemanenafdeling" style="height: 400px" {{--
                                        style="width: 100%; height: 300px;" --}}>
                                    </div>

                                </div>



                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- Curah Hujan -->


                </div>
            </div>
        </div>
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
    google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawtaksasiafdeling);
      google.charts.setOnLoadCallback(drawkepemanenafdeling);
      

      function drawtaksasiafdeling() {
        var tak_afd = new google.visualization.DataTable();
    tak_afd.addColumn('string', 'Estate');
    tak_afd.addColumn('number', 'Taksasi Afdeling');
    // tak_afd.addColumn({type: 'string', role: 'style'});
    tak_afd.addRows([
      <?php echo $afd['data_taksasi_afd']; ?>
    ]);

        var options = {
        chartArea: {},
        theme: 'material',
        // colors:[ ,'#FF9800','#4CAF50',  '#4CAF50','#4CAF50' ,'#4CAF50' ],
        // hAxis: {title: 'Priority', titleTextStyle: {color: 'black',fontSize:'15',fontName:'"Arial"'}},
        //   title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'none' }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('taksasiafdeling'));

        chart.draw(tak_afd, options);
      }


      function drawkepemanenafdeling() {
        var pemanen_afd = new google.visualization.DataTable();
    pemanen_afd.addColumn('string', 'Estate');
    pemanen_afd.addColumn('number', 'Kebutuhan Pemanen Afdeling');
    // pemanen_afd.addColumn({type: 'string', role: 'style'});
    pemanen_afd.addRows([
      <?php echo $afd['data_kebutuhan_pemanen_afd']; ?>
    ]);

        var options = {
        chartArea: {},
        theme: 'material',
        // colors:[ ,'#FF9800','#4CAF50',  '#4CAF50','#4CAF50' ,'#4CAF50' ],
        // hAxis: {title: 'Priority', titleTextStyle: {color: 'black',fontSize:'15',fontName:'"Arial"'}},
        //   title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'none' }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('pemanenafdeling'));

        chart.draw(pemanen_afd, options);
      }

    
</script>