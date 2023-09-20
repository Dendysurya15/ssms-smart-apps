@include('layout.header')

<div class="content-wrapper">
    <style>
        /* CSS for the legend icons */
        .pucat-icon {
            display: inline-block;
            width: 14px;
            height: 21px;
            background: url(https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png) no-repeat;
            background-size: contain;
            vertical-align: middle;
        }

        .ringan-icon {
            display: inline-block;
            width: 14px;
            height: 21px;
            background: url(https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png) no-repeat;
            background-size: contain;
            vertical-align: middle;
        }

        .berat-icon {
            display: inline-block;
            width: 14px;
            height: 21px;
            background: url(https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png) no-repeat;
            background-size: contain;
            vertical-align: middle;
        }

        /* CSS for the legend container */
        .legend-container {
            background-color: #fff;
            /* White background */
            opacity: 0.8;
            /* Set opacity to make it semi-transparent */
            padding: 10px;
            /* Add some padding for better readability */
            border-radius: 5px;
            /* Add border radius for rounded corners */
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .loading-text {
            animation: fadeInOut 2s ease-in-out infinite;
        }
    </style>

    <div class="d-flex justify-content-end mt-3 mb-2 ml-3 mr-3" style="padding-top: 20px;">
        <div class="row w-100">
            <div class="col-md-2 offset-md-8">
                {{csrf_field()}}
                <select class="form-control" id="Estate">
                    <option value="" disabled>Pilih EST</option>
                    @foreach($estate as $item)

                    <option value={{$item}} selected>{{$item}}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <button class="btn btn-primary mb-3 ml-3" id="showEstMap">Show</button>
    </div>
    <button id="saveButton">Save</button>
    <div class="card p-4">
        <h4 class="text-center mt-2" style="font-weight: bold">Tracking Plot Pokok - </h4>
        <hr>
        <div id="map" style="height: 650px;"></div>
    </div>


</div>
@include('layout.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
<script type="text/javascript" src="{{ asset('js/Leaflet.Editable.js') }}"></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var map;
    var coordinates = []; // Declare coordinates globally to store the polygon's coordinates.


    $('#showEstMap').click(function() {
        getPlotBlok();

        // Swal.fire({
        //     title: 'Loading',
        //     html: '<span class="loading-text">Mohon Tunggu...</span>',
        //     allowOutsideClick: false,
        //     showConfirmButton: false,
        //     onBeforeOpen: () => {
        //         Swal.showLoading();
        //     }
        // });
    });

    function getPlotBlok() {
        var _token = $('input[name="_token"]').val();
        var estData = $("#Estate").val();
        // var tahunData = $("#tahun_tanam").val();
        // var afd = 'OC';
        $.ajax({
            url: "{{ route('mapsestatePlot') }}",
            method: "get",
            data: {
                estData: estData,
                _token: _token
            },
            success: function(result) {
                var plot = JSON.parse(result);
                // Swal.close();
                const blokResult = Object.entries(plot['blok']);
                const BlokPlus = Object.entries(plot['blok_Pulau']);
                const BlokPlus2 = Object.entries(plot['blok_Pulau2']);
                // const polygonCoords = Object.entries(plot['coords']);
                // const pokok_data = Object.entries(plot['pokok_data']);


                // Remove existing layers before updating the map
                if (map) {
                    map.eachLayer(function(layer) {
                        map.removeLayer(layer);
                    });
                }


                drawBlokPlot(blokResult)
                // draw_pokok(blokResult)

            }
        });
    }

    $(document).ready(function() {
        map = L.map('map', { // Use the globally declared 'map' variable here.
            editable: true
        });

        var googleStreet = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png");
        var googleSatellite = L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        googleStreet.addTo(map); // Add "Google Street" as the default base map

        var baseMaps = {
            "Google Street": googleStreet,
            "Google Satellite": googleSatellite
        };

        L.control.layers(baseMaps).addTo(map);

        map.addControl(new L.Control.Fullscreen());


    });

    function drawBlokPlot(blok) {

        var estData = $("#Estate").val();
        // Add the tile layer and create the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Create an array to store the coordinates for the polygon
        var coordinates = [];

        // Extract coordinates from your 'blok' array
        blok.forEach(function(entry) {
            var lat = parseFloat(entry[1].lat); // Access lat from index 1
            var lon = parseFloat(entry[1].lon); // Access lon from index 1

            // Check if lat and lon are valid numbers
            if (!isNaN(lat) && !isNaN(lon)) {
                coordinates.push([lat, lon]);
            }
        });

        var polygon = L.polygon(coordinates).addTo(map);

        // Fit the map bounds to the polygon
        map.fitBounds(polygon.getBounds());

        // Make the polygon editable
        polygon.enableEdit();

        // Listen for changes in the polygon and update the coordinates
        polygon.on('editable:vertex:dragend', function(e) {
            coordinates = polygon.getLatLngs()[0]; // Update coordinates with edited coordinates
            console.log(coordinates);
        });
        $('#saveButton').click(function() {
            var textData = coordinates.map(function(latLng) {
                // console.log(coordinates);
                return estData + ',' + latLng.lat + ',' + latLng.lng;
            }).join('\n');

            // Create a Blob with the text data and save it as a TXT file
            var blob = new Blob([textData], {
                type: 'text/plain;charset=utf-8'
            });
            saveAs(blob, 'coordinates.txt');
        });



        if (polygon.getBounds().isValid()) {
            map.fitBounds(polygon.getBounds());
        } else {
            console.error('Invalid bounds:', polygon.getBounds());
        }
    }



    function draw_pokok(blok) {


        // Add a base layer (you can choose from various map providers, e.g., OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Iterate through the nested structure and add markers to the map
        blok.forEach(function(entry) {
            var lat = parseFloat(entry[1].lat);
            var lon = parseFloat(entry[1].lon);
            var number = entry[1].number;
            var id = entry[1].id;
            var plot = entry[1].Plot;

            if (!isNaN(lat) && !isNaN(lon)) {
                var marker = L.marker([lat, lon]).addTo(map);
                marker.bindPopup("Plot: " + plot +
                    "<br>Number: " + number +
                    "<br>ID: " + id +
                    "<br>lat: " + lat +
                    "<br>lon: " + lon
                );
            }
        });

        // Fit the map bounds to all markers
        var bounds = L.latLngBounds(blok.map(function(entry) {
            var lat = parseFloat(entry[1].lat);
            var lon = parseFloat(entry[1].lon);
            return L.latLng(lat, lon);
        }));
        map.fitBounds(bounds);
    }
</script>