<?php
include('../conf.php');
include('../bd.php');

$corre = $_GET['corre'];
$num = $_GET['num'];
$movil = $_GET['movil'];

if ($_GET['espera']){
$num = $_GET['espera'];

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$inv = "SELECT fichas.hora_llamado, fichas.hora_despacho,fichas.hora_salida_base, fichas.hora_llegada_domicilio, 
fichas.hora_sale_domicilio, fichas.hora_llega_destino, fichas.hora_sale_destino FROM fichas where movil = '".$num."' and estado =1";
$inv_ress = mysql_query($inv);
$numero_rows3 = mysql_num_rows($inv_ress);

if ($numero_rows3 > 0){
	$matriz_resultados2 = mysql_fetch_array($inv_ress);
	$con = "update fichas set hora_llamado='".$matriz_resultados2['hora_llamado']."',hora_despacho='".$matriz_resultados2['hora_despacho']."',hora_salida_base='".$matriz_resultados2['hora_salida_base']."',hora_llegada_domicilio='".$matriz_resultados2['hora_llegada_domicilio']."',hora_sale_domicilio='".$matriz_resultados2['hora_sale_domicilio']."',hora_llega_destino='".$matriz_resultados2['hora_llega_destino']."',hora_sale_destino='".$matriz_resultados2['hora_sale_destino']."' where correlativo='".$corre."'";
	$tt=mysql_query($con);
}

else{
	$matriz_resultados2 = mysql_fetch_array($inv_ress);
	$con = "update fichas set hora_despacho='0000-00-00 00:00:00',hora_salida_base='0000-00-00 00:00:00',hora_llegada_domicilio='0000-00-00 00:00:00',hora_sale_domicilio='0000-00-00 00:00:00' ,hora_sale_destino='0000-00-00 00:00:00' where correlativo='".$corre."'";

	$tt=mysql_query($con);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$consultax = "update fichas set  movil='".$num."' where correlativo = '".$corre."'";		
$resultadosx = mysql_query($consultax);

$consulta = "select movil from fichas where correlativo = '".$corre."'";
$resultados = mysql_query($consulta);
$matriz_resultados = mysql_fetch_array($resultados);


$nuvaquery = "select movil from fichas where movil = '".$movil."' and estado =1";
$nuevoresul = mysql_query($nuvaquery);
$numero_rows = mysql_num_rows($nuevoresul);


if ($numero_rows < 1){
$consultay = "update movilasig set estado ='0' where numero ='".$movil."'";		
$resultadosy = mysql_query($consultay);
$consultay = "update movil_espera set estado ='0' where cod ='".$movil."'";		
$resultadosy = mysql_query($consultay);
}

$consultay2 = "update movil_espera set estado ='1' where cod ='".$num."'";		
$resultadosy2 = mysql_query($consultay2);
}

else{

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$inv = "SELECT fichas.hora_llamado, fichas.hora_despacho,fichas.hora_salida_base, fichas.hora_llegada_domicilio, 
fichas.hora_sale_domicilio, fichas.hora_llega_destino, fichas.hora_sale_destino FROM fichas where movil = '".$num."' and estado =1";
$inv_ress = mysql_query($inv);
$numero_rows3 = mysql_num_rows($inv_ress);

if ($numero_rows3 > 0){
	$matriz_resultados2 = mysql_fetch_array($inv_ress);
	$con = "update fichas set hora_llamado='".$matriz_resultados2['hora_llamado']."',hora_despacho='".$matriz_resultados2['hora_despacho']."',hora_salida_base='".$matriz_resultados2['hora_salida_base']."',hora_llegada_domicilio='".$matriz_resultados2['hora_llegada_domicilio']."',hora_sale_domicilio='".$matriz_resultados2['hora_sale_domicilio']."',hora_llega_destino='".$matriz_resultados2['hora_llega_destino']."',hora_sale_destino='".$matriz_resultados2['hora_sale_destino']."' where correlativo='".$corre."'";

	$tt=mysql_query($con);
}

else{
	$matriz_resultados2 = mysql_fetch_array($inv_ress);
	$con = "update fichas set hora_despacho='0000-00-00 00:00:00',hora_salida_base='0000-00-00 00:00:00',hora_llegada_domicilio='0000-00-00 00:00:00',hora_sale_domicilio='0000-00-00 00:00:00' ,hora_sale_destino='0000-00-00 00:00:00' where correlativo='".$corre."'";

	$tt=mysql_query($con);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$consultax = "update fichas set  movil='".$num."' where correlativo = '".$corre."'";		
$resultadosx = mysql_query($consultax);

$consulta = "select movil from fichas where correlativo = '".$corre."'";
$resultados = mysql_query($consulta);
$matriz_resultados = mysql_fetch_array($resultados);


$nuvaquery = "select movil from fichas where movil = '".$movil."' and estado=1";//estado=1 Modifi
$nuevoresul = mysql_query($nuvaquery);
$numero_rows = mysql_num_rows($nuevoresul);


if ($numero_rows < 1){
$consultay = "update movilasig set estado ='0' where numero ='".$movil."'";		
$resultadosy = mysql_query($consultay);
$consultay = "update movil_espera set estado ='0' where cod ='".$movil."'";		
$resultadosy = mysql_query($consultay);
}
$consultay2 = "update movilasig set estado ='1' where numero ='".$num."'";		
$resultadosy2 = mysql_query($consultay2);
}
?>