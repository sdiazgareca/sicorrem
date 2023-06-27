<?php
include('../conf.php');
include('../bd.php');

$destino = $_GET['destino'];
$observacion = $_GET['observacion'];
$correlativo = $_GET['correlativo'];
$direccion_ficha = $_GET['direccion_ficha'];
$direccion = $_GET['direccion'];
$color = $_GET['color'];


if ($destino < 1){
echo "";
}
else{
$query ="update fichas set observacion='".htmlentities($observacion)."',obser_man='".htmlentities($destino)."',direccion='".$direccion."',color='".$color."' where correlativo='".$correlativo."'";
$resultados = mysql_query($query);

$query2 ="update fichas set obser_man ='".$destino."' where correlativo ='".$correlativo."'";
$resultados2 = mysql_query($query2);
}
?>

