<?php

include('../conf.php');
include('../bd.php');
?>
<table style="font-size:10px;">
<tr>
<td class="celda1">&nbsp;</td>
<td class="celda1">PLAN</td>
<td class="celda1">TIPO</td>
<td class="celda1">PROT</td>
<td class="celda1">CONT</td>
<td class="celda1">TELEFONO</td>
<td class="celda1">CELULAR</td>
<td class="celda1">PACIENTE</td>
<td class="celda1">EDAD</td>
<td class="celda1">MEDICO</td>
<td class="celda1">PARAMEDICO</td>
<td class="celda1">CONDUCTOR</td>
<td class="celda1">OPERADOR</td>
<td class="celda1">DIAGNOSTICO</td>
<td class="celda1">OBSERVACION</td>
<td class="celda1">HORA LLAMADO</td>
<td class="celda1">HORA DESPACHO</td>
<td class="celda1">HORA SALIDA BASE</td>
<td class="celda1">HORA LLEGADA DOMICILIO</td>
<td class="celda1">HORA SALE DOMICILIO</td>
<td class="celda1">HORA LLEGADA DESTINO</td>
<td class="celda1">HORA SALE DOMICILIO</td>
<td class="celda1">CLAVE</td>
<td class="celda1">MOVIL</td>
<td class="celda1">SECTOR</td>
<td class="celda1">?</td>
<td class="celda1">Centro Hospitalario</td>

<td class="celda1">Fecha Traslado</td>
<td class="celda1">Direccion Origen</td>
<td class="celda1">Direccion Destino</td>

</tr>
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
WHERE fichas.estado=0 order by correlativo desc";
$resultados = mysql_query($power);
while ( $matriz_resultados = mysql_fetch_array($resultados) ){

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
<tr>
<td><? echo $plann; ?></td>
<?php
if ($matriz_resultados['tipo_plan'] != 'PA'){

$query_plann ="SELECT planes.desc_plan FROM fichas 
INNER JOIN planes ON fichas.cod_plan = planes.cod_plan
WHERE fichas.cod_plan='".$matriz_resultados['cod_plan']."' AND fichas.tipo_plan='".$matriz_resultados['tipo_plan']."'";

$resul_plann  = mysql_query($query_plann);
$matriz_plann = mysql_fetch_array($resul_plann);
?>
<td><?php echo $matriz_plann['desc_plan'];?></td>
<?php
}
else{
?>
<td>&nbsp;</td>
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
<td><?php echo $plann; ?></td>

<td><?php echo $matriz_resultados['correlativo']; ?></td>
<td><?php echo $matriz_resultados['num_solici']; ?></td>

<td><?php echo $matriz_resultados['telefono']; ?></td>
<td><?php echo $matriz_resultados['celular']; ?></td>
<td><?php echo $matriz_resultados['paciente']; ?></td>
<td><?php echo $matriz_resultados['edad']; ?></td>


<?php
$query_me ="
SELECT nombre1,apellidos FROM personal
INNER JOIN fichas ON personal.rut=fichas.medico where fichas.medico='".$matriz_resultados['medico']."'";
$resul_me = mysql_query($query_me);
$matriz_me= mysql_fetch_array($resul_me);
?>
<td><?php echo $matriz_me['nombre1']; ?>&nbsp;<?php echo $matriz_me['apellidos']; ?></td>

<?php
$query_pa ="
SELECT nombre1,apellidos FROM personal
INNER JOIN fichas ON personal.rut=fichas.paramedico where fichas.paramedico='".$matriz_resultados['paramedico']."'";
$resul_pa = mysql_query($query_pa);
$matriz_pa= mysql_fetch_array($resul_pa);
?>
<td><?php echo $matriz_pa['nombre1']; ?>&nbsp;<?php echo $matriz_pa['apellidos']; ?></td>

<?php
$query_co ="
SELECT nombre1,apellidos FROM personal
INNER JOIN fichas ON personal.rut=fichas.conductor where fichas.conductor='".$matriz_resultados['conductor']."'";
$resul_co = mysql_query($query_co);
$matriz_co= mysql_fetch_array($resul_co);
?>
<td><?php echo $matriz_co['nombre1']; ?>&nbsp;<?php echo $matriz_co['apellidos']; ?></td>

<td><?php echo $matriz_resultados['nomoperador']; ?>&nbsp;<?php echo $matriz_resultados['apoperador']; ?></td>

<?php
if ($matriz_resultados['color'] !='Azul'){

$query_diag ="SELECT diagnostico.diagnostico
FROM fichas 
INNER JOIN diagnostico ON CONVERT(diagnostico.cod USING utf8 )=CONVERT(fichas.diagnostico USING utf8 ) where correlativo ='".$matriz_resultados['correlativo']."'";
$resul_diag = mysql_query($query_diag);
$matriz_diag= mysql_fetch_array($resul_diag);
?>
<td><?php echo $matriz_diag['diagnostico']; ?></td>
<?php
}
else{
?>
<td>&nbsp;</td>
<?
}
?>
<td><?php echo $matriz_resultados['observacion']; ?></td>

<td><?php echo $matriz_resultados['hora_llamado']; ?></td>
<td><?php echo $matriz_resultados['hora_despacho']; ?></td>
<td><?php echo $matriz_resultados['hora_salida_base']; ?></td>
<td><?php echo $matriz_resultados['hora_llegada_domicilio']; ?></td>
<td><?php echo $matriz_resultados['hora_sale_domicilio']; ?></td>
<td><?php echo $matriz_resultados['hora_sale_destino']; ?></td>
<td><?php echo $matriz_resultados['hora_llega_destino']; ?></td>
<td><?php echo $matriz_resultados['color']; ?></td>
<td><?php echo $matriz_resultados['movil']; ?></td>
<td><?php echo $matriz_resultados['sector']; ?></td>
<td><?php echo $matriz_resultados['destino']; ?></td>


<?
$query_centro ="SELECT centrohospita.Lugar
FROM 
fichas INNER JOIN centrohospita ON fichas.CentroHospitalario = centrohospita.cod
WHERE fichas.correlativo='".$matriz_resultados['correlativo']."'";

$resul_centro = mysql_query($query_centro);
$matriz_centro= mysql_fetch_array($resul_centro);
?>
<td><?php echo $matriz_centro['Lugar']; ?></td>
<?php
if($matriz_resultados['color']=='Azul'){

$query_trasladoss ="SELECT planes_traslados.desc_plan,traslados.convenio,fichas.correlativo,
DATE_FORMAT(fecha_traslado,'%d-%m-%Y %H:%i:%S') AS  fecha_traslado,Direccion_origen,Direccion_destino,ciudad  
FROM fichas 
INNER JOIN traslados ON fichas.traslado=traslados.cod AND fichas.correlativo='".$matriz_resultados['correlativo']."' INNER JOIN planes_traslados ON planes_traslados.cod_plan=traslados.convenio";

$resul_trasladoss = mysql_query($query_trasladoss);
$matriz_trasladoss= mysql_fetch_array($resul_trasladoss);

?>
<td><?php echo $matriz_trasladoss['fecha_traslado']; ?></td>
<td><?php echo $matriz_trasladoss['Direccion_origen']; ?></td>
<td><?php echo $matriz_trasladoss['Direccion_destino'].' '.$matriz_trasladoss['ciudad']; ?></td>
<?
}
}
?>
</tr>
</table>