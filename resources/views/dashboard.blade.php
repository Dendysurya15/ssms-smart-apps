@include('layout.header')
<style>
    /* .content { */
    /* font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; */
    /* font-size: 15px; */
    /* } */
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-12 col-lg-12">
            <div class="container-fluid pt-2 pl-3 pr-3">

                <h2 style="color:#013C5E;font-weight: 550">Dashboard Pemupukan
                </h2>
                <div class="row">

                    <div class="col-md-12">
                        <!-- Curah Hujan -->
                        <div class="card">
                            <div class="card-header" style="background-color: #013C5E;color:white">
                                <div class=" card-title">
                                    <i class="fas fa-chart-line pr-2"></i>Stok Pupuk Regional 1
                                </div>
                                <div class="float-right">
                                    <div class="list-inline">
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col">

                                        <div id="stokpupukreg1" {{-- style="width: 100%; height: 300px;" --}}>
                                        </div>

                                    </div>

                                </div>
                            </div><!-- /.card-body -->
                        </div><!-- Curah Hujan -->


                    </div>
                </div>

                {{-- //filter --}}
                <div class="row">

                    <div class="col-md-12">
                        <!-- Curah Hujan -->
                        <div class="card">
                            <div class="card-header" style="background-color: #013C5E;color:white">
                                <div class=" card-title">
                                    <i class="fas fa-chart-line pr-2"></i>Filter Per Jenis Pupuk Regional 1

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

                                    <div class="col">

                                        <div id="filterpupukreg1" {{-- style="width: 100%; height: 300px;" --}}>
                                        </div>

                                    </div>

                                </div>
                            </div><!-- /.card-body -->
                        </div><!-- Curah Hujan -->


                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12">
                        <!-- Curah Hujan -->
                        <div class="card">
                            <div class="card-header" style="background-color: #013C5E;color:white">
                                <div class=" card-title">
                                    <i class="fas fa-chart-line pr-2"></i>Temuan Regional 1
                                </div>
                                <div class="float-right">
                                    <div class="list-inline">
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col">

                                        <div id="temuanreg1" {{-- style="width: 100%; height: 300px;" --}}>
                                        </div>

                                    </div>

                                </div>
                            </div><!-- /.card-body -->
                        </div><!-- Curah Hujan -->


                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12">
                        <!-- Curah Hujan -->
                        <div class="card">
                            <div class="card-header" style="background-color: #013C5E;color:white">
                                <div class=" card-title">
                                    <i class="fas fa-chart-line pr-2"></i>Filter Temuan Per Estate

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

                                    <div class="col">

                                        <div id="temuanfilterestate" {{-- style="width: 100%; height: 300px;" --}}>
                                        </div>

                                    </div>

                                </div>
                            </div><!-- /.card-body -->
                        </div><!-- Curah Hujan -->


                    </div>

                    <div class="col-md-12">
                        <!-- Curah Hujan -->
                        <div class="card">
                            <div class="card-header" style="background-color: #013C5E;color:white">
                                <div class=" card-title">
                                    <i class="fas fa-chart-line pr-2"></i>Track GPS Pemupukan KNE OB M25 26 Juni 2022
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-3">



                                        <p> Asisten 1 : <span class="font-italic"> Ahmad Nugroho</span></p>
                                        <p> Mandor 1 : <span class="font-italic"> Nuryanto</span></p>
                                        <p>Total Pokok 243</p>
                                        <p>Jumlah path 6</p>
                                    </div>

                                    <div class="col-3">
                                        {{-- <p><u> Temuan<span class="font-weight-bold"> 5</span></u></p> --}}
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Temuan</th>
                                                    <th scope="col">Jumlah</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td scope="row">Tidak dipupuk</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Jenis pupuk</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Lokasi pupuk</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Sebaran pupuk</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Total</th>
                                                    <th>5</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h3 class="p-3" style="border-radius: 5px;border: 1px solid  #013C5E"> Skor :
                                            <span class="font-weight-bold"> 97,94%</span>
                                        </h3>
                                        {{-- <p>- Tidak dipupuk 4</p>
                                        <p>- Jenis pupuk 0</p>
                                        <p>- Lokasi pupuk 1</p>
                                        <p>- Sebaran pupuk 0</p> --}}
                                    </div>

                                    <div class="col-6">
                                        {{-- <img src="{{ asset('img/Picture2.jpg') }}" </div> --}}
                                        <img src="{{ asset('img/Picture2.jpg') }}" style="height: 100%;width: 100%;">
                                    </div>
                                </div><!-- /.card-body -->
                            </div><!-- Curah Hujan -->


                        </div>
                    </div>



                </div>
            </div>
            <!-- /.row -->
            {{--
        </div><!-- /.container-fluid --> --}}
    </section>
    <!-- /.content -->
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawfilterpupuk);
      google.charts.setOnLoadCallback(drawtemuanreg);
      google.charts.setOnLoadCallback(drawfilterestate);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Estate', 'Stok Pupuk (ton)', { role: 'style' }],
          ['SLE',  3  ,'#001E3C'    ],
          ['RDE',  4  ,'#AB221D'    ],
          ['PLE',  5   ,'#5CAF50'   ],
          ['KNE', 10  ,'#5CAF50'    ],
          ['RGE', 9   ,'#5CAF50'   ],
          ['SGE', 4     ,'#5CAF50' ],
          ['SYE', 8      ,'#5CAF50'],
          ['UPE', 7      ,'#7CAF50'],
          ['BKE',9      ,'#8CAF50'],
        ]);

        var options = {
            chartArea: {},
        theme: 'material',
        // colors:[ '','#FF9800','#','#4CAF50', '#', '#4CAF50','#4CAF50' ,'#4CAF50' ],
        // hAxis: {title: 'Priority', titleTextStyle: {color: 'black',fontSize:'15',fontName:'"Arial"'}},
        //   title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'none' }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('stokpupukreg1'));

        chart.draw(data, options);
      }

      function drawfilterpupuk() {
        var data = google.visualization.arrayToDataTable([
          ['pupuk', 'pupuk (ton)', { role: 'style' }],
          ['NPK',  3  ,'#001E3C'    ],
          ['MOP',  4  ,'#AB221D'    ],
          ['Kieserite',  4  ,'#AB221D'    ],
          
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

        var chart = new google.visualization.ColumnChart(document.getElementById('filterpupukreg1'));

        chart.draw(data, options);
      }

      function drawtemuanreg() {
        var data = google.visualization.arrayToDataTable([
          ['Estate', 'Temuan', { role: 'style' }],
          ['SLE',  5  ,'#001E3C'    ],
          ['RDE',  4  ,'#AB221D'    ],
          ['PLE',  7   ,'#5CAF50'   ],
          ['KNE', 9  ,'#5CAF50'    ],
          ['RGE', 9   ,'#5CAF50'   ],
          ['SGE', 6     ,'#5CAF50' ],
          ['SYE', 5      ,'#5CAF50'],
          ['UPE', 9      ,'#7CAF50'],
          ['BKE',4      ,'#8CAF50'],
        ]);

        var options = {
            chartArea: {},
        theme: 'material',
        // colors:[ '','#FF9800','#','#4CAF50', '#', '#4CAF50','#4CAF50' ,'#4CAF50' ],
        // hAxis: {title: 'Priority', titleTextStyle: {color: 'black',fontSize:'15',fontName:'"Arial"'}},
        //   title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'none' }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('temuanreg1'));

        chart.draw(data, options);
      }

      function drawfilterestate() {
        var data = google.visualization.arrayToDataTable([
          ['pupuk', 'Temuan', { role: 'style' }],
          ['OA',  3  ,'#001E3C'    ],
          ['OB',  4  ,'#AB221D'    ],
          ['OC',  4  ,'#AB221D'    ],
          ['OD',  4  ,'#AB221D'    ],
          
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

        var chart = new google.visualization.ColumnChart(document.getElementById('temuanfilterestate'));

        chart.draw(data, options);
      }
</script>