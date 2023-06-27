<?php
include('../conf.php');
include('../bd.php');

$diagnostico = $_GET['diagnostico'];
$correlativo = $_GET['correlativo'];

$query ="update fichas set diagnostico='".$diagnostico."' where correlativo='".$correlativo."'";
$resultados = mysql_query($query);
?>

