<?php

set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=mantencion.xls"); 


include('../conf.php');
include('../bd.php');


//DAY(hora_llamado)BETWEEN '12' AND '12'

$mes = $_GET['mes_manten'];
$anio = $_GET['anio_manten'];
$dia1 = $_GET['mantenciondia1'];
$dia2 = $_GET['mantenciondia2'];


$dia ="";

if ( ($dia1 > 0) and ($dia2 > 0) ){
$dia = "and DAY(hora_llamado) BETWEEN '".$dia1."' AND '".$dia2." '";
} 
?>
<table style="font-size:10px; border:1px solid #000000;">
<tr>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">N&deg;</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">PROT</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">RUT</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">CONT</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">TELEFONO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">PACIENTE</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">EDAD</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">MEDICO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">PARAMEDICO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">OPERADOR</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">DIAGNOSTICO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">OBSERVACION</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">LLAMADA</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">LLEGADA</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">S/QTH</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">DOMICILIO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">CLAVE</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">FECHA</td>
</tr>
<?php

$i=1;

$power="SELECT 
DATE_FORMAT(hora_llamado,'%d-%m-%Y') AS fecha,
DATE_FORMAT(hora_llamado,'%H:%i:%S') AS hora_llamado,
DATE_FORMAT(hora_despacho,'%H:%i:%S') AS hora_despacho,
DATE_FORMAT(hora_salida_base,'%H:%i:%S') AS hora_salida_base,
DATE_FORMAT(hora_llegada_domicilio,'%H:%i:%S') AS hora_llegada_domicilio,
DATE_FORMAT(hora_sale_domicilio,'%H:%i:%S') AS hora_sale_domicilio,
DATE_FORMAT(hora_sale_destino,'%H:%i:%S') AS hora_sale_destino,
fichas.observacion,
operador.apellido AS apoperador,
operador.nombre1 AS nomoperador,
fichas.telefono,
fichas.celular,
fichas.correlativo,
fichas.num_solici,
DATE_FORMAT(hora_llega_destino,'%H:%i:%S') AS hora_llega_destino,
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
CentroHospitalario,
fichas.obser_man AS obs_man,
fichas.nro_doc

FROM fichas 
INNER JOIN color ON fichas.color=color.cod
INNER JOIN operador ON operador.rut = fichas.operador
INNER JOIN destino ON destino.cod=fichas.obser_man
INNER JOIN sector ON sector.cod=fichas.sector

WHERE fichas.estado=0  AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."' ".' '.$dia."  ORDER BY correlativo asc";


