<?php
set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');


header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=estadistica.xls");

include('../conf.php');
include('../bd.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>

</head>
<body>
<?php
$anio = $_GET['anio_estadistica'];
$mes = $_GET['mes_estadistica'];
$dia1 = $_GET['dia1'];
$dia2 = $_GET['dia2'];

if ($dia1 < 10){
$dia1 = '0'.$dia1;
}

if ($dia2 < 10){
$dia2 = '0'.$dia2;
}

if ($mes < 10){
$mes = '0'.$mes;
}

if( ($dia1  >0) and ($dia2 > 0) ){

$bet = "AND DAY(fichas.hora_llamado) BETWEEN '".$dia1."' AND '".$dia2."' AND";
$mensaje = "Periodo:&nbsp; ".$dia1."/".$mes."/".$anio." al ".$dia2."/".$mes."/".$anio."";
}
else{
$bet = "AND";

$diaq = "SELECT MAX(DAY(fichas.hora_llamado)) as dia FROM fichas
WHERE estado =0 AND MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."'";

$diaq_q = mysql_query($diaq);
$dii = mysql_fetch_array($diaq_q);
$mensaje = "Periodo:&nbsp; 1/".$mes."/".$anio." al ".$dii['dia']."/".$mes."/".$anio."";
}
?>
<div align="center" style="font-size:15px; font-weight:bold">RESUMEN DE LLAMADOS</div>
<?php echo $mensaje; ?>
<br />
<br />

<strong style="font-size:14px;">Resumen</strong>
<?php
$query ="SELECT COUNT(fichas.obser_man) as total,destino.destino
FROM fichas
INNER JOIN destino ON destino.cod=fichas.obser_man
WHERE estado =0 ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND YEAR(fichas.hora_llamado)='".$anio."'
GROUP BY fichas.obser_man";

//echo "<br />".$query."<br />";

$query_q = mysql_query($query);
?>
<table border="1">
<?php
while ( $mat = mysql_fetch_array($query_q)){
?>
<tr>
<td><?php echo $mat['destino']; ?></td>
<td><?php echo $mat['total'];?></td>
</tr>
<?php
}
?>
</table>


<br />
<strong style="font-size:14px;">Resumen C&oacute;digos de Llamados</strong>

<table>
<tr>
<td>
<table  border="1">
<tr>
<td>
Atenciones Realizadas</td>
<td>
<?php
$consulta1 = "SELECT COUNT(fichas.color) as total,color.color
FROM fichas
INNER JOIN color ON color.cod = fichas.color
WHERE estado =0 ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND YEAR(fichas.hora_llamado)='".$anio."'
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
GROUP BY color";

$consulta_q1 = mysql_query($consulta1);

while ( $matriz_resultados1 = mysql_fetch_array($consulta_q1) ){
?>
<table border="1" style="font-size:10px">
<tr>
<td><?php echo $matriz_resultados1['color']; ?></td>
<td><?php echo $matriz_resultados1['total']; ?></td>
</tr>
</table>
<?php
}
?>
</td>
</tr>
</table>

</td>
</tr>
</table>


<table>
<tr>
<td>
<table  border="1">
<tr>
<td>Anulados</td>
<td>
<?php
$consulta2 = "SELECT COUNT(fichas.color) as total,color.color
FROM fichas
INNER JOIN color ON color.cod = fichas.color
WHERE estado =0 ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND YEAR(fichas.hora_llamado)='".$anio."'
AND (fichas.obser_man='7' ||fichas.obser_man='9' || fichas.obser_man='10' || fichas.obser_man='13' || fichas.obser_man='14' || fichas.obser_man='15' || fichas.obser_man='16' || fichas.obser_man='26' || fichas.obser_man='27' || fichas.obser_man='39' || fichas.obser_man='40' || fichas.obser_man='46' || fichas.obser_man='17')
GROUP BY color";

$consulta_q2 = mysql_query($consulta2);

while ( $matriz_resultados2 = mysql_fetch_array($consulta_q2) ){
?>
<table border="1" style="font-size:10px">
<tr>
<td><?php echo $matriz_resultados2['color']; ?></td>
<td><?php echo $matriz_resultados2['total']; ?></td>
</tr>
</table>
<?php
}
?>
</td>
</tr>
</table>
</td>
</tr>
</table>

<table>
<tr>
<td>
<table  border="1">
<tr>
<td>Total de Llamados</td>
<td>
<?php
$consulta3 = "SELECT COUNT(fichas.color) as total,color.color
FROM fichas
INNER JOIN color ON color.cod = fichas.color
WHERE estado =0 ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND YEAR(fichas.hora_llamado)='".$anio."'
GROUP BY color";

$consulta_q3 = mysql_query($consulta3);

while ( $matriz_resultados3 = mysql_fetch_array($consulta_q3) ){
?>
<table border="1" style="font-size:10px">
<tr>
<td><?php echo $matriz_resultados3['color']; ?></td>
<td><?php echo $matriz_resultados3['total']; ?></td>
</tr>
</table>
<?php
}
?>
</td>
</tr>
</table>
</td>
</tr>
</table>

<br />

<strong style="font-size:14px;">Resumen  de Atenci&oacute;n por Sectores</strong>


<table  border="1">
<tr>
<td>Atenciones Realizadas</td>
<td>
<?php

/*
 * $consulta3 = "SELECT COUNT(fichas.color) as total,color.color
FROM fichas
INNER JOIN color ON color.cod = fichas.color
WHERE estado =0 ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND YEAR(fichas.hora_llamado)='".$anio."'
GROUP BY color";
 */


$consulta4 = "SELECT COUNT(fichas.sector) as total, sector.sector as sector
FROM fichas
INNER JOIN sector ON sector.cod = fichas.sector
WHERE estado =0 ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND YEAR(fichas.hora_llamado)='".$anio."'
AND (fichas.obser_man='24' ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
GROUP BY sector";

$consulta_q4 = mysql_query($consulta4);

while ( $matriz_resultados4 = mysql_fetch_array($consulta_q4) ){
?>
<table border="1" style="font-size:10px">
<tr>
<td><?php echo $matriz_resultados4['sector']; ?></td>
<td><?php echo $matriz_resultados4['total']; ?></td>
</tr>
</table>
<?php
}
?>
</td>
</tr>
</table>


<table  border="1">
<tr>
<td>

<table  border="1">
<tr>
<td style="background-color:#DBEEF3">Anulados
</td>

<td>
<?php
$consulta5 = "SELECT COUNT(fichas.sector) as total5, sector.sector as sec
FROM fichas
INNER JOIN sector ON sector.cod = fichas.sector
WHERE estado =0 ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND YEAR(fichas.hora_llamado)='".$anio."'
AND (fichas.obser_man='7' ||fichas.obser_man='9' || fichas.obser_man='10' || fichas.obser_man='13' || fichas.obser_man='14' || fichas.obser_man='15' || fichas.obser_man='16' || fichas.obser_man='26' || fichas.obser_man='27' || fichas.obser_man='39' || fichas.obser_man='40' || fichas.obser_man='46' || fichas.obser_man='17')
GROUP BY fichas.sector";

$consulta_q5 = mysql_query($consulta5);

while ( $matriz_resultados5 = mysql_fetch_array($consulta_q5) ){
?>
<table border="1" style="font-size:12px;">
<tr>
<td><?php echo $matriz_resultados5['sec']; ?></td>
<td><?php echo $matriz_resultados5['total5']; ?></td>
</tr>
</table>
<?php
}
?>
</td>
</tr>
</table>
</td>
</tr>
</table>

<table>

<tr>
<td>
<table border="1">
<tr>
<td>Total de Llamados</td>

<td>
<?php
$consulta = "SELECT COUNT(fichas.sector) as total, sector.sector as sector
FROM fichas
INNER JOIN sector ON sector.cod = fichas.sector
WHERE estado =0 ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND YEAR(fichas.hora_llamado)='".$anio."'
GROUP BY fichas.sector";

$consulta_q = mysql_query($consulta);

while ( $matriz_resultados = mysql_fetch_array($consulta_q) ){
?>
<table border="1" style="font-size:12px">
<tr>
<td><?php echo $matriz_resultados['sector']; ?></td>
<td><?php echo $matriz_resultados['total']; ?></td>
</tr>
</table>
<?php
}
?>
</td>
</tr>
</table>
</td>
</tr>
</table>

<br />

<strong style="font-size:14px;">Resumen por Planes (Atenciones Realizadas)</strong>


<table>

<tr>
<td>


<?php
$consulta = "SELECT COUNT(fichas.cod_plan) AS total, planes.desc_plan AS plan
FROM fichas
INNER JOIN planes ON planes.cod_plan = fichas.cod_plan AND fichas.tipo_plan = planes.tipo_plan
WHERE fichas.estado =0 ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND YEAR(fichas.hora_llamado)='".$anio."'
AND (fichas.obser_man='24' ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6') AND fichas.color !='4'
GROUP BY fichas.cod_plan, fichas.tipo_plan";



$consulta_q = mysql_query($consulta);
?>
<table border="1" style="font-size:12px">
<?
while ( $matriz_resultados = mysql_fetch_array($consulta_q) ){
?>
<tr>
<td align="left"><?php echo $matriz_resultados['plan']; ?></td>
<td align="right"><?php echo $matriz_resultados['total']; ?></td>
</tr>
<?php
}

$consu ="SELECT COUNT(fichas.cod_plan) as total, cod_plan
FROM fichas
WHERE estado =0 AND MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND
(fichas.obser_man='24' ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6') AND
 fichas.color !='4' AND (fichas.cod_plan='CA' || fichas.cod_plan ='PA')
 GROUP BY fichas.cod_plan ";


$consu_q = mysql_query($consu);
while ( $matriz_resultados_consu = mysql_fetch_array($consu_q) ){
?>
<tr>

<td align="left">
<?php
if ($matriz_resultados_consu['cod_plan'] == 'CA'){
$PL = 'CARGA NO REGISTRATADA AFILIADO';
}
if ($matriz_resultados_consu['cod_plan'] == 'PA'){
$PL = 'PARTICULAR';
}
echo $PL;
?>
</td>

<td align="right"><?php echo $matriz_resultados_consu['total']; ?></td>
</tr>
<?php
}
?>

</table>
</td>
</tr>
</table>

<br />




<strong style="font-size:14px;">Resumen de Llamados por Traslados (Atenciones Realizadas)</strong>
<table>

<tr>
<td>

<?php
$consulta = "SELECT COUNT(traslados.convenio) as total, planes_traslados.desc_plan as tras
FROM fichas
INNER JOIN traslados ON traslados.cod = fichas.traslado
INNER JOIN traslado_tipo ON traslado_tipo.cod = traslados.tipo_traslado
INNER JOIN planes_traslados ON planes_traslados.cod_plan = traslados.convenio
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND
 (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
GROUP BY traslados.convenio";

$consulta_q = mysql_query($consulta);
?>
<table border="1" style="font-size:12px">
<?
while ( $matriz_resultados = mysql_fetch_array($consulta_q) ){
?>
<tr>
<td align="left"><?php echo strtoupper($matriz_resultados['tras']); ?></td>
<td align="right"><?php echo strtoupper($matriz_resultados['total']); ?></td>
</tr>
<?php
}
?>
</table>
</td>
</tr>
</table>

<br />


<strong style="font-size:14px;">Resumen de Llamados por Médico (Atenciones Realizadas)</strong>
<table>

<tr>
<td>

<?php
$consulta = "SELECT COUNT(fichas.medico) AS total, personal.nombre1, personal.apellidos FROM fichas
INNER JOIN personal ON personal.rut = fichas.medico
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND
 (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
 GROUP BY medico";

$consulta_q = mysql_query($consulta);
?>
<table border="1" style="font-size:12px">
<?
while ( $matriz_resultados = mysql_fetch_array($consulta_q) ){
?>
<tr>
<td align="left"><?php echo $matriz_resultados['nombre1']; ?>&nbsp;<?php echo $matriz_resultados['apellidos']; ?></td>
<td align="right"><?php echo $matriz_resultados['total']; ?></td>
</tr>
<?php
}
?>
</table>
</td>
</tr>
</table>

<br />
<strong>Resumen de Llamados por Medico y Codigo Convenio Medimel (Atenciones Realizadas)</strong>
<table>

<tr>
<td>

<?php
$consulta = "SELECT COUNT(fichas.medico) AS total, personal.nombre1, personal.apellidos, fichas.medico FROM fichas
INNER JOIN personal ON personal.rut = fichas.medico
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND
 (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
 AND (fichas.cod_plan='W71' AND fichas.tipo_plan = '2')  GROUP BY medico";

//echo $consulta;

$consulta_q = mysql_query($consulta);
?>
<table border="1" style="font-size:12px">

<tr>
<td><strong>Medico</strong></td>
<td><strong>Total</strong></td>
<td><strong>Rojo</strong></td>
<td><strong>Amarillo</strong></td>
<td><strong>Verde</strong></td>
<td><strong>Azul</strong></td>
</tr>
<?
while ( $matriz_resultados = mysql_fetch_array($consulta_q) ){
?>
<tr>
<td align="left"><?php echo $matriz_resultados['nombre1']; ?>&nbsp;<?php echo $matriz_resultados['apellidos']; ?></td>
<td align="right"><?php echo $matriz_resultados['total']; ?></td>
<td>
<?php
$query2 ="SELECT COUNT(fichas.color) AS total,color.color
FROM fichas
INNER JOIN color ON color.cod = fichas.color
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
     AND (fichas.cod_plan='W71' AND fichas.tipo_plan = '2') AND color.cod=1 AND fichas.medico= '".$matriz_resultados['medico']."'
GROUP BY color";


$consulta_q2 = mysql_query($query2);
$matriz_resultados2 = mysql_fetch_array($consulta_q2);
echo $matriz_resultados2['total'];
?>

</td>
<td>

<?php
$query2 ="SELECT COUNT(fichas.color) AS total,color.color
FROM fichas
INNER JOIN color ON color.cod = fichas.color
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
    AND (fichas.cod_plan='W71' AND fichas.tipo_plan = '2') AND color.cod=2 AND fichas.medico= '".$matriz_resultados['medico']."'
GROUP BY color";
$consulta_q2 = mysql_query($query2);
$matriz_resultados2 = mysql_fetch_array($consulta_q2);
echo $matriz_resultados2['total'];
?>

</td>

<td>

<?php
$query2 ="SELECT COUNT(fichas.color) AS total,color.color
FROM fichas

INNER JOIN color ON color.cod = fichas.color
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND(fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
 AND (fichas.cod_plan='W71' AND fichas.tipo_plan = '2') AND color.cod=3 AND fichas.medico= '".$matriz_resultados['medico']."'
GROUP BY color";
$consulta_q2 = mysql_query($query2);
$matriz_resultados2 = mysql_fetch_array($consulta_q2);
echo $matriz_resultados2['total'];
?>
</td>

<td>

<?php
$query3 ="SELECT COUNT(fichas.color) AS total,color.color
FROM fichas

INNER JOIN color ON color.cod = fichas.color
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND(fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
 AND (fichas.cod_plan='W71' AND fichas.tipo_plan = '2') AND color.cod=4 AND fichas.medico= '".$matriz_resultados['medico']."'
GROUP BY color";


$consulta_q6 = mysql_query($query3);
$matriz_resultados6 = mysql_fetch_array($consulta_q6);
echo $matriz_resultados6['total'];
?>

</td>

</tr>
<?php
}
?>
</table>
</td>
</tr>
</table>



<br />
<strong>Resumen de Llamados por Médico REMM (Atenciones Realizadas)</strong>
<table>

<tr>
<td>

<?php
$consulta = "SELECT COUNT(fichas.medico) AS total, personal.nombre1, personal.apellidos, fichas.medico FROM fichas
INNER JOIN personal ON personal.rut = fichas.medico
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."'  AND fichas.cod_plan!='W71' AND fichas.tipo_plan!=2
AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6') GROUP BY medico";

$consulta_q = mysql_query($consulta);
?>
<table border="1" style="font-size:12px">
<tr>
<td><strong>Medico</strong></td>
<td><strong>Total</strong></td>
<td><strong>Rojo</strong></td>
<td><strong>Amarillo</strong></td>
<td><strong>Verde</strong></td>
<td><strong>Azul</strong></td>
</tr>
<?
while ( $matriz_resultados = mysql_fetch_array($consulta_q) ){
?>
<tr>
<td align="left"><?php echo $matriz_resultados['nombre1']; ?>&nbsp;<?php echo $matriz_resultados['apellidos']; ?></td>
<td align="right"><?php echo $matriz_resultados['total']; ?></td>



<td>
<?php
$query2 ="SELECT COUNT(fichas.color) AS total,color.color
FROM fichas
INNER JOIN color ON color.cod = fichas.color
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
    AND (fichas.cod_plan!='W71' AND fichas.tipo_plan != '2') AND color.cod= 1 AND fichas.medico= '".$matriz_resultados['medico']."'
GROUP BY color";
$consulta_q2 = mysql_query($query2);
$matriz_resultados2 = mysql_fetch_array($consulta_q2);
echo $matriz_resultados2['total'];
?>

</td>
<td>

<?php
$query2 ="SELECT COUNT(fichas.color) AS total,color.color
FROM fichas
INNER JOIN color ON color.cod = fichas.color
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
    AND (fichas.cod_plan!='W71' AND fichas.tipo_plan != '2') AND color.cod=2 AND fichas.medico= '".$matriz_resultados['medico']."'
GROUP BY color";
$consulta_q2 = mysql_query($query2);
$matriz_resultados2 = mysql_fetch_array($consulta_q2);
echo $matriz_resultados2['total'];
?>

</td>

<td>

<?php
$query2 ="SELECT COUNT(fichas.color) AS total,color.color
FROM fichas

INNER JOIN color ON color.cod = fichas.color
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND(fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
    AND (fichas.cod_plan!='W71' AND fichas.tipo_plan != '2') AND color.cod=3 AND fichas.medico= '".$matriz_resultados['medico']."'
GROUP BY color";
$consulta_q2 = mysql_query($query2);
$matriz_resultados2 = mysql_fetch_array($consulta_q2);
echo $matriz_resultados2['total'];
?>
</td>

<td>

<?php
$query2 ="SELECT COUNT(fichas.color) AS total,color.color
FROM fichas
INNER JOIN color ON color.cod = fichas.color
WHERE  fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' and (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
    AND (fichas.cod_plan!='W71' AND fichas.tipo_plan != '2') AND color.cod=4 AND fichas.medico= '".$matriz_resultados['medico']."'
GROUP BY color";
$consulta_q2 = mysql_query($query2);
$matriz_resultados2 = mysql_fetch_array($consulta_q2);
echo $matriz_resultados2['total'];
?>

</td>




</tr>

<?php
}
?>
</table>
</td>
</tr>
</table>



<br />


<strong style="font-size:14px;">Resumen de Llamados por Diagnostico (Atenciones Realizadas)</strong>
<table>

<tr>
<td>

<?php
$consulta = "SELECT COUNT(fichas.diagnostico) as total, diagnostico.diagnostico as diag
FROM fichas
INNER JOIN diagnostico ON diagnostico.cod = fichas.diagnostico
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND
 (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
 GROUP BY fichas.diagnostico";

$consulta_q = mysql_query($consulta);
?>
<table border="1" style="font-size:12px">
<?
while ( $matriz_resultados = mysql_fetch_array($consulta_q) ){
?>
<tr>
<td align="left"><?php echo strtoupper($matriz_resultados['diag']); ?>&nbsp;<?php echo $matriz_resultados['apellidos']; ?></td>
<td align="right"><?php echo $matriz_resultados['total']; ?></td>
</tr>
<?php
}
?>
</table>
</td>
</tr>
</table>

<br />

<strong style="font-size:14px;">Resumen de Llamados por Sintoma (Atenciones Realizadas)</strong>
<table>

<tr>
<td>

<?php
$consulta = "SELECT COUNT(sintomas.cod) as total,sintomas.sintoma as sint
FROM fichas
INNER JOIN sintomas_reg ON sintomas_reg.correlativo= fichas.correlativo
INNER JOIN sintomas ON sintomas_reg.sintoma = sintomas.cod
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND
 (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6')
 GROUP BY sintomas.cod";

$consulta_q = mysql_query($consulta);
?>
<table border="1" style="font-size:12px;">
<?
while ( $matriz_resultados = mysql_fetch_array($consulta_q) ){
?>
<tr>
<td align="left"><?php echo strtoupper($matriz_resultados['sint']); ?></td>
<td align="right"><?php echo $matriz_resultados['total']; ?></td>
</tr>
<?php
}
?>
</table>
</td>
</tr>
</table>







<br />
<strong style="font-size:14px;">Tiempos de Respuesta</strong>
<table border="1" style="font-size:12px;">
<?php
/*TIEMPOS DE RESPUESTA **********************************************************************************************************/

$hh = "SELECT COUNT(TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado)) AS t_respuesta,
    cod_plan, tipo_plan
FROM fichas
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND
 (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6') AND
 TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado) > '02:00:00' AND cod_plan != 'W71' && tipo_plan !='2'";

//echo $hh;

$cc = mysql_query($hh);
$TRM2REMM = mysql_fetch_array($cc);
?>
<tr>
<td><strong>Mayores a las 2 horas REMM</strong></td><td><?php echo $TRM2REMM['t_respuesta']; ?></td>
</tr>
<?php
$hh2 = "SELECT COUNT(TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado)) AS t_respuesta,
    cod_plan, tipo_plan
FROM fichas
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND
 (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6') AND
 TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado) < '02:00:00' AND cod_plan !='W71' && tipo_plan !='2'";
//echo $hh2;
$cc2 = mysql_query($hh2);
$TRM2REMM_M = mysql_fetch_array($cc2);
?>
<tr>
<td><strong>Menores a las 2 horas REMM</strong><td><?php echo $TRM2REMM_M['t_respuesta']; ?></td>
</tr>
<?php
$hh3 = "SELECT COUNT(TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado)) AS t_respuesta,
    cod_plan, tipo_plan
FROM fichas
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND
 (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6') AND
 TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado) > '02:00:00' AND cod_plan ='W71' && tipo_plan ='2'";
//echo $hh3;
$cc3 = mysql_query($hh3);
$TRM2REMM_MED = mysql_fetch_array($cc3);
?>
<tr>
<td><strong>Mayores a las 2 horas MEDIMEL</strong><td><?php echo $TRM2REMM_MED['t_respuesta']; ?></td>
</tr>

<?php
$hh4 = "SELECT COUNT(TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado)) AS t_respuesta,
    cod_plan, tipo_plan
FROM fichas
WHERE fichas.estado =0  ".$bet." MONTH(fichas.hora_llamado)='".$mes."' AND
YEAR(fichas.hora_llamado)='".$anio."' AND
 (fichas.obser_man=24 ||fichas.obser_man='42' || fichas.obser_man='45' || fichas.obser_man='6') AND
 TIMEDIFF(fichas.hora_llegada_domicilio,fichas.hora_llamado) < '02:00:00' AND cod_plan ='W71' && tipo_plan ='2'";

//echo $hh4;

$cc4 = mysql_query($hh4);
$TRM2REMM_MED_2 = mysql_fetch_array($cc4);
?>
<tr>
<td><strong>Menores a las 2 horas MEDIMEL</strong><td><?php echo $TRM2REMM_MED_2['t_respuesta']; ?></td>
</tr>

</table>







</body>
</html>
<?php
mysql_close($conexion);
?>
