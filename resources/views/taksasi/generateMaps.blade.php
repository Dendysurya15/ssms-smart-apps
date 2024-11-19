<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Taksasi Maps</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
        integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
        integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>

    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet@3.0.8/dist/esri-leaflet.js"
        integrity="sha512-E0DKVahIg0p1UHR2Kf9NX7x7TUewJb30mxkxEm2qOYTVJObgsAGpEol9F6iK6oefCbkJiA4/i6fnTHzM6H1kEA=="
        crossorigin=""></script>

    <!-- Load Esri Leaflet Vector from CDN -->
    <script src="https://unpkg.com/esri-leaflet-vector@4.0.0/dist/esri-leaflet-vector.js"
        integrity="sha512-EMt/tpooNkBOxxQy2SOE1HgzWbg9u1gI6mT23Wl0eBWTwN9nuaPtLAaX9irNocMrHf0XhRzT8B0vXQ/bzD0I0w=="
        crossorigin=""></script>
    <!-- <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css"> -->
    <!-- <link rel="stylesheet" href="Leaflet.awesome-markers-2.0-develop/dist/leaflet.awesome-markers.css"> -->
    <!-- <script src="https://unpkg.com/leaflet-simple-map-screenshoter"></script> -->
    <!-- <script src="Leaflet.awesome-markers-2.0-develop/dist/leaflet.awesome-markers.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.js">
    </script>
    <script src=" https://cdn.jsdelivr.net/npm/leaflet-polylinedecorator@1.6.0/dist/leaflet.polylineDecorator.min.js ">
    </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>
    <style>
        #map {
            height: 920px;
            width: 100%;
            border: 1px solid #ccc;
        }

        .label-estate {
            font-size: 20pt;
            color: white;
            text-align: right;
        }

        .common-estate-style {
            color: "#003B73";
            opacity: 1;
            fillOpacity: 0.2;
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

        .label-bidang {
            font-size: 11pt;
            color: white;
            text-align: center;
            opacity: 1;
        }

        .man-marker {
            /* color: white; */
            /* filter: invert(35%) sepia(63%) saturate(5614%) hue-rotate(2deg) brightness(102%) contrast(107%); */
            filter: invert(100%) sepia(5%) saturate(7383%) hue-rotate(276deg) brightness(106%) contrast(117%);
            /* filter: invert(47%) sepia(6%) saturate(10%) hue-rotate(13deg) brightness(91%) contrast(90%); */
        }

        .manMarkerOA {
            /* color: white; */
            filter: invert(11%) sepia(92%) saturate(5598%) hue-rotate(345deg) brightness(79%) contrast(106%);
        }

        .manMarkerOB {
            /* color: white; */
            filter: invert(14%) sepia(66%) saturate(5911%) hue-rotate(287deg) brightness(111%) contrast(120%);
        }

        .manMarkerOC {
            /* color: white; */
            filter: invert(28%) sepia(75%) saturate(2217%) hue-rotate(224deg) brightness(100%) contrast(108%);
        }

        .manMarkerOD {
            /* color: white; */
            filter: invert(53%) sepia(87%) saturate(2214%) hue-rotate(165deg) brightness(99%) contrast(103%);
        }
    </style>
</head>

<body>
    <div id="map"></div>


</body>

</html>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
    integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
<script>
    const arrData = {!! $arrData !!};
        const estate_plot = {!! $estate_plot !!};
        const userTaksasi = {!! $userTaksasi !!};
        const blokPerEstate = {!! $blokLatLn !!};
        const datetime = {!! $datetime !!};



        // console.log(arrData)

        document.addEventListener('DOMContentLoaded', function() {
            createMapImage(arrData, estate_plot, userTaksasi, blokPerEstate, datetime)
        });


        function createMapImage() {
            const map = L.map('map', {
        center: [-2.4833826, 112.9721219], // Default coordinates for Central Kalimantan
        zoom: 13,
        attributionControl: false,
        zoomControl: true
    });

    const tileLayer =   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    const arr = Object.entries(arrData);



    const estateData = arr[0][0];

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
geoJsonEst += '"' + estate_plot[estateData]['est'] + '"},'
geoJsonEst += '"geometry"'
geoJsonEst += ":"
geoJsonEst += '{"coordinates"'
geoJsonEst += ":"
geoJsonEst += '[['
geoJsonEst += estate_plot[estateData]['plot']
geoJsonEst += ']],"type"'
geoJsonEst += ":"
geoJsonEst += '"Polygon"'
geoJsonEst += '}},'

geoJsonEst = geoJsonEst.substring(0, geoJsonEst.length - 1);
geoJsonEst += ']}'

// Parse the string into a JSON object
var estate = JSON.parse(geoJsonEst)

// Use the parsed GeoJSON object
L.geoJSON(estate, {
    onEachFeature: function(feature, layer) {
        layer.myTag = 'EstateMarker'
        var label = L.marker(layer.getBounds().getCenter(), {
            icon: L.divIcon({
                className: 'label-estate common-estate-style',
                html: feature.properties.estate,
            })
        }).addTo(map);
        layer.options.className = 'estate-All';
        layer.addTo(map);
    },
    style: function(feature) {
        return {
            color: "#003B73",
            opacity: 1,
            fillOpacity: 0.4
        };
    }
}).addTo(map);

var getPlotStr = '{"type"'
getPlotStr += ":"
getPlotStr += '"FeatureCollection",'
getPlotStr += '"features"'
getPlotStr += ":"
getPlotStr += '['
for (let i = 0; i < blokPerEstate[estateData].length; i++) {
    getPlotStr += '{"type"'
    getPlotStr += ":"
    getPlotStr += '"Feature",'
    getPlotStr += '"properties"'
    getPlotStr += ":"
    getPlotStr += '{"blok"'
    getPlotStr += ":"
    getPlotStr += '"' + blokPerEstate[estateData][i]['blok'] + '",'
    getPlotStr += '"estate"'
    getPlotStr += ":"
    getPlotStr += '"' + blokPerEstate[estateData][i]['estate'] + '",'
    getPlotStr += '"afdeling"'
    getPlotStr += ":"
    getPlotStr += '"' + blokPerEstate[estateData][i]['afdeling'] + '"'
    getPlotStr += '},'
    getPlotStr += '"geometry"'
    getPlotStr += ":"
    getPlotStr += '{"coordinates"'
    getPlotStr += ":"
    getPlotStr += '[['
    getPlotStr += blokPerEstate[estateData][i]['latln']
    getPlotStr += ']],"type"'
    getPlotStr += ":"
    getPlotStr += '"Polygon"'
    getPlotStr += '}},'
}
getPlotStr = getPlotStr.substring(0, getPlotStr.length - 1);
getPlotStr += ']}'

var blok = JSON.parse(getPlotStr)

var blok = JSON.parse(getPlotStr);

// Create the block layer with styling and labels
var centerBlok = L.geoJSON(blok, {
    onEachFeature: function(feature, layer) {
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
                    fillColor: "#77543f",
                    color: 'white',
                    fillOpacity: 0.4,
                    opacity: 0.4,
                };
            case 'OG':
                return {
                    fillColor: "#dfd29e",
                    color: 'white',
                    fillOpacity: 0.4,
                    opacity: 0.4,
                };
            case 'OH':
                return {
                    fillColor: "#db423c",
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
}).addTo(map);


var geoJsonLine = '{"type":"FeatureCollection","features":[';

for (let i = 0; i < arrData[estateData].length; i++) {
    geoJsonLine += '{"type":"Feature","properties":{"nama":"' + arrData[estateData][i]['lokasi_kerja'] + '","afdeling":"' + arrData[estateData][i]['afdeling'] + '"},';
    geoJsonLine += '"geometry":{"type":"Polygon","coordinates":[[';
    geoJsonLine += arrData[estateData][i]['plot'];
    geoJsonLine += ']]}}';
    if (i < arrData[estateData].length - 1) geoJsonLine += ',';
}
geoJsonLine += ']}';

var lineTaksasi = JSON.parse(geoJsonLine);

var customLayer = L.geoJSON(lineTaksasi, {
    onEachFeature: function(feature, layer) {
        if (feature.geometry.type === 'Polygon') {
            var coords = feature.geometry.coordinates[0];
            var polyline = L.polyline(coords.map(coord => [coord[1], coord[0]]), {
                color: 'transparent'
            }).addTo(map);

            var decorator = L.polylineDecorator(polyline, {
                patterns: [{
                    offset: '10%',
                    repeat: 50,
                    symbol: L.Symbol.arrowHead({
                        pixelSize: 10,
                        polygon: true,
                        pathOptions: {
                            stroke: true,
                            color: '#90EE90',
                            weight: 2,
                            fillOpacity: 1,
                            fill: true
                        }
                    })
                }]
            }).addTo(map);
        }
    },
    style: function(feature) {
        // Combined style function
        const afdelingColors = {
            'OA': "#d81b60",
            'OB': "#8e24aa",
            'OC': "#ffb300",
            'OD': "#1e88e5",
            'OE': "#67D98A",
            'OF': "#c2a856",
            'OG': "#2a6666",
            'OH': "#db423c",
            'OI': "#ba9355",
            'OJ': "#ccff00",
            'OK': "#8f9e8a",
            'OL': "#14011c",
            'OM': "#01b9c5"
        };

        return {
            color: afdelingColors[feature.properties.afdeling] || "#003B73",
            opacity: 1,
            fillOpacity: 0.4
        };
    }
}).addTo(map);



    // Add markers for each point
    arrData[estateData].forEach(data => {
        const colorMarker = getMarkerColor(data.afdeling);
        const finish = new L.Icon({
            iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${colorMarker}.png`,
            shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
            iconSize: [14, 21],
            iconAnchor: [7, 22],
            popupAnchor: [1, -34],
            shadowSize: [28, 20],
        });

        const latlonFinish = JSON.parse(data.plotAwal);
        L.marker(latlonFinish, {
            icon: finish
        }).addTo(map);
    });

    const legend = L.control({ position: "bottomright" });
const newUserTaksasi = Object.entries(userTaksasi);

legend.onAdd = function(map) {
    var div = L.DomUtil.create("div", "legend");
    div.innerHTML += "<h4>Keterangan :</h4>";
    div.innerHTML += '<div>';

    var colorAfd = '';
    newUserTaksasi.forEach(element => {
        switch (element[0]) {
            case 'OA':
                colorAfd = '#d81b60'
                break;
            case 'OB':
                colorAfd = '#8e24aa'
                break;
            case 'OC':
                colorAfd = '#ffb300'
                break;
            case 'OD':
                colorAfd = '#1e88e5'
                break;
            case 'OE':
                colorAfd = '#67D98A'
                break;
            case 'OF':
                colorAfd = '#c2a856'
                break;
            case 'OG':
                colorAfd = '#2a6666'
                break;
            case 'OH':
                colorAfd = '#db423c'
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

    div.innerHTML += '</div>';
    return div;
};

legend.addTo(map);

// Wait for all tiles to load
map.whenReady(function() {
    setTimeout(() => {
        domtoimage.toJpeg(document.getElementById('map'), {
            quality: 0.95
        })
        .then(function(dataUrl) {
            console.log('Map Base64:', dataUrl);
            return dataUrl; // You can use this for further processing
        });
    }, 1000); // Give extra time for all elements to render
});

    if (centerBlok.getLayers().length > 0) {
        map.fitBounds(customLayer.getBounds());
    }

    
}

function getMarkerColor(afdeling) {
    const colors = {
        'OA': 'red',
        'OB': 'violet',
        'OC': 'gold',
        'OD': 'blue',
        'OE': 'green',
        'OF': 'grey',
        'OG': 'red',
        'OH': 'gold',
        'OI': 'violet',
        'OJ': 'grey',
        'OK': 'red',
        'OL': 'blue',
        'OM': 'grey',
    };
    return colors[afdeling] || 'grey';
}

function getAfdelingColor(afd) {
    const colors = {
        'OA': '#ff1744',
        'OB': '#d500f9',
        'OC': '#ffa000',
        'OD': '#00b0ff',
        // Add other color mappings
    };
    return colors[afd] || '#003B73';
}
        // Add your createMapImage function and other JavaScript code here
</script>