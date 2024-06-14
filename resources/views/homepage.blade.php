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


    #map {
        height: 800px;
    }

    .legend {
        padding: 6px 8px;
        font: 14px Arial, Helvetica, sans-serif;
        background: white;
        /* background: rgba(255, 255, 255, 0.8); */
        /*box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);*/
        /*border-radius: 5px;*/
        line-height: 24px;
        color: #555;
    }

    .legend h4 {
        text-align: center;
        font-size: 16px;
        margin: 2px 12px 8px;
        color: #777;
    }

    .legend span {
        position: relative;
        bottom: 3px;
    }

    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin: 0 8px 0 0;
        opacity: 0.7;
    }

    .legend i.icon {
        background-size: 18px;
        background-color: rgba(255, 255, 255, 1);
    }

    .myCSSClass {
        /* background: green; */
        font-size: 25pt;
        border: 2px solid cyan
    }

    .man-marker {
        /* color: white; */
        filter: invert(35%) sepia(63%) saturate(5614%) hue-rotate(2deg) brightness(102%) contrast(107%);
    }

    .leaflet-tooltip-left.myCSSClass::before {
        border-left-color: cyan;
    }

    .leaflet-tooltip-right.myCSSClass::before {
        border-right-color: cyan;
    }

    .label-bidang {
        font-size: 10pt;
        color: white;
        text-align: center;
        opacity: 0.6;
    }

    .label-estate {
        font-size: 20pt;
        color: white;
        text-align: center;
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


                        <div class="row">
                            <div class="card mt-3 p-3 col-12">

                                <h4 style="color:#013C5E;font-weight: 550">Tracking Plot User Taksasi
                                </h4>
                                <div id="map"></div>
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


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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

<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzh5V86q6kt8UKJ8YE3oDOW0OexAXmlz8">
</script>

<script>
    date = new Date().toISOString().slice(0, 10)
    var map = L.map('map').setView([-2.27462005615234, 111.61400604248], 13);

    // satelite
    const googleSat = L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
    ).addTo(map);


    var legendVar = ''

function drawUserTaksasi(arrData) {
    var legendMaps = L.control({
        position: "bottomright"
    });

    const newUserTaksasi = Object.entries(arrData);

    legendMaps.onAdd = function(map) {

        var div = L.DomUtil.create("div", "legend");
        div.innerHTML += "<h4>Keterangan :</h4>";
        div.innerHTML += '<div >';

        var colorAfd = ''
        newUserTaksasi.forEach(element => {
            switch (element[0]) {
                case 'OA':
                    colorAfd = '#ff1744'
                    break;
                case 'OB':
                    colorAfd = '#d500f9'
                    break;
                case 'OC':
                    colorAfd = '#ffa000'
                    break;
                case 'OD':
                    colorAfd = '#00b0ff'
                    break;
                case 'OE':
                    colorAfd = '#ff1744'
                    break;
                    case 'OF':
                    colorAfd = '#666666'
                    break;
                case 'OG':
                    colorAfd = '#666666'
                    break;
                    case 'OH':
                    colorAfd = '#666666'
                    break;
                    case 'OI':
                    colorAfd = '#ba9355'
                    break;
                    case 'OJ':
                    colorAfd = '#ccff00'
                    break;
                    case 'OK':
                    colorAfd = '#8f9e8a'
                    break;
                    case 'OL':
                    colorAfd = '#14011c'
                    break;
                    case 'OM':
                    colorAfd = '#01b9c5'
                    break;
                default:
                    // code block
            }
            div.innerHTML += '<i style="background: ' + colorAfd + '"></i><span style="font-weight:bold">' + element[0] + '</span>';
            div.innerHTML += '<span> (';
            if (element[1].length != 1) {
                var inc = 1;
                var size = element[1].length
                element[1].forEach(userName => {
                    if (inc == size) {
                        div.innerHTML += '<span > ' + userName + ' </span>';
                    } else {
                        div.innerHTML += '<span > ' + userName + ', </span>';
                    }
                    inc++
                });
            } else {
                element[1].forEach(userName => {
                    div.innerHTML += '<span> ' + userName + '</span>';
                });
            }

            div.innerHTML += '<span> )<br></span>';
        });

        // div.innerHTML += '<br>';
        // div.innerHTML += '<i style="background: #FFFFFF"></i><span>Ice</span><br>';
        // div.innerHTML += '      <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png" alt="" style="width:13px"><span>    Titik Start Taksasi</span><br>';
        // div.innerHTML += '      <img src="remove.png" alt="" style="width:15px"><span> Jalur Taksasi</span><br>';
        div.innerHTML += '</div>';



        return div;
    };

    legendMaps.addTo(map);


    legendVar = legendMaps
}


