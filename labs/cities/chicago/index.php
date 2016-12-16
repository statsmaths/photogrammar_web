<head>
<!-- Using Leaflet 1.0beta -->
<!--<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-1.0.0-b1/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-1.0.0-b1/leaflet.js"></script>-->
<!-- Using Leaflet 0.73 -->
<!--<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>-->
<!-- Using CartoDB.js -->
<link rel="stylesheet" href="http://libs.cartocdn.com/cartodb.js/v3/3.15/themes/css/cartodb.css" />
<script src="http://libs.cartocdn.com/cartodb.js/v3/3.15/cartodb.js"></script>

<style>
    html, body {width:100%; height:100%; padding: 0; margin: 0;}


    @font-face {
        font-family: 'greensbororegular';
        src: url('../fonts/greensboro-webfont.eot');
        src: url('../fonts/greensboro-webfont.eot?#iefix') format('embedded-opentype'),
             url('../fonts/greensboro-webfont.woff2') format('woff2'),
             url('../fonts/greensboro-webfont.woff') format('woff'),
             url('../fonts/greensboro-webfont.ttf') format('truetype'),
             url('../fonts/greensboro-webfont.svg#greensbororegular') format('svg');
        font-weight: normal;
        font-style: normal;
    }

    #searchbox {border: 1px solid black; position: absolute; bottom:30px; left:20px; background:white; z-index:9; width:300; height:80px; border-radius:14px; padding:4px 4px 4px 8px;}

    
    #citynamebox {border: 1px solid black; position: absolute; bottom:30px; left:20px; background:white; z-index:9; width:520px; height:80px; border-radius:14px; padding:4px 4px 4px 8px;}
    #cityname {text-shadow: 0px 5px 10px #fff; position:relative; float:left; font-family: 'greensbororegular'; font-size:4em; }
    #ethnicexplanation { font-family:'greensbororegular'; font-size:.8em;}
    #map { width: 100%; height:100%; background: black;}
    #menu { position: absolute; top: 150px; right: 10px; width: 95px; height:60px; background: transparent; z-index:10;}
    #menu a { 
      margin: 5px 0 0 0;
      float: right;
      vertical-align: baseline;
      width: 70px;
      padding: 10px;
      text-align: center;
      font: bold 14px "Helvetica",Arial;
      line-height: normal;
      color: #555;
      border-radius: 4px;
      border: 1px solid #777777;
      background: #ffffff;
      text-decoration: none;
      cursor: pointer;
    }
    #menu a#negro.selected { 
      color: #005824;
    }
    #menu a#fbw.selected { 
      color: #43618f;
    }    
</style>
<script>


function initialize() {
    
    
    
    var map = L.map('map').setView([41.8369, -87.6847], 12);
    
 var currentstreetsunderlay = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}@2x.png', {
    
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="http://cartodb.com/attributions">CartoDB</a>'
}).addTo(map);

 
 var currentsatelliteunderlay =   L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', { 
        attribution: '',
        maxZoom: 18,
        detectRetina: true,
        id: 'pleonard.mpo3m2d4',
        accessToken: 'pk.eyJ1IjoicGxlb25hcmQiLCJhIjoiV1lzUG5ZUSJ9.sO5hOKy9atdXes5tNASVCg'
    });

    


    
// Old street grid
var oldstreetgrid = cartodb.createLayer(map, 'https://pleonard.cartodb.com/api/v2/viz/b4e634a4-309c-11e5-bd42-0e4fddd5de28/viz.json').on('done', function(layer) {
    oldstreetgrid = layer;
    map.addLayer(oldstreetgrid);
    var underlays = {'Current Streets' : currentstreetsunderlay, 'Current Satellite' : currentsatelliteunderlay};
    var datalayers = {'1930s Streets':oldstreetgrid};
    map.addControl(new L.control.layers(underlays, datalayers, {collapsed: false}));
 layer.setZIndex(98);
  }).on('error', function() {
    //log the error
	  });

    
// Photograph points
//cartodb.createLayer(map, 'https://pleonard.cartodb.com/api/v2/viz/2ebd4438-315c-11e5-beb5-0e9d821ea90d/viz.json')
//    .addTo(map)
//    .on('error', function(err) {
//      alert("some error occurred: " + err);
//    });

