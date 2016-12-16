<?php $page = map; ?>
<?php include '../header.php'; ?>

<link rel="stylesheet" href="/css/bootstrap-slider.css" />
<link rel="stylesheet" href="/css/cartodb.css" />
<!--[if lte IE 8]>
  <link rel="stylesheet" href="http://libs.cartocdn.com/cartodb.js/v3/themes/css/cartodb.ie.css" />
<![endif]-->
<script src="/js/cartodb.js"></script>
<script src="/js/bootstrap-slider.js"></script>
<script src="/search/select2/select2.js"></script>

<style>
html, body, #map {
	height: 100%;
	width: 100%;
	overflow: hidden;
}
body {
	padding-top: 100px;
}


.slider-selection {
	background: #54ad7c;}
.slider-handle {
	background: #263d2e;
}
.slider{margin-top:-4px;}
span#theenddate {margin-left:15px;}
span#thestartdate {margin-right:10px;}

li.mapcontrols {font-weight: bold;margin-right:20px;}

/* FIX for cosmetic bug in interaction between bootstrap and cartodb.js/Leaflet in popup box (broken right border) */

div.cartodb-popup div.cartodb-popup-content-wrapper { padding-right:210px;}

/*   ul.dropdown-menu  { border:1px solid red; z-index: 9999} */


</style>
	<link href="/search/select2/select2.css" rel="stylesheet"/>
<div class="navbar navbar-fixed-top navbar-inverse" style="top: 50px; background-color:#777777;color:#fff;z-index:1">
	<!-- Peter, put the search bar here! -->
	<div class="container">
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-left" style="line-height:3.4em;z-index:1030;">

				<li class="mapcontrols"><span id="thestartdate">1935</span> <div id="yearslider"></div><span id="theenddate">1945</span></li>
				<li class="mapcontrols"><select id="pname" name="pname">
					<option></option>
						<option>Alfred T. Palmer</option>
						<option>Arthur Rothstein</option>
						<option>Arthur S. Siegel</option>
						<option>Ben Shahn</option>
						<option>Carl Mydans</option>
						<option>Dorothea Lange</option>
						<option>Esther Bubley</option>
						<option>Gordon Parks</option>
						<option>Howard R. Hollem</option>
						<option>Jack Delano</option>
						<option>John Collier</option>
						<option>John Vachon</option>
						<option>Marion Post Wolcott</option>
						<option>Marjory Collins</option>
						<option>Russell Lee</option>
				</select></li>
			</ul>
		</div>
	</div>
</div>



<div id="map"></div>
     <script type="infowindow/html" id="infowindow_template">

      <div class="cartodb-popup">
        <a href="#close" class="cartodb-popup-close-button close">x</a>
         <div class="cartodb-popup-content-wrapper">
           <div class="cartodb-popup-content">
                 {{content.data.nhgisnam}}, {{content.data.state}}<br/>
             <a href="/search/results.php?start=0&search=&pname=&lot=&van=&state={{content.data.state}}&county={{content.data.nhgisnam}}&city=&year_start={{content.data.minyear}}&month_start=0&year_stop={{content.data.maxyear}}&month_stop=12" target="_blank">See {{content.data.npics}} Pictures</a>


           </div>
         </div>
         <div class="cartodb-popup-tip-container"></div>
      </div>
    </script>

 <script>
       function main() {

var map = L.map('map').setView([39.8, -98.2], 5);
mapboxUrl = 'http://{s}.tiles.mapbox.com/v3/mapbox.world-light/{z}/{x}/{y}.png';
mapbox = new L.TileLayer(mapboxUrl, {maxZoom: 18, attribution: null, detectRetina:true});
map.addLayer(mapbox,true);

var seaver1937orig = L.tileLayer.wms("http://kartor.32by32.com:8080/geoserver/Photogrammar/wms",{
	layers: 'Photogrammar:seaver1937geo',
	format: 'image/png',
	transparent: true,
	attribution: '1937 Vico Motor Oil Map',
	detectRetina: true,
	opacity: 0.7
});

var seaver1937 = L.tileLayer.wms("http://geodata.library.yale.edu:8080/geoserver/Photogrammar/wms",{
	layers: 'Photogrammar:seaver1937',
	format: 'image/png',
	transparent: true,
	attribution: '1937 Vico Motor Oil Map',
	detectRetina: true,
	opacity: 0.7
});





/*         cartodb.createLayer(map, 'http://photogrammar.cartodb.com/api/v2/viz/3e1dddb0-e0f5-11e3-b991-0e230854a1cb/viz.json', {detectRetina: false}) */
        cartodb.createLayer(map, 'https://yale.cartodb.com/u/photogrammar2/api/v2/viz/534b78ae-4361-11e4-843a-0e10bcd91c2b/viz.json', {detectRetina: false})
         .addTo(map)
         .on('done', function(layer) {
           // get sublayer 0 and set the infowindow template
           var sublayer = layer.getSubLayer(0);

           sublayer.infowindow.set('template', $('#infowindow_template').html());
          }).on('error', function() {
            console.log("some error occurred");
          })


.on('done', function(layer) {
	countysublayer = layer.getSubLayer(0);

	countylayer = layer;
	  countylayer.setZIndex(99);
	map.addLayer(countylayer);

	countysublayer.infowindow.set('template', $('#infowindow_template').html());
}).on('error', function() {
	console.log("some error occurred");
});

var vizLayers = {};
var historicMaps = {'1937 Vico Motor Oil Map': seaver1937};
map.addControl(new L.control.layers(vizLayers, historicMaps, {collapsed: false}));


};

	$("select#pname").select2({
		placeholder: "All Photographers",
		allowClear: true,
		width:250
		});

     var setDates = function() {

     	if (($('#thestartdate').text() != yearSlider.value[0] || $('#theenddate').text() != yearSlider.value[1])) {
	     	var startDate = yearSlider.value[0];
	     	var endDate = yearSlider.value[1];

	     	$('#thestartdate').html(startDate);
	     	$('#theenddate').html(endDate);

	     	var newQuery="SELECT us_2.icpsrfip,us_2.cartodb_id,us_2.nhgisnam,ST_SIMPLIFY(us_2.the_geom_webmercator,0.0001) as the_geom_webmercator,ST_ASGEOJSON(ST_SIMPLIFY(us_2.the_geom,0.0001)) as geometry,COUNT(*) as npics, (COUNT(*) / (us_2.shape_area/2990893727.30754)) as density,MAX(fsadata_2014.year) AS maxyear, MIN(fsadata_2014.year) AS minyear, fsadata_2014.state FROM us_2,fsadata_2014 WHERE us_2.icpsrfip = fsadata_2014.icpsrfip AND fsadata_2014.year >= " + startDate + " AND fsadata_2014.year <= " +  endDate;

	     	if ($("select#pname").val()!="") {
		     	newQuery += " AND pname='" +$("select#pname").val() + "' ";

	     	};
	     	newQuery +=" GROUP BY us_2.cartodb_id, fsadata_2014.state";
	   		countysublayer.setSQL(newQuery);

   		};
     	};

    var yearSlider = $('#yearslider').slider({
 		   tooltip: 'hide',
 		   	handle:'round',
            min: 1935,
            max: 1945,
            value: [1935,1945]
            })
            .on('slide', setDates).data('slider');


		$("select#pname").on("change", function(e) { adjustsql(e.val); });
    function adjustsql(who) {
    var startDate = yearSlider.value[0];
    var endDate = yearSlider.value[1];
    	if(! who){

	    	countysublayer.setSQL("SELECT us_2.icpsrfip,us_2.cartodb_id,us_2.nhgisnam,ST_SIMPLIFY(us_2.the_geom_webmercator,0.0001) as the_geom_webmercator,ST_ASGEOJSON(ST_SIMPLIFY(us_2.the_geom,0.0001)) as geometry,COUNT(*) as npics, (COUNT(*) / (us_2.shape_area/2990893727.30754)) as density,MAX(fsadata_2014.year) AS maxyear, MIN(fsadata_2014.year) AS minyear, fsadata_2014.state FROM us_2,fsadata_2014 WHERE us_2.icpsrfip = fsadata_2014.icpsrfip AND fsadata_2014.year  >= " + startDate + " AND fsadata_2014.year <= " +  endDate + " GROUP BY us_2.cartodb_id, fsadata_2014.state");



    		};
		if(who){

		  countysublayer.setSQL("SELECT us_2.icpsrfip,us_2.cartodb_id,us_2.nhgisnam,ST_SIMPLIFY(us_2.the_geom_webmercator,0.0001) as the_geom_webmercator,ST_ASGEOJSON(ST_SIMPLIFY(us_2.the_geom,0.0001)) as geometry,COUNT(*) as npics, (COUNT(*) / (us_2.shape_area/2990893727.30754)) as density, MAX(fsadata_2014.year) AS maxyear, MIN(fsadata_2014.year) AS minyear, fsadata_2014.state FROM us_2,fsadata_2014 WHERE us_2.icpsrfip = fsadata_2014.icpsrfip  AND YEAR >= " + startDate + " AND YEAR <= " +  endDate + " AND pname='" + who + "'  GROUP BY us_2.cartodb_id, fsadata_2014.state");




			};
		};





   window.onload = main;


 </script>


<?php include '../footer.php'; ?>
