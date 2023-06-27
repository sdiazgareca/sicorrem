<?php
include('conf.php');
include('bd.php');

$mil=1001;
for($i=1;$i<1000;$i++){
$query=" INSERT INTO movil_espera(cod,Espera,estado) VALUES ( '".$mil."','".$i."','0')";
$con =mysql_query($query);
$mil = $mil +1;
echo'ja';
}
?>