//    
//    
var sublayers = [];



 cartodb.createLayer(map, 'https://pleonard.cartodb.com/api/v2/viz/8f4f7074-2e31-11e5-9e69-0e018d66dc29/viz.json', {detectRetina: true}).addTo(map)
    .on('done', function(layer) {
        var subLayerOptions = {
            sql: "SELECT *, round(blackpop * 100/totalpop, 2) AS ratio FROM table_1940s_ethnicity WHERE totalpop > 0",
            cartocss: " #table_1940s_black{   polygon-fill: #ECF0F6;   polygon-opacity: 0.8;   line-color: #FFF;   line-width: 0.5;   line-opacity: 0; } #table_1940s_black [ ratio <= 100] {   polygon-fill: #005824;}#table_1940s_black [ ratio <= 85.71428571428572] {   polygon-fill: #238B45;}#table_1940s_black [ ratio <= 71.42857142857143] {   polygon-fill: #41AE76;}#table_1940s_black [ ratio <= 57.142857142857146] {   polygon-fill: #66C2A4;}#table_1940s_black [ ratio <= 42.85714285714286] {   polygon-fill: #CCECE6;}#table_1940s_black [ ratio <= 28.571428571428573] {   polygon-fill: #D7FAF4;}#table_1940s_black [ ratio <= 14.285714285714286] {   polygon-fill: #EDF8FB; polygon-opacity:0;}" }
            
            var sublayer = layer.getSubLayer(0);
            sublayer.set(subLayerOptions);
            console.log('created ' + layer.getSubLayer(0));
            sublayers.push(sublayer);
            sublayers[0].hide();
            layer.setZIndex(99);
    }).on('error', function() {console.log(error)});

 cartodb.createLayer(map, 'https://pleonard.cartodb.com/api/v2/viz/8f4f7074-2e31-11e5-9e69-0e018d66dc29/viz.json', {detectRetina: true}).addTo(map)
    .on('done', function(layer) {
        var subLayerOptions = {
            legends: true,
            sql: "SELECT *, round(fbw * 100/totalpop, 2) AS ratio FROM table_1940s_ethnicity WHERE totalpop > 0",
            cartocss:  "#table_1940s_black{   polygon-fill: #ECF0F6;   polygon-opacity: 0.8;   line-color: #FFF;   line-width: 0.5;   line-opacity: 0; } #table_1940s_black [ ratio <= 100] {    polygon-fill: #43618F; } #table_1940s_black [ ratio <= 85.71428571428572] {    polygon-fill: #4E71A6; } #table_1940s_black [ ratio <= 71.42857142857143] {    polygon-fill: #6182B5; } #table_1940s_black [ ratio <= 57.142857142857146] {    polygon-fill: #849EC5; } #table_1940s_black [ ratio <= 42.85714285714286] {    polygon-fill: #9BB0D0; } #table_1940s_black [ ratio <= 28.571428571428573] {    polygon-fill: #B2C2DB; } #table_1940s_black [ ratio <= 14.285714285714286] {    polygon-fill: #ECF0F6; polygon-opacity:0;}" }
            
            var sublayer = layer.getSubLayer(0);
            sublayer.set(subLayerOptions);
            
            sublayers.push(sublayer);
            sublayers[1].hide();
             layer.setZIndex(99);
    }).on('error', function() {console.log(error)});
        
    
    $('.button').click(function() {
        LayerActions[$(this).attr('id')]();
    });
    
    $('a#negro').hover(function() {
        $('div#citynamebox').html('<div id="ethnicexplanation">&ldquo;A person of mixed white and Negro blood should be returned as Negro, no matter how small a percentage of Negro blood. Both black and mulatto persons are to be returned as Negroes, without distinction. A person of mixed Indian and Negro blood should be returned as a Negro, unless the Indian blood very definitely predominates and he is universally accepted in the community as an Indian.&rdquo;</a>');
    },
    function() {
        $('div#citynamebox').html('<div id="cityname">Chicago</div>');  
    });
    
    $('a#fbw').hover(function() {
        $('div#citynamebox').html('<div id="ethnicexplanation">&ldquo;Mexicans are to be returned as white, unless definitely of Indian or other nonwhite race.&rdquo;</a>');
    },
    function() {
        $('div#citynamebox').html('<div id="cityname">Chicago</div>');  
    });    
    
    var LayerActions = {
        fbw: function(){
            sublayers[1].toggle();
            $('a#fbw').toggleClass('selected');
            return true;
        },
        negro: function(){
            sublayers[0].toggle();      
            $('a#negro').toggleClass('selected');
            return true;
        }
  }
    }


</script>
</head>
<body onload="initialize()">
<div id="map"></div>
<div id='menu'>
    <a href="#" id="negro" class="button negro">&ldquo;Negro&rdquo;</a> 
    <a href="#" id="fbw" class="button fbw">&ldquo;Foreign-Born White&rdquo;</a>
  </div>


    <div id="citynamebox"><div id="cityname">Chicago</div></div>


</body>  
