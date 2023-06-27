<?php
include('../conf.php');
include('../bd.php');

//echo $_GET['corre'];

$consulta2 = "select hora_llega_destino from fichas where movil='".$_GET['corre']."' and estado=1";
$con_estado2 = mysql_query($consulta2);
$mat_diag_q = mysql_fetch_array($con_estado2);
if ($mat_diag_q['hora_llega_destino'] > 0){
$consulta = "update fichas set hora_sale_destino='".date('Y-m-d H:i:s')."' where movil='".$_GET['corre']."' and estado=1 ";
$con_estado = mysql_query($consulta);
}
?>
