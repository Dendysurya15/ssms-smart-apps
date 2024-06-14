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

    .selectCard:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
    }

    .selectCard {
        border-radius: 4px;
        background: #fff;
        box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
        transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
        cursor: pointer;
    }

    a,
    a:hover,
    a:focus,
    a:active {
        text-decoration: none;
        color: inherit;
    }
</style>

<div class="content-wrapper">

    <section class="content-header">
    </section>

    <section class="content">

        <div class="container-fluid pb-4">


            <div class="container-fluid pl-3 pr-3">
                <div class="row">
                    <div class="col-12 col-lg mb-1 dashboard_div">
                        <h2 style="color:#013C5E;font-weight: 550">Dashboard Taksasi
                        </h2>
                        <p style="color:#6C7C8B">Dashboard ini digunakan untuk mengamati hasil taksasi yang
                            dilakukan
                            disetiap estate secara otomatis update setiap hari.
                        </p>

                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <form class="" action="{{ route('dashboard') }}" method="get">
                            <input class="form-control" type="date" name="tgl" id="tgl">
                        </form>
                    </div>

                    <div class="col-2">
                        {{csrf_field()}}
                        <select id="reg" class="form-control">
                            <option selected disabled>Pilih Regional</option>
                            @foreach($reg as $key => $value)
                            <option value="{{$key}}" {{ $key==0 ? 'selected' : '' }}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <ul class="nav nav-tabs mt-3">
                    <li class="nav-item active"><a data-toggle="tab" href="#regionalTab" class="nav-link ">Regional &
                            Wilayah</a>
                    </li>
                    <li class="nav-item"><a data-toggle="tab" href="#estateTab" class="nav-link">Estate</a>
                    </li>
                    {{-- <li class="nav-item"><a data-toggle="tab" href="#realisasiTab" class="nav-link">Realisasi</a>
                    </li> --}}
                </ul>

                <div class="tab-content">
                    <div id="regionalTab" class="tab-pane fade in active">
                        <div class="card mt-3 p-3">
                            <h4 style="color:#013C5E;font-weight: 550">Rekap Taksasi Regional
                            </h4>
                            <table id="table-regional" class="display" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Regional</th>
                                        <th>Luas (Ha)</th>
                                        <th>Jumlah Blok</th>
                                        <th>Ritase</th>
                                        <th>AKP (%)</th>
                                        <th>Taksasi (Kg)</th>
                                        <th>Kebutuhan Pemanen</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="card mt-3 p-3">
                                    <h4 style="color:#013C5E;font-weight: 550">Rekap Taksasi Wilayah
                                    </h4>
                                    <table id="table-wilayah" class="display" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Wilayah</th>
                                                <th>Luas (Ha)</th>
                                                <th>Jumlah Blok</th>
                                                <th>Ritase</th>
                                                <th>AKP (%)</th>
                                                <th>Taksasi (Kg)</th>
                                                <th>Kebutuhan Pemanen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="card mt-3 p-3">
                                    <h4 style="color:#013C5E;font-weight: 550">Grafik Tonase dan AKP Wilayah
                                    </h4>
                                    <div id="chartTonaseAKPWil"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="card mt-3 p-3">
                                    <h4 style="color:#013C5E;font-weight: 550">Rekap Taksasi Estate
                                    </h4>

                                    <table id="table-estate" class="display" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Estate</th>
                                                <th>Luas (Ha)</th>
                                                <th>Jumlah Blok</th>
                                                <th>Ritase</th>
                                                <th>AKP (%)</th>
                                                <th>Taksasi (Kg)</th>
                                                <th>Kebutuhan Pemanen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card mt-3 p-3">
                                    <h4 style="color:#013C5E;font-weight: 550">Grafik Tonase dan AKP Estate
                                    </h4>
                                    <div id="chartTonaseAKPEst"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="estateTab" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col">
                                <div class="card mt-3 p-3">
                                    <h4 style="color:#013C5E;font-weight: 550">Rekap Taksasi Estate
                                    </h4>
                                    <div class="row">

                                        <div class="col-2">
                                            <select id="est" class="form-control">
                                                <option selected disabled>Pilih Estate</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <table id="table-afdeling" class="display" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Afdeling</th>
                                                    <th>Luas (Ha)</th>
                                                    <th>Jumlah Blok</th>
                                                    <th>Ritase</th>
                                                    <th>AKP (%)</th>
                                                    <th>Taksasi (Kg)</th>
                                                    <th>Kebutuhan Pemanen</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card mt-3 p-3">
                                    <h4 style="color:#013C5E;font-weight: 550">Chart Tonase dan AKP Estate Per Afdeling
                                    </h4>
                                    <div id="ChartGrafikTonaseAfdeling"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- <div id="realisasiTab" class="tab-pane fade in active">
                        <h1>Halaman realisasi</h1>
                    </div> --}}
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

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    $(document).ready(function(){

        $('a[href="#regionalTab"]').click();

        var options = {
                        series: [
                            {
                                name: 'Taksasi (Kg)',
                                data: [1]
                            },
                            {
                                name: 'AKP (%)',
                                data: [2]
                            }
                        ],
                        chart: {
                            type: 'bar',
                            
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            },
                        },
                        colors: ['#ffb400', '#1984c5'],
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: ['Wilayah 1'],
                        },
                        yaxis: [{
                            title: {
                                text: 'Taksasi (Kg)'
                            }
                        }, {
                            opposite: true,
                            title: {
                                text: 'AKP (%)'
                            }
                        }],
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: [{
                                formatter: function (val) {
                                    return val + " Kg"
                                }
                            }, {
                                formatter: function (val) {
                                    return val + " %"
                                }
                            }]
                        }
                    };

        var chartTonaseAKPWil = new ApexCharts(document.querySelector("#chartTonaseAKPWil"), options);
        chartTonaseAKPWil.render();
        var chartTonaseAKPEst = new ApexCharts(document.querySelector("#chartTonaseAKPEst"), options);
        chartTonaseAKPEst.render();
        var ChartGrafikTonaseAfdeling = new ApexCharts(document.querySelector("#ChartGrafikTonaseAfdeling"), options);
        ChartGrafikTonaseAfdeling.render();
        // Set default date to today
        var dateToday = new Date().toISOString().slice(0,10);
        $('#tgl').val(dateToday);

        // Function to initialize or reload DataTable
        function loadDataTableRegionalWilayah(date, regionalId) {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('get-data-regional-wilayah') }}",
                method: "GET",
                cache: false,
                data: {
                    _token: _token,
                    tgl_request: date,
                    id_reg: regionalId,
                },
                success: function(result) {
                    var parseResult = JSON.parse(result);      
                    var dataReg = [];
                    var dataWil = [];
                    var dataEst = [];

                    $.each(parseResult['data_reg'], function(regional, values) {
                        dataReg.push({
                            "regional": regional,
                            "luas": values.luas,
                            "jumlahBlok": values.jumlahBlok,
                            "akp": values.akp,
                            "taksasi": values.taksasi,
                            "ritase": values.ritase,
                            "keb_pemanen": values.keb_pemanen
                        });
                    });

                    $.each(parseResult['data_wil'], function(wilayah, values) {
                        dataWil.push({
                            "wilayah": wilayah,
                            "luas": values.luas,
                            "jumlahBlok": values.jumlahBlok,
                            "akp": values.akp,
                            "taksasi": values.taksasi,
                            "ritase": values.ritase,
                            "keb_pemanen": values.keb_pemanen
                        });
                    });

                    $.each(parseResult['data_est'], function(estate, values) {
                        dataEst.push({
                            "estate": estate,
                            "luas": values.luas,
                            "jumlahBlok": values.jumlahBlok,
                            "akp": values.akp,
                            "taksasi": values.taksasi,
                            "ritase": values.ritase,
                            "keb_pemanen": values.keb_pemanen
                        });
                    });

                    // Initialize or reload DataTable
                    if ($.fn.dataTable.isDataTable('#table-regional')) {
                        // If DataTable already exists, destroy it and create a new one
                        $('#table-regional').DataTable().clear().destroy();
                    }

                 

                    $('#table-regional').DataTable({
                        "processing": true,
                        "serverSide": false,
                        scrollX: true,
                        "data": dataReg,
                        "columns": [
                            { "data": "regional", "title": "Regional" },
                            { "data": "luas", "title": "Luas" },
                            { "data": "jumlahBlok", "title": "Jumlah Blok" },
                            { "data": "akp", "title": "AKP" },
                            { "data": "taksasi", "title": "Taksasi" },
                            { "data": "ritase", "title": "Ritase" },
                            { "data": "keb_pemanen", "title": "Keb Pemanen" }
                        ]
                    });

                    if ($.fn.dataTable.isDataTable('#table-wilayah')) {
                        // If DataTable already exists, destroy it and create a new one
                        $('#table-wilayah').DataTable().clear().destroy();
                    }


                    $('#table-wilayah').DataTable({
                        "processing": true,
                        "serverSide": false,
                        scrollX: true,
                        "data": dataWil,
                        "pageLength": 25,
                        "columns": [
                            { "data": "wilayah", "title": "Wilayah" },
                            { "data": "luas", "title": "Luas" },
                            { "data": "jumlahBlok", "title": "Jumlah Blok" },
                            { "data": "akp", "title": "AKP" },
                            { "data": "taksasi", "title": "Taksasi" },
                            { "data": "ritase", "title": "Ritase" },
                            { "data": "keb_pemanen", "title": "Keb Pemanen" }
                        ]
                    });


                    if ($.fn.dataTable.isDataTable('#table-estate')) {
                        // If DataTable already exists, destroy it and create a new one
                        $('#table-estate').DataTable().clear().destroy();
                    }

                    $('#table-estate').DataTable({
                        "processing": true,
                        "serverSide": false,
                        scrollX: true,
                        "data": dataEst,
                        "pageLength": 10,
                        "columns": [
                            { "data": "estate", "title": "Estate" },
                            { "data": "luas", "title": "Luas" },
                            { "data": "jumlahBlok", "title": "Jumlah Blok" },
                            { "data": "akp", "title": "AKP" },
                            { "data": "taksasi", "title": "Taksasi" },
                            { "data": "ritase", "title": "Ritase" },
                            { "data": "keb_pemanen", "title": "Keb Pemanen" }
                        ]
                    });

                    var taksasiDataWil = [];
                    var akpDataWil = [];
                    var chartCategoriesWil = [];
                    var taksasiDataEst = [];
                    var akpDataEst = [];
                    var chartCategoriesEst = [];

                    $.each(parseResult['data_wil'], function(wilayah, values) {
                        chartCategoriesWil.push(wilayah);
                        taksasiDataWil.push(values.taksasi === '-' ? 0 : values.taksasi);  // Convert '-' to 0 for the chart
                        akpDataWil.push(values.akp === '-' ? 0 : values.akp);  // Convert '-' to 0 for the chart
                    });

                    chartTonaseAKPWil.updateSeries([{
                        name: 'AKP (%)',
                        data: akpDataWil
                    }, {
                        name: 'Taksasi (Kg)',
                        data: taksasiDataWil
                    }]);

                    chartTonaseAKPWil.updateOptions({
                        xaxis: {
                            categories: chartCategoriesWil
                        }
                    });


                    $.each(parseResult['data_est'], function(estate, values) {
                        chartCategoriesEst.push(estate);
                        taksasiDataEst.push(values.taksasi === '-' ? 0 : values.taksasi);  // Convert '-' to 0 for the chart
                        akpDataEst.push(values.akp === '-' ? 0 : values.akp);  // Convert '-' to 0 for the chart
                    });

                    chartTonaseAKPEst.updateSeries([{
                        name: 'AKP (%)',
                        data: akpDataEst
                    }, {
                        name: 'Taksasi (Kg)',
                        data: taksasiDataEst
                    }]);

                    chartTonaseAKPEst.updateOptions({
                        xaxis: {
                            categories: chartCategoriesEst
                        }
                    });
                }
            });
        }

        // Load DataTable for the first time with today's date
        loadDataTableRegionalWilayah(dateToday, $('#reg').val());

        // Event listener for date input change
        $('#tgl').on('change', function() {
            var selectedDate = $(this).val();
            var regionalId =  $('#reg').val()
            loadDataTableRegionalWilayah(selectedDate, regionalId);
            loadDataTableEstate( $('#est').val(), selectedDate)
        });

        if ($('#reg option:selected').length === 0) {
            $('#reg option:first').prop('selected', true);
        }

    function loadEstateOptions(regionalId) {
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('getNameEstate') }}",
            method: "POST",
            data: {
                _token: _token,
                id_reg: regionalId
            },
            success: function(result) {

                $('#est').empty().append(result);
                $('#est option:first').prop('selected', true);
                var selectedEstateId = $('#est').val();
                var selectedDate = $('#tgl').val();
                loadDataTableEstate(selectedEstateId, selectedDate);
            },
            error: function(xhr, status, error) {
                console.error("An error occurred while fetching estates: ", error);
            }
        });
        }

        // Event listener for Regional dropdown change
        $('#reg').on('change', function() {
            var selectedRegionalId = $(this).val();
            loadEstateOptions(selectedRegionalId);
            selectedDate = $('#tgl').val()
            loadDataTableRegionalWilayah($('#tgl').val(),  selectedRegionalId)
        });

        // Load estates for the default selected regional on page load
        var defaultRegionalId = $('#reg').val();
        if (defaultRegionalId) {
            loadEstateOptions(defaultRegionalId);
        }


        function loadDataTableEstate(estate, selectedDate) {
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('get-data-estate') }}",
                method: "GET",
                data: {
                    _token: _token,
                    estate_request: estate,
                    tgl_request: selectedDate
                },
                success: function(result) {
                    var parseResult = JSON.parse(result);      
                    var dataEst = [];

                    $.each(parseResult['data_estate'], function(afdeling, values) {
                        dataEst.push({
                            "afdeling": afdeling,
                            "luas": values.luas,
                            "jumlahBlok": values.jumlahBlok,
                            "akp": values.akp,
                            "taksasi": values.taksasi,
                            "ritase": values.ritase,
                            "keb_pemanen": values.keb_pemanen
                        });
                    });
                    if ($.fn.dataTable.isDataTable('#table-afdeling')) {
                        // If DataTable already exists, destroy it and create a new one
                        $('#table-afdeling').DataTable().clear().destroy();
                    }


                    $('#table-afdeling').DataTable({
                        "processing": true,
                        "responsive": true,
                        scrollX: true,
                        "serverSide": false,
                        "data": dataEst,
                        "pageLength": 25,
                        "columns": [
                            { "data": "afdeling", "title": "Afdeling" },
                            { "data": "luas", "title": "Luas" },
                            { "data": "jumlahBlok", "title": "Jumlah Blok" },
                            { "data": "akp", "title": "AKP" },
                            { "data": "taksasi", "title": "Taksasi" },
                            { "data": "ritase", "title": "Ritase" },
                            { "data": "keb_pemanen", "title": "Keb Pemanen" }
                        ]
                    });

                    var taksasiDataAfd = [];
                    var akpDataAfd = [];
                    var chartCategoriesAfd = [];

                    $.each(parseResult['data_estate'], function(afdeling, values) {
                        chartCategoriesAfd.push(afdeling);
                        taksasiDataAfd.push(values.taksasi === '-' ? 0 : values.taksasi);  // Convert '-' to 0 for the chart
                        akpDataAfd.push(values.akp === '-' ? 0 : values.akp);  // Convert '-' to 0 for the chart
                    });

                    ChartGrafikTonaseAfdeling.updateSeries([{
                        name: 'AKP (%)',
                        data: akpDataAfd
                    }, {
                        name: 'Taksasi (Kg)',
                        data: taksasiDataAfd
                    }]);

                    ChartGrafikTonaseAfdeling.updateOptions({
                        xaxis: {
                            categories: chartCategoriesAfd
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred while loading data for another data table: ", error);
                }
            });
        }

        // Event listener for #est dropdown change
        $('#est').on('change', function() {
            var selectedEstateId = $(this).val();
            var selectedDate = $('#tgl').val(); // Get the selected date from #tgl

            loadDataTableEstate(selectedEstateId, selectedDate);
        });
    });
</script>