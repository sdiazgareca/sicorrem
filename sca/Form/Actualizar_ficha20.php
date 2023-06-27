<?php
include('../conf.php');
include('../bd.php');
$destino = $_GET['destino'];
$correlativo = $_GET['correlativo'];
$query = "update fichas set obser_man ='".$destino."' where correlativo ='".$correlativo."'";
$resultadosre = mysql_query($query);
?>