$resultados = mysql_query($power);
while ( $matriz_resultados = mysql_fetch_array($resultados) ){

$destino = $matriz_resultados['destino'];

$plann = 'AFILIADO';

if($matriz_resultados['tipo_plan'] == 'PA'){
$plann ='PARTICULAR';
}
if($matriz_resultados['tipo_plan'] == 'CA'){
$plann ='FAMILIAR DIRECTO';
}

if($matriz_resultados['tipo_plan'] == 'TRA_ME'){
$plann ='TRASLADO MEDICALIZADO CONVENIO';
$diagnostico = $plann;
}

if($matriz_resultados['tipo_plan'] == 'TRA_CONV'){
$plann ='TRASLADO SIMPLE CONVENIO';
$diagnostico = $plann;
}

if ( ($matriz_resultados['tipo_plan'] == '1') and ($matriz_resultados['color']=='Azul')){
$plann ='TRASLADO PROGRAMADO AFILIADOS DIRECTO';
$diagnostico = $plann;
}

if($matriz_resultados['tipo_plan'] == 'TRA_PAR'){
$plann ='TRASLADO SIMPLE DE PARTICULARES';
$diagnostico = $plann;
}




?>
<tr>
<td style="border:1px solid #000000"><? echo $i; $i = $i= $i+1;?></td>
<td style="border:1px solid #000000"><?php echo $matriz_resultados['correlativo']; ?></td>
<td style="border:1px solid #000000"><?php echo $matriz_resultados['nro_doc']; ?></td>

<?php 

$proto = $matriz_resultados['num_solici'];

if($matriz_resultados['tipo_plan'] == 'PA'){
$proto = 'Particular';
}


if ( ($matriz_resultados['tipo_plan'] == 'TRA_ME') || ($matriz_resultados['tipo_plan'] == 'TRA_CONV') || ( ($matriz_resultados['tipo_plan'] == '1') and ($matriz_resultados['color']=='Azul') ) ){

$consul="SELECT planes_traslados.desc_plan
FROM fichas 
INNER JOIN traslados ON traslados.cod=fichas.traslado 
INNER JOIN traslado_tipo ON traslado_tipo.cod=traslados.tipo_traslado
INNER JOIN planes_traslados ON planes_traslados.cod_plan = traslados.convenio  WHERE fichas.correlativo='".$matriz_resultados['correlativo']."'";
$resul_conn = mysql_query($consul);
$matriz_conn= mysql_fetch_array($resul_conn);
$proto=$matriz_conn['desc_plan'];
?>
<td style="border:1px solid #000000"><?php echo $matriz_conn['desc_plan']; ?></td>
<?php
}
else{
?>
<td style="border:1px solid #000000"><?php echo $proto; ?></td>
<?php
}
?>
<?php if( (strlen($matriz_resultados['telefono'])) >  (strlen($matriz_resultados['celular'])) ){
$fono = $matriz_resultados['telefono'];
}
else{
$fono = $matriz_resultados['celular'];
}
?>
<td style="border:1px solid #000000"><?php echo $fono; ?></td>
<td  style="border:1px solid #000000"><?php echo $matriz_resultados['paciente']; ?></td>
<td  style="border:1px solid #000000"><?php echo $matriz_resultados['edad']; ?></td>

<?php
$query_me ="
SELECT nombre1,apellidos FROM personal
INNER JOIN fichas ON personal.rut=fichas.medico where fichas.medico='".$matriz_resultados['medico']."'";
$resul_me = mysql_query($query_me);
$matriz_me= mysql_fetch_array($resul_me);
?>
<td  style="border:1px solid #000000"><?php echo strtoupper($matriz_me['nombre1']); ?>&nbsp;<?php echo strtoupper(substr($matriz_me['apellidos'],0,1)).'.'; ?></td>

<?php
$query_pa ="
SELECT nombre1,apellidos FROM personal
INNER JOIN fichas ON personal.rut=fichas.paramedico where fichas.paramedico='".$matriz_resultados['paramedico']."'";
$resul_pa = mysql_query($query_pa);
$matriz_pa= mysql_fetch_array($resul_pa);
?>
<td  style="border:1px solid #000000"><?php echo strtoupper($matriz_pa['nombre1']); ?>&nbsp;<?php echo strtoupper(substr($matriz_pa['apellidos'],0,1)).'.'; ?></td>

<td  style="border:1px solid #000000"><?php echo strtoupper($matriz_resultados['nomoperador']); ?>&nbsp;<?php echo strtoupper(substr($matriz_resultados['apoperador'],0,1)).'.'; ?></td>


<?php
if ($matriz_resultados['color'] !='Azul'){

$query_diag ="SELECT diagnostico.diagnostico,diagnostico.cod
FROM fichas 
INNER JOIN diagnostico ON CONVERT(diagnostico.cod USING utf8 )=CONVERT(fichas.diagnostico USING utf8 ) where correlativo ='".$matriz_resultados['correlativo']."'";
$resul_diag = mysql_query($query_diag);
$matriz_diag= mysql_fetch_array($resul_diag);

$num_diag=mysql_num_rows($resul_diag);

if ($num_diag < 1){
$matriz_diag['cod']=$diagnostico;
}
?>
<td  style="border:1px solid #000000"><?php echo $matriz_diag['cod']; ?><?php if($matriz_resultados['tipo_plan'] == 'CA'){echo "/ CARGA NO REGISTRADA";}?>
</td>
<?php
}
else{
	if ( ($matriz_resultados['tipo_plan'] == 'TRA_ME') || ($matriz_resultados['tipo_plan'] == 'TRA_CONV') || ( ($matriz_resultados['tipo_plan'] == '1') and ($matriz_resultados['color']=='Azul') ) ){

	$matriz_resultados['destino'] = $plann;
	}
?>
<td  style="border:1px solid #000000"><?php echo $plann; ?></td>
<?
}
?>
<td  style="border:1px solid #000000"><?php echo $destino ?> <?php
$query_centro ="SELECT centrohospita.Lugar
FROM 
fichas INNER JOIN centrohospita ON fichas.CentroHospitalario = centrohospita.cod
WHERE fichas.correlativo='".$matriz_resultados['correlativo']."'";

$resul_centro = mysql_query($query_centro);
$matriz_centro= mysql_fetch_array($resul_centro);

echo $matriz_centro['Lugar'];
?></td>

<td  style="border:1px solid #000000"><?php echo $matriz_resultados['hora_llamado']; ?></td>
<td  style="border:1px solid #000000"><?php echo $matriz_resultados['hora_llegada_domicilio']; ?></td>

<?php 
$hora_sale =  $matriz_resultados['hora_sale_domicilio'];
if($matriz_resultados['obs_man'] == '42'){
$hora_sale = $matriz_resultados['hora_sale_domicilio'];
}
?>
<td  style="border:1px solid #000000"><?php echo $hora_sale; ?></td>


<td  style="border:1px solid #000000"><?php echo $matriz_resultados['direccion']; ?></td>
<td  style="border:1px solid #000000"><?php echo $matriz_resultados['color']; ?></td>
<td  style="border:1px solid #000000"><?php echo $matriz_resultados['fecha']; ?></td>
<?php
}
?>
</tr>
</table>