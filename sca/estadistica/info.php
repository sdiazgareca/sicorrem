<table class="celda3" style=" border: 2px solid #006699">
<tr>
<td>

<?php
include('../conf.php');
include('../bd.php');
?>
<?php
$power="
SELECT 
DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') AS hora_llamado,
DATE_FORMAT(hora_despacho,'%d-%m-%Y %H:%i:%S') AS hora_despacho,
DATE_FORMAT(hora_salida_base,'%d-%m-%Y %H:%i:%S') AS hora_salida_base,
DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y %H:%i:%S') AS hora_llegada_domicilio,
DATE_FORMAT(hora_sale_domicilio,'%d-%m-%Y %H:%i:%S') AS hora_sale_domicilio,
DATE_FORMAT(hora_sale_destino,'%d-%m-%Y %H:%i:%S') AS hora_sale_destino,
fichas.observacion,
operador.apellido AS apoperador,
operador.nombre1 AS nomoperador,
fichas.telefono,
fichas.celular,
fichas.correlativo,
fichas.num_solici,
DATE_FORMAT(hora_llega_destino,'%d-%m-%Y %H:%i:%S') AS hora_llega_destino,
fichas.edad,
fichas.direccion,
fichas.paciente,
color.color,
fichas.correlativo,
operador.nombre1,
operador.apellido,
fichas.medico,
fichas.paramedico,
fichas.conductor,
destino.destino,
fichas.movil,
sector.sector,
fichas.observacion,
fichas.tipo_plan,
fichas.cod_plan,
CentroHospitalario

