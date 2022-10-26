@include('layout.header')
<style>
    #map {
        height: 800px;
    }

    .myCSSClass {
        /* background: green; */
        font-size: 25pt;
        border: 2px solid cyan
    }

    .leaflet-tooltip-left.myCSSClass::before {
        border-left-color: cyan;
    }

    .leaflet-tooltip-right.myCSSClass::before {
        border-right-color: cyan;
    }

    .label-bidang {
        font-size: 20pt;
        color: white;
        text-align: center;
    }
</style>
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


                <div id="map"></div>
                <div id="map-canvas" style="width:700px;height:500px">
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

<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzh5V86q6kt8UKJ8YE3oDOW0OexAXmlz8">
</script>

<script>
    var map = L.map('map').setView([-2.27462005615234, 111.61400604248], 13);

    //openstreetmap
    // L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //     maxZoom: 19,
    //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    // }).addTo(map);

    //google street
    // googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}',{
    //     maxZoom: 13,
    //     subdomains:['mt0','mt1','mt2','mt3']
    // }).addTo(map);

    // satelite
    googleSat = L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);

    //google terrain
    // googleTerrain = L.tileLayer('http://{s}.google.com/vt?lyrs=p&x={x}&y={y}&z={z}',{
    //     maxZoom: 20,
    //     subdomains:['mt0','mt1','mt2','mt3']
    // }).addTo(map);

    // var circle = L.circle([-2.27462005615234, 111.61400604248], {
    //     color: 'red',
    //     fillColor: '#f03',
    //     fillOpacity: 0.5,
    //     radius: 500
    // }).addTo(map)

    // var marker = L.marker([-2.27462005615234, 111.61400604248]).addTo(map);

    var estate = <?php echo json_encode($data_per_estate); ?>;
    var list_estate = <?php echo json_encode($list_estate); ?>;
    var blok_per_estate = <?php echo json_encode($blok_per_estate); ?>;
    
    estate = Object.entries(estate);
    blok_per_estate = Object.entries(blok_per_estate);
    list_estate = Object.entries(list_estate);

    
        const arrlatawal = [];
        const arrlngawal = [];
        const arrlatakhir = [];
        const arrlngakhir = [];

         for (let i = 0; i < list_estate.length; i++) {
            arrlatawal[i] = [];
            arrlngawal[i] = [];
            arrlatakhir[i] = [];
            arrlngakhir[i] = [];
             for (let j = 0; j < estate[i][1].length; j++) {

                var checkLatAwal =  estate[i][1][j]['lat_awal'].includes(";")
                var checkLonAwal =  estate[i][1][j]['lon_awal'].includes(";")
                var checkLatAkhir =  estate[i][1][j]['lat_akhir'].includes(";")
                var checkLonAkhir =  estate[i][1][j]['lon_akhir'].includes(";")
                if(checkLatAwal == true){
                    var splittedLatAwal = estate[i][1][j]['lat_awal'].split(';')
                    for (const element of splittedLatAwal) { // You can use `let` instead of `const` if you like
                        arrlatawal[i].push(element);
                    }
                }else{
                    arrlatawal[i].push(estate[i][1][j]['lat_awal']);
                }

                if(checkLonAwal == true){
                    var splittedLonAwal = estate[i][1][j]['lon_awal'].split(';')
                    for (const element of splittedLonAwal) { // You can use `let` instead of `const` if you like
                        arrlngawal[i].push(element);
                    }
                }else{
                    arrlngawal[i].push(estate[i][1][j]['lon_awal']);
                }

                if(checkLatAkhir == true){
                    var splittedLatAkhir = estate[i][1][j]['lat_akhir'].split(';')
                    for (const element of splittedLatAkhir) { // You can use `let` instead of `const` if you like
                        arrlatakhir[i].push(element);
                    }
                }else{
                    arrlatakhir[i].push(estate[i][1][j]['lat_akhir']);
                }

                if(checkLonAkhir == true){
                    var splittedLonAkhir = estate[i][1][j]['lon_akhir'].split(';')
                    for (const element of splittedLonAkhir) { // You can use `let` instead of `const` if you like
                        arrlngakhir[i].push(element);
                    }
                }else{
                    arrlngakhir[i].push(estate[i][1][j]['lon_akhir']);
                }
            }
        }

        var arrPlot = [];
        for (let i = 0; i < arrlatawal.length; i++) {
            arrPlot[i] = []
            for (let j = 0; j < arrlatawal[i].length; j++) {
                arrPlot[i].push([[arrlatawal[i][j], arrlngawal[i][j]], [arrlatakhir[i][j], arrlngakhir[i][j]]])
            }
        }

        // console.log(blok_per_estate);
      var blokPlot = [];
      for (let i = 0; i < blok_per_estate.length; i++) {
            blokPlot[i] = []
            for (let j = 0; j < blok_per_estate[i][1].length; j++) {
                blokPlot[i].push(blok_per_estate[i][1][j]['latln'])
            }
        }

        console.log(JSON.stringify(blokPlot));

        
        var latlngs = arrPlot[0]
        var latlngs2 = arrPlot[1]
    //     [
    //          [[-2.27462005615234, 111.61400604248],
    //  [-2.27551436424255, 111.614074707031]],
    // [[-2.2754065990448, 111.613746643066],
    //  [-2.27479457855225, 111.613998413086]],
    //     ]
    


    var polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
    var polyline = L.polyline(latlngs2, {color: 'blue'}).addTo(map);

    // zoom the map to the polyline
    map.fitBounds(polyline.getBounds());

    // create a red polygon from an array of LatLng points
