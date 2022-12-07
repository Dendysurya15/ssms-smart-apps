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

    .pagenumbers {

        margin-top: 30px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .pagenumbers button {
        width: 50px;
        height: 50px;

        appearance: none;
        border-radius: 5px;
        border: 1px solid white;
        outline: none;
        cursor: pointer;

        background-color: white;

        margin: 5px;
        transition: 0.4s;

        color: black;
        font-size: 18px;
        text-shadow: 0px 0px 4px rgba(0, 0, 0, 0.2);
        box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.2);
    }

    .pagenumbers button:hover {
        background-color: #013c5e;
        color: white
    }

    .pagenumbers button.active {
        background-color: #013c5e;
        color: white;
        box-shadow: inset 0px 0px 4px rgba(0, 0, 0, 0.2);
    }

    .pagenumbers button.active:hover {
        background-color: #353e44;
        color: white;
        box-shadow: inset 0px 0px 4px rgba(0, 0, 0, 0.2);
    }

    .table_wrapper {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
</style>
<div class="content-wrapper">

    <section class="content-header">
    </section>

    <section class="content">
        <div class="container-fluid " id="dataHistory">
            <div class="row">
                <div class="col-2">
                    Pilih Tanggal
                </div>
                <div class="col-2">
                    Pilih Estate
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    {{ csrf_field() }}
                    <form class="" action="{{ route('hish_tak') }}" method="get">
                        <input class="form-control" type="date" id="inputTanggal" name="tgl">
                    </form>
                </div>
                <div class="col-2">
                    <select id="nameEstate" class="form-control">

                    </select>
                </div>
            </div>
            <br>
            <h3>History Taksasi Panen</h3>
            <div class="container-fluid">

                <div class="row">
                    <div class="card" style="width: 100%">
                        <div class="card-body">
                            <p id="textData"></p>
                            <div class="table_wrapper">
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
                                    <tbody id="list" class="list">
                                    </tbody>

                                </table>
                            </div>

                            <div class="pagenumbers" id="pagination"></div>
                        </div>
                    </div>
                </div>

            </div>

            <br>
            <h3>Tracking User Taksasi</h3>
            <div id="map"></div>
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

<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzh5V86q6kt8UKJ8YE3oDOW0OexAXmlz8">
</script>

<script>
    date =  new Date().toISOString().slice(0, 10)
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

    // console.log(blokPlot)

    // create a red polygon from an array of LatLng points
    // var latlngs = [[-2.292762824, 111.6062017],[-2.295260481, 111.6062847],[-2.295077952, 111.5972971],[-2.295078019, 111.5968261],[-2.292020507, 111.5968385],[-2.292762824, 111.6062017]];

    // var polygon = L.polygon(latlngs, {color: 'red'}).addTo(map);

    // zoom the map to the polygon
    // map.fitBounds(polygon.getBounds());


var titleEstate = new Array();
function drawEstatePlot(est,plot){
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
            geoJsonEst += '"' + est +'"},'
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
    onEachFeature: function(feature, layer){
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
            case 'Sulung Estate': return {
                color: "#FBAB71",
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
map.fitBounds(estateObj.getBounds());
}

var titleBlok = new Array();
function drawBlokPlot(blok){
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

        titleBlok.push(label)
        layer.addTo(map);
    },
    style: function(feature) {
        switch (feature.properties.estate) {
            case 'Sulung': return {color: "#FBAB71"};
            case 'Rangda':   return {color: "#68BBE3"};
        }
    }
})
.addTo(map);
}

function drawLineTaksasi(line){
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
}

var removeMarkers = function() {
	map.eachLayer( function(layer) {

	  if ( layer.myTag &&  layer.myTag === "EstateMarker") {
		map.removeLayer(layer)
    	  }
      if(layer.myTag &&  layer.myTag === "BlokMarker"){
        map.removeLayer(layer)
      }
      if(layer.myTag &&  layer.myTag === "LineMarker"){
        map.removeLayer(layer)
      }
        });
}

    // var polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
    // var polyline = L.polyline(latlngs2, {color: 'yellow'}).addTo(map);

    // zoom the map to the polyline
    // map.fitBounds(polyline.getBounds());
    var layerMarkerMan = new Array();
    function drawMarkerMan(line){
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
    
    for (let i = 0; i < line.length; i++) {
                marker = L.marker(JSON.parse(line[i]), {icon: greenIcon}).addTo(map);
                layerMarkerMan.push(marker)
        }
   }

   function markerDelAgain() {
for(i=0;i<titleBlok.length;i++) {
    map.removeLayer(titleBlok[i]);
    }  
    for(i=0;i<titleEstate.length;i++) {
    map.removeLayer(titleEstate[i]);
    } 
    for (let i = 0; i < layerMarkerMan.length; i++) {
        map.removeLayer(layerMarkerMan[i]);
    }
}
  
