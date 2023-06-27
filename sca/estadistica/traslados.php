<?php
set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');


header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=traslados.xls");

include('../conf.php');
include('../bd.php');
include('../moneda.php');

$plan_tras = $_GET['plan_tras'];
$mes_tras = $_GET['mes_tras'];
$anio = $_GET['anio_tras'];

if ($plan_tras < 1){
$quey = "where month(hora_llamado) = '".$mes_tras."' and year(hora_llegada_domicilio)='".$anio."'";
}
else{
$quey = "where planes_traslados.cod_plan = '".$_GET['plan_tras']." and month(hora_llamado) = '".$mes_tras."' and year(hora_llegada_domicilio)='".$anio."'";
}

?>

<table style="font-size:10px;">
<tr>
<td class="celda1">N�</td>
<td class="celda1">FECHA</td>
<td class="celda1">PROTOC.</td>
<td class="celda1">TELEF�NO</td>
<td class="celda1">CELULAR</td>
<td class="celda1">NOMBRE</td>
<td class="celda1">EDAD</td>
<td class="celda1">DESDE</td>
<td class="celda1">HASTA</td>
<td class="celda1">VALOR</td>
<td class="celda1">OPERADOR</td>
<td class="celda1">RESPONBLE</td>
<td class="celda1">OBSERVACI�N</td>
<td class="celda1">PARAM�DICO</td>
<td class="celda1">M�DICO</td>
</tr>

<?php
$power="select day(hora_llamado) as dia,month(hora_llamado) as mes,year(hora_llamado) as anio,correlativo,telefono,celular,paciente,edad,Direccion_origen,Direccion_destino,operador.nombre1 as op,observacion,paramedico,medico,boleta,importe,traslado_tipo.traslado, planes_traslados.desc_plan
from fichas
inner join operador on operador.rut = fichas.operador
inner join traslados on fichas.traslado = traslados.cod
inner join copago on copago.protocolo = fichas.correlativo
inner join traslado_tipo on traslado_tipo.cod = tipo_traslado
inner join planes_traslados on traslados.convenio = planes_traslados.cod_plan ".$quey."";

$resultados = mysql_query($power);

while ( $matriz_resultados = mysql_fetch_array($resultados) ){
?>
<tr>
<td>&nbsp;</td>
<td>&nbsp;<?php echo $matriz_resultados['dia'].'-'.$matriz_resultados['mes'].'-'.$matriz_resultados['anio']; ?></td>
<td>&nbsp;<?php echo $matriz_resultados['correlativo']; ?></td>
<td>&nbsp;<?php echo $matriz_resultados['telefono']; ?></td>
<td>&nbsp;<?php echo $matriz_resultados['celular']; ?></td>
<td>&nbsp;<?php echo $matriz_resultados['paciente']; ?></td>
<td>&nbsp;<?php echo $matriz_resultados['edad']; ?></td>
<td>&nbsp;<?php echo $matriz_resultados['Direccion_origen']; ?></td>
<td>&nbsp;<?php echo $matriz_resultados['Direccion_destino']; ?></td>
<td>&nbsp;<?php echo amoneda($matriz_resultados['importe'], pesos); ?></td>
<td>&nbsp;<?php echo strtoupper($matriz_resultados['op']); ?></td>
<td>&nbsp;</td>
<td>&nbsp;<?php echo $matriz_resultados['observacion']; ?></td>

<?php
$paramedico = "select nombre1,apellidos from personal where rut='".$matriz_resultados['paramedico']."'";
$paramedico_q = mysql_query($paramedico);
$paramedico_r = mysql_fetch_array($paramedico_q);
?>
<td>&nbsp;<?php echo $paramedico_r['nombre1'].' '.$paramedico_r['apellidos']; ?></td>

<?php
$medico = "select nombre1,apellidos from personal where rut='".$matriz_resultados['medico']."'";
$medico_q = mysql_query($medico);
$medico_r = mysql_fetch_array($medico_q);
?>
<td>&nbsp;<?php echo $medico_r['nombre1'].' '.$medico_r['apellidos']; ?></td>

<?
}
?>
</tr>
</table>
