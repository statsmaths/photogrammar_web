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
    font-family: 'clean_your_neighborhoodRg';
    src: url('../fonts/clean_your_neighborhood-webfont.eot');
    src: url('../fonts/clean_your_neighborhood-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/clean_your_neighborhood-webfont.woff2') format('woff2'),
         url('../fonts/clean_your_neighborhood-webfont.woff') format('woff'),
         url('../fonts/clean_your_neighborhood-webfont.ttf') format('truetype'),
         url('../fonts/clean_your_neighborhood-webfont.svg#clean_your_neighborhoodRg') format('svg');
    font-weight: normal;
    font-style: normal;

}

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
    
    #citynamebox {border: 1px solid black; position: absolute; bottom:30px; left:20px; background:white; z-index:9; width:520px; height:80px; border-radius:14px; padding:4px 4px 4px 8px;}
    #cityname {text-shadow: 0px 5px 10px #fff; position:relative; float:left; font-family: 'greensbororegular'; font-size:3.4em; }
    #ethnicexplanation { font-family:'greensbororegular'; font-size:.8em;}
    #map { width: 100%; height:100%; background: black;}
    #menu { position: absolute; top: 10px; right: 10px; width: 95px; height:60px; background: transparent; z-index:10;}
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
<div id="map"></div>
  <div id='menu'>
    <a href="#" id="negro" class="button negro">&ldquo;Negro&rdquo;</a> 
    <a href="#" id="fbw" class="button fbw">&ldquo;Foreign-Born White&rdquo;</a>
  </div>


    <div id="citynamebox"><div id="cityname">New Orleans 1940</div></div> 
    
<script>
var map = L.map('map').setView([29.9500, -90.0667], 12);

var sublayers = [];

 cartodb.createLayer(map, 'https://pleonard.cartodb.com/api/v2/viz/8f4f7074-2e31-11e5-9e69-0e018d66dc29/viz.json', {detectRetina: true}).addTo(map)
    .on('done', function(layer) {
        var subLayerOptions = {
            sql: "SELECT *, round(blackpop * 100/totalpop, 2) AS ratio FROM table_1940s_ethnicity WHERE totalpop > 0",
            cartocss: "        #table_1940s_black{                    polygon-opacity: 0.8; line-width: 0.5; line-opacity: 0;                 }                 #table_1940s_black [ ratio <= 100] {                    polygon-fill: #005824;                 }                 #table_1940s_black [ ratio <= 86] {                    polygon-fill: #238B45;                 }                 #table_1940s_black [ ratio <= 72] {                    polygon-fill: #41AE76;                 }                 #table_1940s_black [ ratio <= 57] {                    polygon-fill: #66C2A4;                 }                 #table_1940s_black [ ratio <= 43] {                    polygon-fill: #CCECE6;                 }                 #table_1940s_black [ ratio <= 28] {                    polygon-fill: #D7FAF4;                 }                 #table_1940s_black [ ratio <= 14] {                    polygon-fill: #EDF8FB;     polygon-opacity:0;            }" }
            
            var sublayer = layer.getSubLayer(0);
            sublayer.set(subLayerOptions);
            
            sublayers.push(sublayer);
            sublayers[0].hide();
    }).on('error', function() {console.log(error)});

 cartodb.createLayer(map, 'https://pleonard.cartodb.com/api/v2/viz/8f4f7074-2e31-11e5-9e69-0e018d66dc29/viz.json', {detectRetina: true}).addTo(map)
    .on('done', function(layer) {
        var subLayerOptions = {
            sql: "SELECT *, round(fbw * 100/totalpop, 2) AS ratio FROM table_1940s_ethnicity WHERE totalpop > 0",
            cartocss: "#table_1940s_ethnicity{  polygon-fill: #ECF0F6;   polygon-opacity: 0.8;      line-width: 0.5;   line-opacity: 0; } #table_1940s_ethnicity [ ratio <= 110] {    polygon-fill: #43618F; } #table_1940s_ethnicity [ ratio <= 59] {    polygon-fill: #4E71A6; } #table_1940s_ethnicity [ ratio <= 39] {    polygon-fill: #6182B5; } #table_1940s_ethnicity [ ratio <= 31] {    polygon-fill: #849EC5; } #table_1940s_ethnicity [ ratio <= 23] {    polygon-fill: #9BB0D0; } #table_1940s_ethnicity [ ratio <= 15] {    polygon-fill: #B2C2DB; } #table_1940s_ethnicity [ ratio <= 7] {    polygon-fill: #ECF0F6; polygon-opacity:0;}" }
            
            var sublayer = layer.getSubLayer(0);
            sublayer.set(subLayerOptions);
            
            sublayers.push(sublayer);
            sublayers[1].hide();
    }).on('error', function() {console.log(error)});
        
    
    $('.button').click(function() {
        LayerActions[$(this).attr('id')]();
    });
    
    $('a#negro').hover(function() {
        $('div#citynamebox').html('<div id="ethnicexplanation">&ldquo;A person of mixed white and Negro blood should be returned as Negro, no matter how small a percentage of Negro blood. Both black and mulatto persons are to be returned as Negroes, without distinction. A person of mixed Indian and Negro blood should be returned as a Negro, unless the Indian blood very definitely predominates and he is universally accepted in the community as an Indian.&rdquo;</a>');
    },
    function() {
        $('div#citynamebox').html('<div id="cityname">New Orleans</div>');  
    });
    
    $('a#fbw').hover(function() {
        $('div#citynamebox').html('<div id="ethnicexplanation">&ldquo;Mexicans are to be returned as white, unless definitely of Indian or other nonwhite race.&rdquo;</a>');
    },
    function() {
        $('div#citynamebox').html('<div id="cityname">New Orleans 1940</div>');  
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

 
    
 var pencilunderlay =   L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', { 
        attribution: '',
        maxZoom: 18,
        detectRetina: true,
        id: 'pleonard.mokg1b80',
        accessToken: 'pk.eyJ1IjoicGxlb25hcmQiLCJhIjoiV1lzUG5ZUSJ9.sO5hOKy9atdXes5tNASVCg'
    }).addTo(map);
    

//var underlays = {'Pencil' : pencilunderlay};
//map.addControl(new L.control.layers(underlays, datalayers, {collapsed: false}));
//    

    
    
    
    
</script>