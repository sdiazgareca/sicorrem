<?php

set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=copago.xls"); 


include('../conf.php');
include('../bd.php');

$mes =$_GET['mes_manten'];
$anio =$_GET['anio_manten'];
$dia1 = $_GET['copagodia1'];
$dia2 = $_GET['copagodia2'];


$dia ="";

if ( ($dia1 > 0) and ($dia2 > 0) ){
$dia = "and DAY(hora_llamado) BETWEEN '".$dia1."' AND '".$dia2." '";
}

?>
<table style="font-size:10px; border:1px solid #000000;">
<tr>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">N&deg;</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">FECHA</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">PROTOCOLO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">SOCIO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">BOLETA</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">IMPORTE</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">PARAMEDICO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">OPERADOR</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">DCTO.</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">CONVENIO</td>
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

copago.boleta,
copago.importe,
tipo_pago.tipo_pago,
planes.desc_plan

FROM fichas 
LEFT JOIN color ON fichas.color=color.cod
LEFT JOIN operador ON operador.rut = fichas.operador
LEFT JOIN destino ON destino.cod=fichas.obser_man
LEFT JOIN copago ON fichas.correlativo = copago.protocolo
LEFT JOIN tipo_pago ON tipo_pago.cod = copago.tipo_pago
LEFT JOIN planes ON fichas.cod_plan = planes.cod_plan AND fichas.tipo_plan=planes.tipo_plan 
LEFT JOIN sector ON sector.cod=fichas.sector
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia."  
ORDER BY correlativo asc";


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
<td  style="border:1px solid #000000"><?php echo $matriz_resultados['fecha']; ?></td>
<td style="border:1px solid #000000"><?php echo $matriz_resultados['correlativo']; ?></td>

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

<td  style="border:1px solid #000000"><?php echo $matriz_resultados['boleta']; ?></td>
<td  style="border:1px solid #000000">$ <?php echo $matriz_resultados['importe']; ?></td>

<?php
$query_pa ="
SELECT nombre1,apellidos FROM personal
INNER JOIN fichas ON personal.rut=fichas.paramedico where fichas.paramedico='".$matriz_resultados['paramedico']."'";
$resul_pa = mysql_query($query_pa);
$matriz_pa= mysql_fetch_array($resul_pa);
?>
<td  style="border:1px solid #000000"><?php echo strtoupper($matriz_pa['nombre1']); ?>&nbsp;<?php echo strtoupper(substr($matriz_pa['apellidos'],0,1)).'.'; ?></td>

<td  style="border:1px solid #000000"><?php echo strtoupper($matriz_resultados['nomoperador']); ?>&nbsp;<?php echo strtoupper(substr($matriz_resultados['apoperador'],0,1)).'.'; ?></td>

<td  style="border:1px solid #000000"><?php echo $matriz_resultados['tipo_pago']; ?></td>


<td  style="border:1px solid #000000"><?php echo $matriz_resultados['desc_plan']; ?></td>

<?php
}
?>
</tr>
</table>