var titleEstate = new Array();

function drawEstatePlot(est, plot) {
    var geoJsonEst = '{"type"'
    geoJsonEst += ":"
    geoJsonEst += '"FeatureCollection",'
    geoJsonEst += '"features"'
    geoJsonEst += ":"
    geoJsonEst += '['

    geoJsonEst += '{"type"'
    geoJsonEst += ":"
    geoJsonEst += '"Feature",'
    geoJsonEst += '"properties"'
    geoJsonEst += ":"
    geoJsonEst += '{"estate"'
    geoJsonEst += ":"
    geoJsonEst += '"' + est + '"},'
    geoJsonEst += '"geometry"'
    geoJsonEst += ":"
    geoJsonEst += '{"coordinates"'
    geoJsonEst += ":"
    geoJsonEst += '[['
    geoJsonEst += plot
    geoJsonEst += ']],"type"'
    geoJsonEst += ":"
    geoJsonEst += '"Polygon"'
    geoJsonEst += '}},'

    geoJsonEst = geoJsonEst.substring(0, geoJsonEst.length - 1);
    geoJsonEst += ']}'

    var estate = JSON.parse(geoJsonEst)

    var estateObj = L.geoJSON(estate, {
            onEachFeature: function(feature, layer) {
                layer.myTag = 'EstateMarker'
                var label = L.marker(layer.getBounds().getCenter(), {
                    icon: L.divIcon({
                        className: 'label-estate',
                        html: feature.properties.estate,
                        iconSize: [100, 20]
                    })
                }).addTo(map);
                titleEstate.push(label)
                layer.addTo(map);
            },
            style: function(feature) {
                switch (feature.properties.estate) {
                    case 'Sulung Estate':
                        return {
                            color: "#003B73",
                                opacity: 1,
                                fillOpacity: 0.2,

                        };
                    case 'Rangda Estate':
                        return {
                            color: "#003B73",
                                opacity: 1,
                                fillOpacity: 0.4,

                        };
                    case 'Kenambui Estate':
                        return {
                            color: "#003B73",
                                opacity: 1,
                                fillOpacity: 0.2,

                        };
                    case 'Pulau Estate':
                        return {
                            color: "#003B73",
                                opacity: 1,
                                fillOpacity: 0.4,

                        };
                        default:
                        return {    
                            color: "#003B73",
                                opacity: 1,
                                fillOpacity: 0.4,
                        };
                }
            }
        })
        .addTo(map);

    map.fitBounds(estateObj.getBounds());
}



var titleBlok = new Array();

function drawBlokPlot(blok) {
    var getPlotStr = '{"type"'
    getPlotStr += ":"
    getPlotStr += '"FeatureCollection",'
    getPlotStr += '"features"'
    getPlotStr += ":"
    getPlotStr += '['
    for (let i = 0; i < blok.length; i++) {
        getPlotStr += '{"type"'
        getPlotStr += ":"
        getPlotStr += '"Feature",'
        getPlotStr += '"properties"'
        getPlotStr += ":"
        getPlotStr += '{"blok"'
        getPlotStr += ":"
        getPlotStr += '"' + blok[i]['blok'] + '",'
        getPlotStr += '"estate"'
        getPlotStr += ":"
        getPlotStr += '"' + blok[i]['estate'] + '",'
        getPlotStr += '"afdeling"'
        getPlotStr += ":"
        getPlotStr += '"' + blok[i]['afdeling'] + '"'
        getPlotStr += '},'
        getPlotStr += '"geometry"'
        getPlotStr += ":"
        getPlotStr += '{"coordinates"'
        getPlotStr += ":"
        getPlotStr += '[['
        getPlotStr += blok[i]['latln']
        getPlotStr += ']],"type"'
        getPlotStr += ":"
        getPlotStr += '"Polygon"'
        getPlotStr += '}},'
    }
    getPlotStr = getPlotStr.substring(0, getPlotStr.length - 1);
    getPlotStr += ']}'


    var blok = JSON.parse(getPlotStr)

    console.log(blok)
    L.geoJSON(blok, {
            onEachFeature: function(feature, layer) {

                layer.myTag = 'BlokMarker'
                var label = L.marker(layer.getBounds().getCenter(), {
                    icon: L.divIcon({
                        className: 'label-bidang',
                        html: feature.properties.blok,
                        iconSize: [50, 10]
                    })
                }).addTo(map);

                titleBlok.push(label)
                layer.addTo(map);
            },
            style: function(feature) {
                switch (feature.properties.afdeling) {
                    case 'OA':
                        return {
                            fillColor: "#ff1744",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,
                        };
                    case 'OB':
                        return {
                            fillColor: "#d500f9",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,
                        };
                    case 'OC':
                        return {
                            fillColor: "#ffa000",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,
                        };
                    case 'OD':
                        return {
                            fillColor: "#00b0ff",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,
                        };

                    case 'OE':
                        return {
                            fillColor: "#67D98A",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,

                        };
                    case 'OF':
                        return {
                            fillColor: "#666666",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,

                        };
                    case 'OG':
                        return {
                            fillColor: "#666666",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,

                        };
                        case 'OH':
                        return {
                            fillColor: "#666666",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,

                        };
                        case 'OI':
                        return {
                            fillColor: "#ba9355",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,

                        };
                        case 'OJ':
                        return {
                            fillColor: "#ccff00",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,

                        };
                        case 'OK':
                        return {
                            fillColor: "#8f9e8a",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,

                        };
                        case 'OL':
                        return {
                            fillColor: "#14011c",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,

                        };
                        case 'OM':
                        return {
                            fillColor: "#01b9c5",
                                color: 'white',
                                fillOpacity: 0.4,
                                opacity: 0.4,

                        };
                }
            }
        })
        ;
}

