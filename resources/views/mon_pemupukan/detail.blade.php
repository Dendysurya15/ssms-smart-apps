@include('layout.header')
<style>
    #map {
        height: 500px;
    }

    .man-marker {
        /* color: white; */
        filter: invert(35%) sepia(63%) saturate(5614%) hue-rotate(2deg) brightness(102%) contrast(107%);
    }

    .label-bidang {
        font-size: 10pt;
        color: white;
        text-align: center;
        /* opacity: 0.6; */
    }

    .label-estate {
        font-size: 20pt;
        color: white;
        text-align: center;
        opacity: 0.4;

    }

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

                    <table id="tableDetail" class="display" style="width:100%">
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
                            @foreach ($queryData as $item)
                            <tr>
                                <td>{{$item['tanggal']}}</td>
                                <td>{{$item['blok']}}</td>
                                <td>{{$item['nama_pupuk']}}</td>
                                <td>{{$item['jumlah_pokok']}}</td>
                                <td>{{$item['terpupuk']}}</td>
                                <td>{{$item['kesesuaian_jenis']}}</td>
                                <td>{{$item['terlokasi']}}</td>
                                <td>{{$item['tersebar']}}</td>
                                <td>-</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="map"></div>
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

<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzh5V86q6kt8UKJ8YE3oDOW0OexAXmlz8">
</script>

<script>
    var blok = <?php echo json_encode($blokLatLn); ?>;
    var estate = <?php echo json_encode($plotEstateJson); ?>;
    var dataRaw = <?php echo json_encode($queryData); ?>;
    var plotLine = <?php echo json_encode($plotLine); ?>;
    var plotMarker = <?php echo json_encode($plotMarker); ?>;

    
    var blok = JSON.parse(blok);
    var plotLine = JSON.parse(plotLine);
    var plotMarker = JSON.parse(plotMarker);
    var estate = JSON.parse(estate);
    
    $(document).ready(function () {
        $('#tableDetail').DataTable();
    });

    var map = L.map('map').setView([-2.27462005615234, 111.61400604248], 13);
    // googleSat = L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}', {
    //     maxZoom: 20,
    //     subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    // }).addTo(map);

//   googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}',{
//         maxZoom: 13,
//         subdomains:['mt0','mt1','mt2','mt3']
//     }).addTo(map);
    map.options.minZoom = 13;
// map.options.maxZoom = 14;

    // //openstreetmap
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);


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
            geoJsonEst += '"' + estate['est'] +'"},'
            geoJsonEst += '"geometry"'
            geoJsonEst += ":"
            geoJsonEst += '{"coordinates"'
            geoJsonEst += ":"
            geoJsonEst += '[['
            geoJsonEst += estate['plot']
            geoJsonEst += ']],"type"'
            geoJsonEst += ":"
            geoJsonEst += '"Polygon"'
            geoJsonEst += '}},'

geoJsonEst = geoJsonEst.substring(0, geoJsonEst.length - 1);
geoJsonEst += ']}'

var estate = JSON.parse(geoJsonEst)

var test = L.geoJSON(estate, {
    onEachFeature: function(feature, layer){
        layer.myTag = 'EstateMarker'
        var label = L.marker(layer.getBounds().getCenter(), {
        icon: L.divIcon({
            className: 'label-estate',
            html: feature.properties.estate,
            iconSize: [100, 20]
        })
        }).addTo(map);
        layer.addTo(map);
    },
    style: function(feature) {
        switch (feature.properties.estate) {
            case 'Natai Baru Estate': return {
                color: "#003B73",
            opacity: 1,
            fillOpacity: 0.2,
            
        };
            case 'Rangda Estate':   return {color: "#003B73",
            opacity: 1,
            fillOpacity: 0.4,
          
        };
        }
    }
})
.addTo(map);
map.fitBounds(test.getBounds());

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
            getPlotStr += '"'+ blok[i]['blok'] +'",'
            getPlotStr += '"estate"'
            getPlotStr += ":"
            getPlotStr += '"'+ blok[i]['estate'] +'"'
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

L.geoJSON(blok, {
    onEachFeature: function(feature, layer){
        
        layer.myTag = 'BlokMarker'
        var label = L.marker(layer.getBounds().getCenter(), {
        icon: L.divIcon({
            className: 'label-bidang',
            html: feature.properties.blok,
            iconSize: [50, 10]
        })
        }).addTo(map);
        layer.addTo(map);
    },
    style: function(feature) {
        switch (feature.properties.estate) {
            case 'Natai Baru': return {color: "#297AD6"};
            case 'Rangda':   return {color: "#297AD6"};
        }
    }
})
.addTo(map);

var getLineStr = '{"type"'
getLineStr += ":"
getLineStr += '"FeatureCollection",'
getLineStr += '"features"'
getLineStr += ":"
getLineStr += '['

for (let i = 0; i < plotLine.length; i++) {
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
            getLineStr += plotLine[i]
            getLineStr += '],"type"'
            getLineStr += ":"
            getLineStr += '"LineString"'
            getLineStr += '}},'
        }
getLineStr = getLineStr.substring(0, getLineStr.length - 1);
getLineStr += ']}'

var line = JSON.parse(getLineStr)

L.geoJSON(line, {
    onEachFeature: function(feature, layer){
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

var layerMarkerMan = new Array();
    var greenIcon = L.icon({
    iconUrl: "https://srs-ssms.com/man.svg",
    // shadowUrl: 'https://srs-ssms.com/man.svg',
    className: "man-marker",
    iconSize:     [32,32], // size of the icon
    shadowSize:   [32, 32], // size of the shadow
    iconAnchor:   [16, 16], // point of the icon which will correspond to marker's location
    shadowAnchor: [0, 0],  // the same for the shadow
    popupAnchor:  [0, 0] // point from which the popup should open relative to the iconAnchor
});
    
    for (let i = 0; i < plotMarker.length; i++) {
                marker = L.marker(JSON.parse(plotMarker[i]), {icon: greenIcon}).addTo(map);
                layerMarkerMan.push(marker)
        }

</script>