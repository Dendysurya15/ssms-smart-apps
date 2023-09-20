@include('layout.header')
<style>
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
                <div class="col-2">
                    <button id="btnExport" class="btn btn-success"> Export PDF <i class="nav-icon fa fa-download"></i></button>
                </div>
                <div class="col-3">
                    <button id="btnExportqc" class="btn btn-success"> Export PDF QC <i class="nav-icon fa fa-download"></i></button>
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
                                <table id="yajra-table" style="margin: 0 auto;text-align:center" class="table table-striped">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js" integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzh5V86q6kt8UKJ8YE3oDOW0OexAXmlz8">
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
                        colorAfd = '#ff1744'
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
            getPlotStr += '"' + blok[i]['estate'] + '"'
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
                    switch (feature.properties.estate) {
                        case 'Sulung':
                            return {
                                color: "#FBAB71"
                            };
                        case 'Rangda':
                            return {
                                color: "#68BBE3"
                            };
                    }
                }
            })
            .addTo(map);
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


    var removeMarkers = function() {
        map.eachLayer(function(layer) {

            if (layer.myTag && layer.myTag === "EstateMarker") {
                map.removeLayer(layer)
            }
            if (layer.myTag && layer.myTag === "BlokMarker") {
                map.removeLayer(layer)
            }
            if (layer.myTag && layer.myTag === "LineMarker") {
                map.removeLayer(layer)
            }
        });
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

    function markerDelAgain() {
        for (i = 0; i < titleBlok.length; i++) {
            map.removeLayer(titleBlok[i]);
        }
        for (i = 0; i < titleEstate.length; i++) {
            map.removeLayer(titleEstate[i]);
        }
        for (let i = 0; i < layerMarkerMan.length; i++) {
            map.removeLayer(layerMarkerMan[i]);
        }

        map.removeControl(legendVar)
    }

    const pagination_element = document.getElementById('pagination')
    var list_element = document.getElementById('list')
    let current_page = 1;
    let rows = 5;

    function DisplayList(items, wrapper, rows_per_page, page) {
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

    function SetupPagination(items, wrapper, rows_per_page) {
        wrapper.innerHTML = "";

        let page_count = Math.ceil(items.length / rows_per_page);
        for (let i = 1; i < page_count + 1; i++) {
            let btn = PaginationButton(i, items);
            wrapper.appendChild(btn);
        }
    }

    function PaginationButton(page, items) {
        let button = document.createElement('button')
        button.innerText = page;

        if (current_page == page) {
            button.classList.add('active');
        }

        button.addEventListener('click', function() {
            current_page = page;
            DisplayList(items, list_element, rows, current_page)

            let current_btn = document.querySelector('.pagenumbers button.active')
            current_btn.classList.remove('active')

            button.classList.add('active')
        })


        return button;
    }




    $('#nameEstate').change(function() {
        var est = $('#nameEstate').find('option:selected').text()
        var id_est = $('#nameEstate').find('option:selected').val()

        date = new Date().toISOString().slice(0, 10)

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
        getUserTaksasi(est, date)

        // map.removeLayer(legendMaps);
    });

    var dateInput = '';
    $('#inputTanggal').change(function() {
        dateInput = $('#inputTanggal').val()

        $("#nameEstate").html('');
        getListEstate(dateInput)
        removeMarkers();
        markerDelAgain()
    });

    $('#btnExport').click(function() {
        var dateInput = $('#inputTanggal').val()

        var estate = document.getElementById("nameEstate").value;


        exportPDF(dateInput, estate)
    });


    function getListEstate(date) {
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('getListEstate') }}",
            method: "POST",
            data: {
                _token: _token,
                tgl: date
            },
            success: function(result) {
                var dropdown = document.getElementById("nameEstate");
                var list_estate = JSON.parse(result)

                if (list_estate.length != 0) {
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
                    getUserTaksasi(list_estate[0], date)
                    getDataTable(list_estate[0], date)
                    document.getElementById("btnExport").disabled = false;
                } else {
                    $("#nameEstate").attr("disabled", "disabled");
                    // removeMarkers();
                    // markerDelAgain();
                    document.getElementById("pagination").innerHTML = "";
                    document.getElementById("list").innerHTML = "";
                    document.getElementById("btnExport").disabled = true;
                }

            }
        })
    }

    $(document).ready(function() {
        dateNow = new Date().toISOString().slice(0, 10)


        getListEstate(dateNow)
        // $("#nameEstate").attr("disabled", "disabled");
    });

    function getDataTable(est, date) {

        var _token = $('input[name="_token"]').val();

        const params = new URLSearchParams(window.location.search)
        var paramArr = [];
        for (const param of params) {
            paramArr = param
        }

        $.ajax({
            url: "{{ route('getDataTable') }}",
            method: "POST",
            data: {
                est: est,
                _token: _token,
                tgl: date
            },
            success: function(result) {
                data = JSON.parse(result)
                DisplayList(data, list_element, rows, current_page)
                SetupPagination(data, pagination_element, rows)
            }
        })
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



    $('#btnExportqc').click(function() {
        var dateInput = $('#inputTanggal').val()

        var estate = document.getElementById("nameEstate").value;


        exportPDFqc(dateInput, estate)
    });

    function exportPDFqc(date, est) {

        var _token = $('input[name="_token"]').val();

        var url = '/getPdfqc/' + est + '/' + date;
        window.open(
            url,
            '_blank' // <- This is what makes it open in a new window.
        );
    }
</script>