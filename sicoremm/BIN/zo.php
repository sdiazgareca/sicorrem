<?php 
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

$sql = "SELECT ZO, SE, cobrador, descripcion FROM ZOSEMA WHERE cobrador IS NOT NULL GROUP BY ZO, SE";
$query = mysql_query($sql);

while($min = mysql_fetch_array($query)){
	echo "UPDATE `sicoremm2`.`ZOSEMA` SET `descripcion`='".$min['descripcion']."',`cobrador`='".$min['cobrador']."' WHERE `ZO`='".$min['ZO']."' AND `SE`='".$min['SE']."';<br />";
}

?>