// var latlngs = [[-2.292762824, 111.6062017],[-2.295260481, 111.6062847],[-2.295077952, 111.5972971],[-2.295078019, 111.5968261],[-2.292020507, 111.5968385],[-2.292762824, 111.6062017]];

// var polygon = L.polygon(latlngs, {color: 'red'}).addTo(map);

// // zoom the map to the polygon
// map.fitBounds(polygon.getBounds());

$testCoba = ''
var states =
{
  "type": "FeatureCollection",
  "features": [
    {
      "type": "Feature",
      "properties": {
        "blok": "L019",
      },
      "geometry": {
        "coordinates": [
            [
                [
                    111.6062017,
                    -2.292762824
                ],
                [
                    111.6062847,
                    -2.295260481
                ],
            [
                111.5972971,
                -2.295077952
            ],
            [
                111.5968261,
                -2.295078019
            ],
            [
                111.5968385,
                -2.292020507
            ],
            
          ]
        ],
        "type": "Polygon"
      }
    }
  ]
}

L.geoJSON(states, {
    onEachFeature: function(feature, layer){
            var label = L.marker(layer.getBounds().getCenter(), {
        icon: L.divIcon({
            className: 'label-bidang',
            html: feature.properties.blok,
            iconSize: [100, 20]
        })
        }).addTo(map);

        layer.addTo(map);
    },
    style: function(feature) {
        switch (feature.properties.party) {
            case 'Republican': return {color: "#ff0000"};
            case 'Democrat':   return {color: "#0000ff"};
        }
    }
})
.addTo(map);
// function onEachFeature(feature, layer) {
//     // does this feature have a property named popupContent?
//     if (feature.properties && feature.properties.popupContent) {
//         layer.bindPopup(feature.properties.popupContent);
//     }
// }
// L.geoJSON(states, {
//     style: function(feature) {
//         switch (feature.properties.party) {
//             case 'Republican': return {color: "#ff0000"};
//             case 'Democrat':   return {color: "#0000ff"};
//         }
//     }
// })
// onEachFeature: function(feature, layer){
//     var iconLabel = L.divIcon({
//         className : 'label-bidang',
//         html: '<b>' + feature.properties.blok + '</b>',
//         iconSize:[100, 20]
//     });

