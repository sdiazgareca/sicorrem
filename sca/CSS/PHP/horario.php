<?php
include('../conf.php');
include('../bd.php');

$campo = $_GET['campo'];
$rut = $_GET['rut'];
$correlativo =  $_GET['correlativo'];
$fecha = date('Y-m-d  H:i:s');
$consulta = "select * from fichas";
$resultados = mysql_query($consulta);
if ($resultados){
$fecha_actu = date('d-m-Y H:i:s');
mysql_query($conexion);
}

?>