<?php
include('../conf.php');
include('../bd.php');

$hospital = $_GET['hospital'];
$correlativo = $_GET['correlativo'];

$query ="update fichas set CentroHospitalario='".$hospital."' where correlativo='".$correlativo."'";
$resultados = mysql_query($query);
?>