//     L.marker(layer.getBounds().getCenter(),{icon:iconLabel}).addTo(map);

//     layer.addTo(map)
// }
// .addTo(map);

//   map.on('zoomstart', function () {
//     var zoomLevel = map.getZoom();
//     var tooltip = $('.leaflet-tooltip');

//     switch (zoomLevel) {
//         case -2:
//             tooltip.css('font-size', 7);
//             break;
//         case -1:
//             tooltip.css('font-size', 10);
//             break;
//         case 0:
//             tooltip.css('font-size', 12);
//             break;
//         case 1:
//             tooltip.css('font-size', 14);
//             break;
//         case 2:
//             tooltip.css('font-size', 16);
//             break;
//         case 3:
//             tooltip.css('font-size', 18);
//             break;
//         default:
//             tooltip.css('font-size', 14);
//     }
// });

    // Hybrid: s,h;
    // Satellite: s;
    // Streets: m;
    // Terrain: p;

   

   
    // console.log(myArray[0][1].length)
    // console.log(JSON.stringify(myArray));
    // var result = Object.entries(estate)
    // console.log(result);

    // function initialize() {
    //     var mapOptions = {
    //         center: new google.maps.LatLng(-2.27462005615234, 111.61400604248),
    //         zoom: 11
    //     };

    //     var result_estate = Object.entries(estate)
    //     var result_list_estate = Object.entries(list_estate)


    //     console.log(result_estate[1].length);
    //     const arrlat = [];
    //     const arrlng = [];
    //     // console.log(list_estate[0]);
    //     for (let i = 0; i < result_estate.length; i++) {
    //         for (let index = 0; index < result_list_estate.length; index++) {

    //             // console.log(estate[list_estate[i]][index]['lat_awal']);
    //             // console.log(list_estate[i]);
    //             // arrlat.push(estate[list_estate[i]]['lat_awal']);
    //             // arrlng.push(estate[list_estate[i]]['lon_awal']);
    //         }
    //     }
    //     // console.log(arrlat);
    //     // console.log(arrlng);

    //     var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

    //     var blang = new google.maps.LatLng(-2.27462005615234, 111.61400604248);
    //     var bna = new google.maps.LatLng(-2.27551436424255, 111.614074707031);
    //     var rute_terbang = [blang, bna];

    //     var poly_rute = new google.maps.Polyline({
    //         path: rute_terbang,
    //         strokeColor: "#0000FF",
    //         strokeOpacity: 0.8,
    //         strokeWeight: 2
    //     });

    //     poly_rute.setMap(map);
    // }
    // google.maps.event.addDomListener(window, 'load', initialize);
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
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tanggal_upload',
                    name: 'tanggal_upload'
                },
                {
                    data: 'lokasi_kerja',
                    name: 'lokasi_kerja'
                },
                {
                    data: 'afdeling',
                    name: 'afdeling'
                },
                {
                    data: 'blok',
                    name: 'blok'
                },
                {
                    data: 'akp_round',
                    name: 'akp_round'
                },
                {
                    data: 'tak_round',
                    name: 'tak_round'
                },
                {
                    data: 'ritase',
                    name: 'ritase'
                },
                {
                    data: 'pemanen',
                    name: 'pemanen'
                },
                {
                    data: 'luas',
                    name: 'luas'
                },
                {
                    data: 'sph',
                    name: 'sph'
                },
                {
                    data: 'bjr',
                    name: 'bjr'
                },
                {
                    data: 'jumlah_path',
                    name: 'jumlah_path'
                },
                {
                    data: 'jumlah_janjang',
                    name: 'jumlah_janjang'
                },
                {
                    data: 'jumlah_pokok',
                    name: 'jumlah_pokok'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
        });
    });
    $(document).ready(function() {
        $('.dataTables_filter input[type="search"]').css({
            'width': '350px',
            'display': 'inline-block'
        });
    });
</script>