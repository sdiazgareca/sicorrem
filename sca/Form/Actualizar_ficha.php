
<?php
include('../conf.php');
include('../bd.php');

$destino = $_GET['destino'];
$observacion = $_GET['observacion'];
$correlativo = $_GET['correlativo'];
$direccion_ficha = $_GET['direccion_ficha'];
$direccion = $_GET['direccion'];
$color = $_GET['color'];

echo 'Cargando';

if ($destino < 1){
$query ="update fichas set direccion='".$direccion."',color='".$color."' where correlativo='".htmlentities($correlativo)."'";
}
else{
$query ="update fichas set obser_man='".htmlentities($destino)."',direccion='".$direccion."',color='".$color."' where correlativo='".$correlativo."'";
$resultados = mysql_query($query);
}

$con = "select count(movil) as mov from fichas where movil = ".$_GET['movil']." and estado =1";
$res = mysql_query($con);
$mat = mysql_fetch_array($res);

	if ($_GET['movil'] < 1000){

		$con1 = "update fichas set  estado='0' where movil='".$_GET['movil']."' and correlativo ='".$correlativo."'";
		$dell = mysql_query($con1);
		
		if ($mat['mov'] <= 1){
		$con2 = "update movilasig set estado='0' where numero='".$_GET['movil']."'";  
		$del2 = mysql_query($con2);
		}
	}
	
	if ($_GET['movil'] > 1000){
		$con1 = "update fichas set  estado='0' where movil='".$_GET['movil']."' and correlativo ='".$correlativo."'";
		$dell = mysql_query($con1);
		
		if ($mat['mov'] < 1000){
		$con2 = "update movil_espera set estado='0' where cod='".$_GET['movil']."'";  
		$del2 = mysql_query($con2);
		}	
	}

?>