function drawLineTaksasi(line) {
    var getLineStr = '{"type"'
    getLineStr += ":"
    getLineStr += '"FeatureCollection",'
    getLineStr += '"features"'
    getLineStr += ":"
    getLineStr += '['

    for (let i = 0; i < line.length; i++) {
        getLineStr += '{"type"'
        getLineStr += ":"
        getLineStr += '"Feature",'
        getLineStr += '"properties"'
        getLineStr += ":"
        getLineStr += '{},'
        getLineStr += '"geometry"'
        getLineStr += ":"
        getLineStr += '{"coordinates"'
        getLineStr += ":"
        getLineStr += '['
        getLineStr += line[i]
        getLineStr += '],"type"'
        getLineStr += ":"
        getLineStr += '"LineString"'
        getLineStr += '}},'
    }
    getLineStr = getLineStr.substring(0, getLineStr.length - 1);
    getLineStr += ']}'

    var line = JSON.parse(getLineStr)

    L.geoJSON(line, {
            onEachFeature: function(feature, layer) {
                layer.myTag = 'LineMarker'
                layer.addTo(map);
            },
            style: function(feature) {
                return {
                    weight: 2,
                    opacity: 1,
                    color: 'yellow',
                    fillOpacity: 0.7
                };
            }
        })
        .addTo(map);
}

function removeMarkers() {
        map.eachLayer(function(layer) {
            if (layer.myTag && (layer.myTag === "EstateMarker" || layer.myTag === "BlokMarker" || layer.myTag === "LineMarker")) {
                map.removeLayer(layer);
            }
        });
    }

    function markerDelAgain() {
        titleBlok.forEach(layer => map.removeLayer(layer));
        titleEstate.forEach(layer => map.removeLayer(layer));
        layerMarkerMan.forEach(layer => map.removeLayer(layer));
        map.removeControl(legendVar);
    }



var marker = ''
var layerMarkerMan = new Array();

function drawMarkerMan(arrData) {

    for (let i = 0; i < arrData.length; i++) {

        switch (arrData[i]['afdeling']) {
            case 'OA':
                marker = 'manMarkerOA'
                colorMarker = 'red'
                break;
            case 'OB':
                marker = 'manMarkerOB'
                colorMarker = 'violet'
                break;
            case 'OC':
                marker = 'manMarkerOC'
                colorMarker = 'gold'
                break;
            case 'OD':
                marker = 'manMarkerOD'
                colorMarker = 'blue'
                break;
            case 'OE':
                marker = 'manMarkerOE'
                break;
            case 'OF':
                marker = 'manMarkerOF'
                break;
                case 'OG':
                marker = 'manMarkerOF'
                colorMarker = 'grey'
                break;
                case 'OH':
                marker = 'manMarkerOF'
                colorMarker = 'gold'
                break;
                case 'OI':
                marker = 'manMarkerOF'
                colorMarker = 'violet'
                break;
                case 'OJ':
                marker = 'manMarkerOF'
                colorMarker = 'grey'
                break;
                case 'OK':
                marker = 'manMarkerOF'
                colorMarker = 'red'
                break;
                case 'OL':
                marker = 'manMarkerOF'
                colorMarker = 'blue'
                break;
                case 'OM':
                marker = 'manMarkerOF'
                colorMarker = 'grey'
                break;
            default:
                // code block
        }

        let start = new L.Icon({
            iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-" + colorMarker + ".png",
            shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
            iconSize: [14, 21],
            iconAnchor: [7, 22],
            popupAnchor: [1, -34],
            shadowSize: [28, 20],
        });

        var latlonFinish = JSON.parse(arrData[i]['plotAwal'])
        marker = L.marker(latlonFinish, {
            icon: start
        }).addTo(map);

        layerMarkerMan.push(marker)
    }


    //     console.log(line)
    //     var greenIcon = L.icon({
    //     iconUrl: "https://srs-ssms.com/man.svg",
    //     // shadowUrl: 'https://srs-ssms.com/man.svg',
    //     className: "man-marker",
    //     iconSize:     [32,32], // size of the icon
    //     shadowSize:   [32, 32], // size of the shadow
    //     iconAnchor:   [16, 16], // point of the icon which will correspond to marker's location
    //     shadowAnchor: [0, 0],  // the same for the shadow
    //     popupAnchor:  [0, 0] // point from which the popup should open relative to the iconAnchor
    // });

    //     for (let i = 0; i < line.length; i++) {
    //                 marker = L.marker(JSON.parse(line[i]), {icon: greenIcon}).addTo(map);
    //                 layerMarkerMan.push(marker)
    //         }
}


