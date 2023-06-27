<?php

include('../conf.php');
include('../bd.php');

$_GET['folio_med'] = (is_numeric($_GET['folio_med'] ))? $_GET['folio_med'] : 'NULL';
$consulta ="INSERT INTO copago (fecha,protocolo,numero_socio,boleta,importe,tipo_pago,folio_med) VALUES ('".date('Y-m-d')."','".$_GET['correlativo']."','".$_GET['nsocio']."','".$_GET['boleta']."','".$_GET['importe']."','".$_GET['tipo_pago']."','".$_GET['folio_med']."')";


$resultados = mysql_query($consulta);

$consula2="SELECT movilasig.conductor, movilasig.medico, movilasig.paramedico FROM movilasig WHERE movilasig.numero='".$_GET['movil']."'";
$resultados2 = mysql_query($consula2);
$mat2 = mysql_fetch_array($resultados2);

$numero_rowsws = mysql_num_rows($resultados2);

	
	$consulta3="UPDATE fichas SET medico='".$mat2['medico']."',paramedico='".$mat2['paramedico']."',conductor='".$mat2['conductor']."' 
	WHERE fichas.correlativo='".$_GET['correlativo']."'";
	$resultados3=mysql_query($consulta3);
	
	
	$consulta5="UPDATE fichas SET estado='0' WHERE fichas.correlativo='".$_GET['correlativo']."'";
	$resultados5=mysql_query($consulta5);
	
	$consulta4="SELECT fichas.movil FROM fichas WHERE movil='".$_GET['movil']."' and estado=1";
	$resultados4=mysql_query($consulta4);
	$ress_num=mysql_num_rows($resultados4);
	
	if ($num4 < 1){
	$consulta6="UPDATE movilasig SET movilasig.estado = '0' WHERE movilasig.numero='".$_GET['movil']."'";
	$resultados6=mysql_query($consulta6);
	}
	
if($consulta6){
echo MENSAJE88;
}
?>
