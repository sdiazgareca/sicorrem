<?php
include('../conf.php');
include('../bd.php');
$ob = $_GET['ob'];
$correlativo = $_GET['correlativo'];
$query = "update fichas set observacion ='".$ob."' where correlativo ='".$correlativo."'";
$resultadosre = mysql_query($query);
?>