FROM fichas 
INNER JOIN color ON fichas.color=color.cod
INNER JOIN operador ON operador.rut = fichas.operador
INNER JOIN destino ON destino.cod=fichas.obser_man
INNER JOIN sector ON sector.cod=fichas.sector
WHERE fichas.estado=0 and correlativo='".$_GET['correlativo']."' order by correlativo desc";
$resultados = mysql_query($power);
while ( $matriz_resultados = mysql_fetch_array($resultados) ){
?>
<table>
<tr style="background-color:#006699;">
<td><h1 style="color:#FFFFFF; background-color:#006699;"><?php echo $matriz_resultados['destino']; ?></h1></td>
</tr>
</table>

<table  class="celda3">
<tr>
<?php
if ($matriz_resultados['tipo_plan'] != 'PA'){

$query_plann ="SELECT planes.desc_plan FROM fichas 
INNER JOIN planes ON fichas.cod_plan = planes.cod_plan
WHERE fichas.cod_plan='".$matriz_resultados['cod_plan']."' AND fichas.tipo_plan='".$matriz_resultados['tipo_plan']."'";

$resul_plann  = mysql_query($query_plann);
$matriz_plann = mysql_fetch_array($resul_plann);
?>


<td>PLAN</td><td class="celda2"><?php echo $matriz_plann['desc_plan']; ?></td>
<?php
}
else{
?>
<td>&nbsp;</td><td class="celda2">&nbsp;</td>
<?php
}

$plann = 'AFILIADO';

if($matriz_resultados['tipo_plan'] == 'PA'){
$plann ='PARTICULAR';
}
if($matriz_resultados['tipo_plan'] == 'CA'){
$plann ='FAMILIAR DIRECTO';
}

if($matriz_resultados['tipo_plan'] == 'TRA_ME'){
$plann ='TRASLADO MEDICALIZADO CONVENIO';
}

if($matriz_resultados['tipo_plan'] == 'TRA_CONV'){
$plann ='TRASLADO SIMPLE CONVENIO';
}

if ( ($matriz_resultados['tipo_plan'] == '1') and ($matriz_resultados['color']=='Azul')){
$plann ='TRASLADO PROGRAMADO AFILIADOS DIRECTO';
}

if($matriz_resultados['tipo_plan'] == 'TRA_PAR'){
$plann ='TRASLADO SIMPLE DE PARTICULARES';
}
?>

<td>TIPO</td><td class="celda2"><?php echo $plann; ?></td>
<td>PROT</td><td  class="celda2"><?php echo $matriz_resultados['correlativo']; ?></td>
</tr>

<?php
if($matriz_resultados['tipo_plan'] == 'PA'){
$matriz_resultados['num_solici'] = $plann;
}
?>
<tr>
<td>CONT</td><td  class="celda2"><?php echo $matriz_resultados['num_solici']; ?></td>

<td>Clave</td><td><?php echo $matriz_resultados['color']; ?></td>
<td>Movil</td><td><?php echo $matriz_resultados['movil']; ?></td>
<td>Sector</td><td><?php echo $matriz_resultados['sector']; ?></td>
</tr>
</table>



<table class="celda3">
<tr>
<td>Paciente</td><td  class="celda2"><?php echo htmlentities($matriz_resultados['paciente']); ?></td>
<td>Edad</td><td  class="celda2"><?php echo $matriz_resultados['edad']; ?></td>
<td>Telefono</td><td  class="celda2"><?php echo $matriz_resultados['telefono']; ?></td>
<td>Celular</td><td  class="celda2"><?php echo $matriz_resultados['celular']; ?></td>
</tr>
</table>

<table>
<tr>
<td>Direccion</td>
<td><?php echo htmlentities($matriz_resultados['direccion']); ?></td>
</tr>
</table>
<br />

<table  class="celda3" style="width:200px;">
<tr style="background-color:#FFFF99;">
<td align="center">Medico</td>
<td align="center">Paramedico</td>
<td align="center">Conductor</td>
<td align="center">Operador</td>
</tr>
<tr>
<?php
$query_me ="
SELECT nombre1,apellidos FROM personal
INNER JOIN fichas ON personal.rut=fichas.medico where fichas.medico='".$matriz_resultados['medico']."'";
$resul_me = mysql_query($query_me);
$matriz_me= mysql_fetch_array($resul_me);
?>
<td class="celda2" style="background-color:#FFCC66;"><?php echo $matriz_me['nombre1']; ?>&nbsp;<?php echo $matriz_me['apellidos']; ?></td>

<?php
$query_pa ="
SELECT nombre1,apellidos FROM personal
INNER JOIN fichas ON personal.rut=fichas.paramedico where fichas.paramedico='".$matriz_resultados['paramedico']."'";
$resul_pa = mysql_query($query_pa);
$matriz_pa= mysql_fetch_array($resul_pa);
?>
<td class="celda2" style="background-color:#FFCC66;"><?php echo $matriz_pa['nombre1']; ?>&nbsp;<?php echo $matriz_pa['apellidos']; ?></td>

<?php
$query_co ="
SELECT nombre1,apellidos FROM personal
INNER JOIN fichas ON personal.rut=fichas.conductor where fichas.conductor='".$matriz_resultados['conductor']."'";
$resul_co = mysql_query($query_co);
$matriz_co= mysql_fetch_array($resul_co);
?>
<td class="celda2" style="background-color:#FFCC66;"><?php echo $matriz_co['nombre1']; ?>&nbsp;<?php echo $matriz_co['apellidos']; ?></td>
<td class="celda2"  style="background-color:#FFCC66;"><?php echo $matriz_resultados['nomoperador']; ?>&nbsp;<?php echo $matriz_resultados['apoperador']; ?></td>
</tr>
</table>

<table class="celda2">
<tr style="background-color:#FFCC00; color:#003300;">
<?php
if ($matriz_resultados['color'] !='Azul'){

$query_diag ="SELECT diagnostico.diagnostico
FROM fichas 
INNER JOIN diagnostico ON CONVERT(diagnostico.cod USING utf8 )=CONVERT(fichas.diagnostico USING utf8 ) where correlativo ='".$matriz_resultados['correlativo']."'";
$resul_diag = mysql_query($query_diag);
$matriz_diag= mysql_fetch_array($resul_diag);
?>
<td style="background-color:#FFCC00; color:#003300;">Diagnostico: </td>
<td class="celda2" style="background-color:#FFCC00; color:#003300;"><?php echo $matriz_diag['diagnostico']; ?></td>
<?php
}
else{
?>
<td>&nbsp;</td>
<td>&nbsp;</td>
<?
}
?>
</tr>
</table>

<table class="celda3">
<tr>
<td style="width:auto;">Observaciones</td><td style="width:80%;" class="celda2"><?php echo $matriz_resultados['observacion']; ?></td>
</tr>
</table>

<table class="celda3" style="width:70px;">
<tr style="background-color:#FFFFFF;border:solid 1px #006699;">
<td style="width:10px;">Hs LLamado</td>
<td style="width:10px;">Hs Despacho</td>
<td style="width:10px;">Hs Hora Salida Base</td>
<td style="width:10px;">Hs Llega Domicilio</td>
<td style="width:10px;">Hs Sale Domicilio</td>
<td style="width:10px;">Hs Sale Destino</td>
<td style="width:10px;">Hs Llega Destino</td>
</tr>

<tr style="background-color:#FFFFFF;border:solid 1px #006699;">
<td class="celda2"  style="width:10px;"><?php echo $matriz_resultados['hora_llamado']; ?></td>
<td class="celda2"  style="width:10px;"><?php echo $matriz_resultados['hora_despacho']; ?></td>
<td class="celda2"  style="width:10px;"><?php echo $matriz_resultados['hora_salida_base']; ?></td>
<td class="celda2"><?php echo $matriz_resultados['hora_llegada_domicilio']; ?></td>
<td class="celda2"><?php echo $matriz_resultados['hora_sale_domicilio']; ?></td>
<td class="celda2"><?php echo $matriz_resultados['hora_sale_destino']; ?></td>
<td class="celda2"><?php echo $matriz_resultados['hora_llega_destino']; ?></td>
</tr>
</table>

<table class="celda3">
<tr class="celda3">
<?
$query_centro ="SELECT centrohospita.Lugar
FROM 
fichas INNER JOIN centrohospita ON fichas.CentroHospitalario = centrohospita.cod
WHERE fichas.correlativo='".$matriz_resultados['correlativo']."'";

$resul_centro = mysql_query($query_centro);
$matriz_centro= mysql_fetch_array($resul_centro);
?>
<td class="celda2">Centro Hospitalario: <?php echo $matriz_centro['Lugar']; ?></td>
</tr>
</table>

<?php
if($matriz_resultados['color']=='Azul'){
?>
<table>
<tr>
<?php
$query_trasladoss ="SELECT planes_traslados.desc_plan,traslados.convenio,fichas.correlativo,
DATE_FORMAT(fecha_traslado,'%d-%m-%Y %H:%i:%S') AS  fecha_traslado,Direccion_origen,Direccion_destino,ciudad  
FROM fichas 
INNER JOIN traslados ON fichas.traslado=traslados.cod AND fichas.correlativo='".$matriz_resultados['correlativo']."' INNER JOIN planes_traslados ON planes_traslados.cod_plan=traslados.convenio";

$resul_trasladoss = mysql_query($query_trasladoss);
$matriz_trasladoss= mysql_fetch_array($resul_trasladoss);

?>
<td class="celda2">Direccion de Origen: <?php echo $matriz_trasladoss['Direccion_origen']; ?></td>
<td class="celda2">Direccion de Destino<?php echo $matriz_trasladoss['Direccion_destino'].' '.$matriz_trasladoss['ciudad']; ?></td>
</tr>
</table>
<?php
}
}
?>
</td>
</tr>
</table>