//      var greenIcon = L.icon({
//     iconUrl: "https://srs-ssms.com/man.svg",
//     // shadowUrl: 'https://srs-ssms.com/man.svg',
//     className: "man-marker",
//     iconSize:     [32,32], // size of the icon
//     shadowSize:   [32, 32], // size of the shadow
//     iconAnchor:   [16, 16], // point of the icon which will correspond to marker's location
//     shadowAnchor: [0, 0],  // the same for the shadow
//     popupAnchor:  [0, 0] // point from which the popup should open relative to the iconAnchor
// });
    // for (let i = 0; i < arrlatawal.length; i++) {
    //         for (let j = 0; j < arrlatawal[i].length; j++) {
    //             stringPlot = '[' + arrlatawal[i][j] + ', '+ arrlngawal[i][j] +']'
    //             L.marker(JSON.parse(stringPlot), {icon: greenIcon}).addTo(map);
    //         }
    //     }
   
  

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
    const pagination_element = document.getElementById('pagination')
    var list_element = document.getElementById('list')
    let current_page = 1;
    let rows = 5;

    function DisplayList(items, wrapper, rows_per_page, page){
        wrapper.innerHTML = "";
        page--;

        let start = rows_per_page * page;
        let end = start + rows_per_page;
        let paginatedItems = items.slice(start, end);

        let inc = 1;
        for (let i = 0; i < paginatedItems.length; i++) {
            let item = inc
            let item2 = paginatedItems[i]['tanggal_formatted']
            let item3 = paginatedItems[i]['lokasi_kerja']
            let item4 = paginatedItems[i]['afdeling']
            let item5 = paginatedItems[i]['blok']
            let item6 = paginatedItems[i]['akp']
            let item7 = paginatedItems[i]['taksasi']
            let item8 = paginatedItems[i]['ritase']
            let item9 = paginatedItems[i]['pemanen']
            let item10 = paginatedItems[i]['luas']
            let item11 = paginatedItems[i]['sph']
            let item12 = paginatedItems[i]['bjr']
            let item13 = paginatedItems[i]['jumlah_path']
            let item14 = paginatedItems[i]['jumlah_janjang']
            let item15 = paginatedItems[i]['jumlah_pokok']
            let item16 = paginatedItems[i]['tanggal_formatted']

            var tr = document.createElement('tr');
            let item_element = document.createElement('td')
            let item_element2 = document.createElement('td')
            let item_element3 = document.createElement('td')
            let item_element4 = document.createElement('td')
            let item_element5 = document.createElement('td')
            let item_element6 = document.createElement('td')
            let item_element7 = document.createElement('td')
            let item_element8 = document.createElement('td')
            let item_element9 = document.createElement('td')
            let item_element10 = document.createElement('td')
            let item_element11 = document.createElement('td')
            let item_element12 = document.createElement('td')
            let item_element13 = document.createElement('td')
            let item_element14 = document.createElement('td')
            let item_element15 = document.createElement('td')
            let item_element16 = document.createElement('td')

            // item_element.classList.add('item')
            item_element.innerText = item
            item_element2.innerText = item2
            item_element3.innerText = item3
            item_element4.innerText = item4
            item_element5.innerText = item5
            item_element6.innerText = item6
            item_element7.innerText = item7
            item_element7.innerText = item7
            item_element8.innerText = item8
            item_element9.innerText = item9
            item_element10.innerText = item10
            item_element11.innerText = item11
            item_element12.innerText = item12
            item_element13.innerText = item13
            item_element14.innerText = item14
            item_element15.innerText = item15
            item_element16.innerText = item16

            tr.appendChild(item_element);
            tr.appendChild(item_element2);
            tr.appendChild(item_element3);
            tr.appendChild(item_element4);
            tr.appendChild(item_element5);
            tr.appendChild(item_element6);
            tr.appendChild(item_element7);
            tr.appendChild(item_element8);
            tr.appendChild(item_element9);
            tr.appendChild(item_element10);
            tr.appendChild(item_element11);
            tr.appendChild(item_element12);
            tr.appendChild(item_element13);
            tr.appendChild(item_element14);
            tr.appendChild(item_element15);
            wrapper.appendChild(tr)
            inc++
        }
    }

    function SetupPagination(items, wrapper, rows_per_page){
        wrapper.innerHTML = "";

        let page_count = Math.ceil(items.length / rows_per_page);
        for (let i = 1; i < page_count + 1; i++) {
            let btn = PaginationButton(i, items);
            wrapper.appendChild(btn);
        }
    }

    function PaginationButton(page, items){
        let button = document.createElement('button')
        button.innerText = page;

        if(current_page == page){
            button.classList.add('active');
        }

        button.addEventListener('click', function(){
                current_page = page;
                DisplayList(items, list_element, rows, current_page)

                let current_btn = document.querySelector('.pagenumbers button.active')
                current_btn.classList.remove('active')

                button.classList.add('active')
            })
        

        return button;
    }

    $('#nameEstate').change(function(){
        var est = $('#nameEstate').find('option:selected').text()
        var id_est = $('#nameEstate').find('option:selected').val()
        
        date =  new Date().toISOString().slice(0, 10)

        var dateInput = $('#inputTanggal').val()
        if (dateInput) {
            date = dateInput
        }

        removeMarkers();
        markerDelAgain()
        getPlotEstate(est, date)
        getPlotBlok(est, date)
        getlineTaksasi(est, date)
        getMarkerMan(est, date)
        getDataTable(est, date)
    });

    var dateInput = '';
    $('#inputTanggal').change(function(){
        dateInput = $('#inputTanggal').val()
        $("#nameEstate").html('');
        removeMarkers();
        markerDelAgain()
        getListEstate(dateInput)
    });


    function getListEstate(date){
        var _token = $('input[name="_token"]').val();
        $.ajax({
        url:"{{ route('getListEstate') }}",
        method:"POST",
        data:{ _token:_token, tgl:date},
        success:function(result)
        {
            var dropdown = document.getElementById("nameEstate");
            var list_estate =  JSON.parse(result)

            if(list_estate.length != 0){
                $('#nameEstate').prop("disabled", false); 
                var arrList = new Array()
                for (var i = 0; i < list_estate.length; ++i) {
                 dropdown[dropdown.length] = new Option(list_estate[i], list_estate[i]);
                 arrList.push(list_estate[i])
                }
                getPlotEstate(list_estate[0], date)
                getPlotBlok(list_estate[0], date)
                getlineTaksasi(list_estate[0], date)
                getMarkerMan(list_estate[0], date)
                
                getDataTable(list_estate[0], date)
            }else{
                $("#nameEstate").attr("disabled", "disabled");
                removeMarkers();
                markerDelAgain();
                document.getElementById("pagination").innerHTML="";
                document.getElementById("list").innerHTML="";
              
            }
        
        }
        })
    }

    $(document).ready(function(){
        dateNow =  new Date().toISOString().slice(0, 10)

        getListEstate(dateInput)
        // $("#nameEstate").attr("disabled", "disabled");
    });

    function getDataTable(est, date) {

    var _token = $('input[name="_token"]').val();

    const params = new URLSearchParams(window.location.search)
    var paramArr = [];
    for (const param of  params) {
        paramArr = param
    }

    $.ajax({
    url:"{{ route('getDataTable') }}",
    method:"POST",
    data:{est:est,  _token:_token, tgl:date},
    success:function(result)
    {
        data = JSON.parse(result)
        DisplayList(data, list_element,rows, current_page )
        SetupPagination(data, pagination_element, rows)
    }
    })
    }

    function getPlotEstate(est, date) {

    var _token = $('input[name="_token"]').val();

    const params = new URLSearchParams(window.location.search)
    var paramArr = [];
    for (const param of  params) {
        paramArr = param
    }

    $.ajax({
    url:"{{ route('plotEstate') }}",
    method:"POST",
    data:{est:est,  _token:_token, tgl:date},
    success:function(result)
    {
        var estate = JSON.parse(result);
        drawEstatePlot(estate['est'], estate['plot'])
    }
    })
    }

    function getPlotBlok(est, date){

    var _token = $('input[name="_token"]').val();

    const params = new URLSearchParams(window.location.search)
    var paramArr = [];
    for (const param of  params) {
        paramArr = param
    }

    $.ajax({
    url:"{{ route('plotBlok') }}",
    method:"POST",
    data:{ est:est,  _token:_token, tgl:date},
    success:function(result)
    {
        var blok = JSON.parse(result);
        drawBlokPlot(blok)
    }
    })
    }

    function getlineTaksasi(est, date) {
    var _token = $('input[name="_token"]').val();

    const params = new URLSearchParams(window.location.search)
    var paramArr = [];
    for (const param of  params) {
        paramArr = param
    }

    $.ajax({
    url:"{{ route('plotLineTaksasi') }}",
    method:"POST",
    data:{est:est,  _token:_token, tgl:date},
    success:function(result)
    {
        var line = JSON.parse(result);
        drawLineTaksasi(line)
    }
    })
    }

    function getMarkerMan(est, date) {

    var _token = $('input[name="_token"]').val();

    const params = new URLSearchParams(window.location.search)
    var paramArr = [];
    for (const param of  params) {
        paramArr = param
    }

    $.ajax({
    url:"{{ route('plotMarkerMan') }}",
    method:"POST",
    data:{est:est,  _token:_token, tgl:date},
    success:function(result)
    {
        var marker = JSON.parse(result);
        drawMarkerMan(marker)

    }
    })
    }

  
</script>