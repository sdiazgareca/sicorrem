<?php
include('../conf.php');
include('../bd.php');

$corre = $_GET['corre'];
$num = $_GET['num'];
$movil = $_GET['movil'];

$consultax = "update fichas set  movil='".$num."' where correlativo = '".$corre."'";		
$resultadosx = mysql_query($consultax);

$consultay = "update movilasig set estado ='1' where numero ='".$num."'";		
$resultadosy = mysql_query($consultay);

$consultaz = "update movil_espera set estado ='0' where cod ='".$movil."'";		
$resultadosz = mysql_query($consultaz);
?>