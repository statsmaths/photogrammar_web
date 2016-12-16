<!doctype html>
<html lang=en>
<head>
<meta charset=utf-8>
<title>Photogrammar: FSA/OWI in Color</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="tinycolor.js"></script>
<script type="text/javascript" src="jquery.tinysort.min.js"></script>
<script type="text/javascript" src="jquery.sparkline.min.js"></script>


</head>
<style>

/*

body {width:768px;}
*/
div.datef { font-size:.6em;margin-bottom:5px;}
div.ilsparkline {border:1px solid black;margin:2px;
	border-left:2px solid red;
width:165px;
float:left;
	border-right:2px solid red;
}
div.markerline {
	height:0;
	width:11px;
	border-top:1px solid white;
		position:relative;

}
div.colorhover {
	height:70px;
	width:10px;
	vertical-align:bottom;margin-left:1px;display:inline-table;border-top:4px solid white;
}

.unbordered {
		border-top:1px solid white;
}
span.hue, span.sat, span.lum, span.count {display:none;}
p.heading {font-size:0.8em;
background-color: black;color:white;
padding:2px;margin-bottom:2px;
text-align: left;}
p.heading a, p.heading a:link, p.heading a:visited {text-decoration: none; font-weight:bold; color:white;}


@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) 
and (orientation : landscape) { div.colorhover, div.markerline {	width:15px;}}


</style>

<script>
  function getHue(hex) {
  var result = tinycolor(hex).toHsv()  
  document.write('<span class="hue">' + Math.round(result.h) + '</span>');
  }
  function getSat(hex) {
  var result = tinycolor(hex).toHsv()  
  document.write('<span class="sat">' + (result.s * 100) + '</span>');
  }
  function getLum(hex) {
  var result = tinycolor(hex).toHsl()  
  document.write('<span class="lum">' + (result.l * 100) + '</span>');
  }
  </script>
<body style="font-family:sans-serif;">
<h3 style="margin:3px;">FSA/OWI Photography in Color. Touch a color! <span id="whichcolour"></span></h3>
<p class="heading" style="background-color:black;">
Touch to sort colors by: 
<a id="countbutton" href="javascript:$('div.colorhover').tsort('span.count',{order:'desc'});$('p.heading a').css('color','white');$('a#countbutton').css('color', 'red');$('span#whatorder').text('frequency');" style="color:red;">Frequency</a>
|
<a id="huebutton" href="javascript:$('div.colorhover').tsort('span.lum');$('div.colorhover').tsort('span.sat');$('div.colorhover').tsort('span.hue');$('p.heading a').css('color','white');$('a#huebutton').css('color', 'red');$('span#whatorder').text('hue');">Hue</a> 
|
<a id="satbutton" href="javascript:$('div.colorhover').tsort('span.hue');$('div.colorhover').tsort('span.lum');$('div.colorhover').tsort('span.sat');$('p.heading a').css('color','white');$('a#satbutton').css('color', 'red');$('span#whatorder').text('saturation');">Saturation</a> 
|
<a id="lumbutton" href="javascript:$('div.colorhover').tsort('span.hue');$('div.colorhover').tsort('span.sat');$('div.colorhover').tsort('span.lum');$('p.heading a').css('color','white');$('a#lumbutton').css('color', 'red');$('span#whatorder').text('luminosity');">Brightness</a> 

</p>
<div style="margin-bottom:5px;">
<?php
$db = mysql_connect("mysql", "com_photogrammar", "ESDq160377281UL");
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");
@mysql_select_db(com_photogrammar) or die( "Unable to select database");
$colourquery = "SELECT  hex, COUNT(hex) AS hexcount FROM colour GROUP BY hex ORDER BY hexcount DESC;";

$colourresult =  mysql_query($colourquery) or die(mysql_error());
while($row = mysql_fetch_array($colourresult)){ echo '<div class="colorhover" style="background-color:#' . $row['hex'] .';"><div class="markerline" style="top:' . (70 - ($row['hexcount']*0.0965)) . 'px;"></div><script>getHue("#' . $row['hex'] . '");getSat("#' . $row['hex'] . '");getLum("#' . $row['hex'] . '");</script><span class="count">' . $row['hexcount'] . '</div>';}

?>

</div>

<div id="results"></div>
</body>
  <script>

  $( document ).ready(function() {

  $( "div.colorhover" ).mouseenter(
  function() {
	  	$(this).css("border-top-color","black");	  
  });
  $( "div.colorhover" ).mouseleave(
  function() {
	  	$(this).css("border-top-color","white");	  
  });
  $( "div.colorhover" ).hover(
  function() {
  
  
  var color  = $(this).css("background-color");

  $.ajax({
   url: 'colours.php',
   data: { hex: tinycolor(color).toHex},
   type: "GET",
   success: function (response) {//response is value returned from php (for your example it's "bye bye"
     $("div#results").html(response);
$('.ilsparkline').sparkline('html',{type:'bar', tagValuesAttribute:"data-values", barWidth:3});
$( "span#thiscolour" ).text(tinycolor(color).toName());

   }
});
  var t = tinycolor(color)


    $( "span#whichcolour" ).text(tinycolor(color).toName() + ": " + $("span.count", this).text());
    
    $( "span#whichcolour" ).css('color',color);
   
  }, function() {
    
  }
);

 });
 
  </script>
</html>
