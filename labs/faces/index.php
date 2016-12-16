<?php $page = labs; ?>
<?php include '../../header.php'; ?>


<link rel="stylesheet" href="/css/bootstrap-slider.css" />
<link rel="stylesheet" href="http://libs.cartocdn.com/cartodb.js/v3/themes/css/cartodb.css" />
<!--[if lte IE 8]>
  <link rel="stylesheet" href="http://libs.cartocdn.com/cartodb.js/v3/themes/css/cartodb.ie.css" />
<![endif]-->
<script src="http://libs.cartocdn.com/cartodb.js/v3/cartodb.js"></script>
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



li.mapcontrols {font-weight: bold;margin-right:20px;}
 

  
</style>
<link href="/search/select2/select2.css" rel="stylesheet"/>
<div class="navbar navbar-fixed-top navbar-inverse" style="top: 50px; background-color:#777777;color:#fff;z-index:1">
	<div class="container">
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-left" style="line-height:3.4em;z-index:1030;">

				<li class="mapcontrols">
				<select id="pname" name="pname">
					<option></option>


				</select>
				<select id="ethnic" name="ethnic">
					<option></option>
					<option value="chinese">Chinese</option>
					<option value="portuguese">Portuguese</option>
					<option value="swedish">Swedish</option>


				</select></li>
			</ul>
		</div>
	</div>
</div>
	<meta property="og:image" content="route.png" />
	<link rel="stylesheet" href="lib/leaflet/leaflet.css" />
	<link rel="stylesheet" href="lib/cluster/MarkerCluster.css" />		
	<link rel="stylesheet" href="Leaflet.Instagram.css" />
</head>
<body>
	<div id="map"></div>
	<script src="lib/reqwest.min.js"></script>
	<script src="lib/leaflet/leaflet.js"></script>
	<script src="leaflet-providers.js"></script>
	<script src="lib/cluster/leaflet.markercluster.js"></script>			
	<script src="Leaflet.Instagram.Cluster.js"></script>	
	<script>

	var map = L.map('map', {
		maxZoom: 10
	}).fitBounds([[24.396308,-124.848974 ], [49.384358,-66.885444 ]]);


	L.tileLayer('http://{s}.tile.stamen.com/toner-lite/{z}/{x}/{y}.png', {
		attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
		subdomains: 'abcd',
		minZoom: 0,
		maxZoom: 20,
		detectRetina: true
	}).addTo(map);

	var vizlayer = L.instagram.cluster('http://photogrammar2.cartodb.com/api/v2/sql?q=SELECT *  FROM faces'
	).addTo(map);
			
						
						$.getJSON('http://photogrammar2.cartodb.com/api/v2/sql?q=SELECT pname, COUNT(pname) AS count FROM faces GROUP BY pname ORDER BY pname', function(data) {	
							
							
							for (var i = 0; i < data.total_rows; i++) { $('select#pname').append('<option value="' + data.rows[i].pname + '">' + data.rows[i].pname + ' (' + data.rows[i].count + ' faces)</option>');}
							
						$("select#pname").select2({
							placeholder: "All Photographers",
							allowClear: true,
							width:250
							});
							});
				
		$("select#ethnic").select2({
							placeholder: "All Ethnicities",
							allowClear: true,
							width:250
							});


    function adjustsql(who) {
	    map.removeLayer(vizlayer);
	    	if(! who){
		    	vizlayer = L.instagram.cluster("http://photogrammar2.cartodb.com/api/v2/sql?q=SELECT *  FROM faces").addTo(map);
		    	};
		    if(who){
			    vizlayer = L.instagram.cluster("http://photogrammar2.cartodb.com/api/v2/sql?q=SELECT *  FROM faces WHERE pname='" + who + "'").addTo(map);
		    };			 
		};

    function adjustsqlethnic(who) {
	    map.removeLayer(vizlayer);
	    	if(! who){
		    	vizlayer = L.instagram.cluster("http://photogrammar2.cartodb.com/api/v2/sql?q=SELECT *  FROM faces").addTo(map);
		    	};
		    if(who=='chinese'){
			    vizlayer = L.instagram.cluster("http://photogrammar2.cartodb.com/api/v2/sql?q=SELECT *  FROM faces WHERE cnumber in ('oem2002008536/PP','oem2002008536/PP','owi2001009674/PP','owi2001009675/PP','owi2001009675/PP','owi2001009682/PP','owi2001009690/PP','owi2001009696/PP','owi2001009700/PP','owi2001009706/PP','owi2001009733/PP','owi2001009733/PP','owi2001009733/PP','owi2001009734/PP','owi2001009743/PP','owi2001009787/PP','owi2001009804/PP','owi2001009813/PP','owi2001009814/PP','owi2001009838/PP','owi2001009838/PP','owi2001009838/PP','owi2001009522/PP','owi2001009524/PP','owi2001009533/PP','owi2001009538/PP','owi2001009555/PP','owi2001009555/PP','owi2001019451/PP','owi2001019451/PP')").addTo(map);
			    
			       };

		    if(who=='portuguese'){
			    vizlayer = L.instagram.cluster("http://photogrammar2.cartodb.com/api/v2/sql?q=SELECT *  FROM faces WHERE cnumber in ('fsa2000024280/PP','fsa2000024230/PP','fsa2000024245/PP','fsa2000024255/PP','fsa2000024288/PP','fsa2000024300/PP','fsa2000024300/PP','owi2001005642/PP','owi2001005642/PP','owi2001003711/PP','owi2001004209/PP','owi2001004235/PP','owi2001004279/PP','owi2001004306/PP','owi2001004331/PP','owi2001046722/PP')").addTo(map);
			    
		    };

		    if(who=='swedish'){
			    vizlayer = L.instagram.cluster("http://photogrammar2.cartodb.com/api/v2/sql?q=SELECT *  FROM faces WHERE cnumber in ('owi2001009804/PP','owi2001003289/PP','owi2001003468/PP','owi2001003302/PP','owi2001003303/PP','owi2001003305/PP','owi2001003305/PP','owi2001003305/PP','owi2001003309/PP','owi2001003468/PP','owi2001007394/PP','owi2001007397/PP','owi2001007399/PP','owi2001007399/PP','owi2001007423/PP','owi2001023860/PP','owi2001023838/PP','owi2001023838/PP','owi2001023845/PP','owi2001023849/PP','owi2001023855/PP','owi2001023857/PP','owi2001023859/PP','owi2001023862/PP','owi2001023880/PP','owi2001023882/PP')").addTo(map);
			    
		    };
		

			 
		};


		$("select#pname").on("change", function(e) { adjustsql(e.val); });
		$("select#ethnic").on("change", function(e) { adjustsqlethnic(e.val); });

	</script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/holder.js"></script>
  </body>
</html>
</body>
</html>



