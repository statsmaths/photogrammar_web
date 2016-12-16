
<?php
$hex=str_replace("#","",$_GET['hex']);
$db = mysql_connect("mysql", "com_photogrammar", "ESDq160377281UL");
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");
@mysql_select_db(com_photogrammar) or die( "Unable to select database");

echo '<br><br><div>';

$hexquery = "SELECT DISTINCT colour.cnumber, title, thumb_url FROM colour JOIN photo2 ON photo2.cnumber=colour.cnumber WHERE hex ='" . $hex . "';";
/* echo $hexquery; */
$hexresult =  mysql_query($hexquery) or die(mysql_error());
while($row = mysql_fetch_array($hexresult)){
	$thisthumb = $row['thumb_url'];
	$trunctitle = $row['title'];
	echo "<div style='margin-right:1px;width:170px;float:left;'><img style=\"margin-left:auto;margin-bottom:0;margin-right:auto;border:1px solid black;\" src=\"http://maps.library.yale.edu/images/public/photogrammar/" . $thisthumb . "\" /><div>";
echo '<div class="datef">' .  $trunctitle . '</div>';
	$onecoverquery = "SELECT hex FROM colour WHERE cnumber ='" . $thisthumb . "';";

	$onecoverresult =  mysql_query($onecoverquery) or die(mysql_error());
	while($row = mysql_fetch_array($onecoverresult)){

		echo "<div style='float:left;";
		if ($hex==$row['hex']) {
		echo "border:3px solid black;height:13px;width:13px;";
		}
		else {
				echo "border:1px solid black;height:17px;width:17px;";	
		}
		echo "margin-bottom:1px;margin-left:1px;background-color:#" . $row['hex'] . "' title='#" . $row['hex'] . "'></div> ";
	};
	echo "</div></div>";
	
	};
	
?>
</div>