function getPlotEstate(est, date) {

var _token = $('input[name="_token"]').val();

const params = new URLSearchParams(window.location.search)
var paramArr = [];
for (const param of params) {
    paramArr = param
}

$.ajax({
    url: "{{ route('plotEstate') }}",
    method: "POST",
    data: {
        est: est,
        _token: _token,
        tgl: date
    },
    success: function(result) {
        var estate = JSON.parse(result);

        console.log(estate)
        drawEstatePlot(estate['est'], estate['plot'])
    }
})
}

function getPlotBlok(est, date) {

var _token = $('input[name="_token"]').val();

const params = new URLSearchParams(window.location.search)
var paramArr = [];
for (const param of params) {
    paramArr = param
}

$.ajax({
    url: "{{ route('plotBlok') }}",
    method: "POST",
    data: {
        est: est,
        _token: _token,
        tgl: date
    },
    success: function(result) {
        
        var blok = JSON.parse(result);

        
        drawBlokPlot(blok)
    }
})
}

function exportPDF(date, est) {

var _token = $('input[name="_token"]').val();

var url = '/exportPdfTaksasi/' + est + '/' + date;
window.open(
    url,
    '_blank' // <- This is what makes it open in a new window.
);
}

function getlineTaksasi(est, date) {
var _token = $('input[name="_token"]').val();

const params = new URLSearchParams(window.location.search)
var paramArr = [];
for (const param of params) {
    paramArr = param
}

$.ajax({
    url: "{{ route('plotLineTaksasi') }}",
    method: "POST",
    data: {
        est: est,
        _token: _token,
        tgl: date
    },
    success: function(result) {
        var line = JSON.parse(result);
        drawLineTaksasi(line)
    }
})
}

function getMarkerMan(est, date) {

var _token = $('input[name="_token"]').val();

const params = new URLSearchParams(window.location.search)
var paramArr = [];
for (const param of params) {
    paramArr = param
}

$.ajax({
    url: "{{ route('plotMarkerMan') }}",
    method: "POST",
    data: {
        est: est,
        _token: _token,
        tgl: date
    },
    success: function(result) {
        var marker = JSON.parse(result);
        drawMarkerMan(marker)

    }
})
}

function getUserTaksasi(est, date) {

var _token = $('input[name="_token"]').val();

const params = new URLSearchParams(window.location.search)
var paramArr = [];
for (const param of params) {
    paramArr = param
}

$.ajax({
    url: "{{ route('plotUserTaksasi') }}",
    method: "POST",
    data: {
        est: est,
        _token: _token,
        tgl: date
    },
    success: function(result) {
        var marker = JSON.parse(result);

        drawUserTaksasi(marker)

    }
})
}


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
            removeMarkers();
            markerDelAgain()
            getPlotEstate($('#est').val(), selectedDate)
            getPlotBlok($('#est').val(), selectedDate)
            getlineTaksasi($('#est').val(), selectedDate)
            getMarkerMan($('#est').val(), selectedDate)
            getUserTaksasi($('#est').val(), selectedDate)
           
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
           
                 getPlotEstate(selectedEstateId, selectedDate)
            getPlotBlok(selectedEstateId, selectedDate)
            getlineTaksasi(selectedEstateId, selectedDate)
            getMarkerMan(selectedEstateId, selectedDate)
            getUserTaksasi(selectedEstateId, selectedDate)
        
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
            removeMarkers();
            markerDelAgain()
            getPlotEstate(selectedEstateId, selectedDate)
            getPlotBlok(selectedEstateId, selectedDate)
            getlineTaksasi(selectedEstateId, selectedDate)
            getMarkerMan(selectedEstateId, selectedDate)
            getUserTaksasi(selectedEstateId, selectedDate)
            
        });
    });


</script>