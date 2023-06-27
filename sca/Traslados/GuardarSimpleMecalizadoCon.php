<?php
include('../conf.php');
include('../bd.php');

$hora_llamado = date("Y-m-d h:m");

$consulta = "insert into traslados(tipo_traslado,convenio,paciente,telefono,celular,fecha_traslado,hora_llamado,Direccion_origen, Direccion_destino,ciudad,costo,estado) values ('Traslado Simple Convenio',  '".$_GET['convenio']."','".$_GET['paciente']."','".$_GET['telefono']."','".$_GET['celular']."','".$_GET['fecha_traslado']."',  '".$hora_llamado."',  '".$_GET['direco']."','".$_GET['direccion_destino']."','".$_GET['ciudad']."','".$_GET['costo']."','0')";
$resultados = mysql_query($consulta);

if($resultados){
echo '<div class="mensaje"><img src="IMG/tick.png">Los cambios se han realizado con exito.</div>';
}
?>