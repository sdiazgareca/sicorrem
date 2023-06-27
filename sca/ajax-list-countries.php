<?
$conn = mysql_connect("localhost","root","");
mysql_select_db("base01",$conn);

if(isset($_GET['getCountriesByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
	//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$res = mysql_query("SELECT cod FROM diagnostico WHERE cod LIKE '".$letters."%'") or die(mysql_error());
	#echo "1###select ID,countryName from ajax_countries where countryName like '".$letters."%'|";
	while($inf = mysql_fetch_array($res)){
		echo $inf["cod"]."###".$inf["cod"]."|";
	}	
}
?>
