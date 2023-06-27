<?php

set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=copago_resumen.xls"); 

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
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">&nbsp;</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">COBRADO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">PENDIENTE</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">TOTAL</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">A COBRAR</td>
</tr>
<?php

$power="SELECT personal.rut,personal.apellidos,personal.nombre1,COUNT(fichas.correlativo) as num, SUM(copago.importe) as suma FROM fichas
INNER JOIN personal ON fichas.paramedico = personal.rut
INNER JOIN copago ON fichas.correlativo = copago.protocolo
 WHERE fichas.cod_plan != 'w71' and YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." GROUP BY personal.nombre1";

$resultados = mysql_query($power);
while ( $matriz_resultados = mysql_fetch_array($resultados) ){
?>
<tr>
<td  style="border:1px solid #000000"><?php echo $matriz_resultados['nombre1'].' '.$matriz_resultados['apellidos']; ?></td>
<?php 
$query2 ="SELECT COUNT(fichas.correlativo) as fic FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND fichas.paramedico = '".$matriz_resultados['rut']."' and YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71'";
$resultados2 = mysql_query($query2);
$matriz_resultados2 = mysql_fetch_array($resultados2);
?>
<td style="border:1px solid #000000"><?php echo $matriz_resultados2['fic']; ?></td>
<?php 
$query3 ="SELECT COUNT(fichas.correlativo) as fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND fichas.paramedico = '".$matriz_resultados['rut']."' and YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71'";
$resultados3 = mysql_query($query3);
$matriz_resultados3 = mysql_fetch_array($resultados3);
?>
<td  style="border:1px solid #000000"><?php echo $matriz_resultados3['fic2']; ?></td>
<td  style="border:1px solid #000000"><?php echo $matriz_resultados['num']; ?></td>
<td  style="border:1px solid #000000"><?php echo ($matriz_resultados2['fic']*250); ?></td>
</tr>
<?php
}
?>
</table>

<br /><br />

<table style="font-size:10px; border:1px solid #000000;">
<tr>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">&nbsp;</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">COBRADO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">PENDIENTE</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">TOTAL</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">A COBRAR</td>
</tr>
<?php

$power="
SELECT operador.rut,operador.apellido,operador.nombre1,COUNT(fichas.correlativo) AS num, SUM(copago.importe) AS suma FROM fichas
INNER JOIN operador ON fichas.operador = operador.rut
INNER JOIN copago ON fichas.correlativo = copago.protocolo
WHERE fichas.cod_plan != 'w71' AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." 
GROUP BY operador.nombre1";

$resultados = mysql_query($power);
while ( $matriz_resultados = mysql_fetch_array($resultados) ){
?>
<tr>
<td  style="border:1px solid #000000"><?php echo $matriz_resultados['nombre1'].' '.$matriz_resultados['apellido']; ?></td>
<?php 
$query2 ="SELECT COUNT(fichas.correlativo) as fic FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND fichas.operador = '".$matriz_resultados['rut']."' and YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71'";
$resultados2 = mysql_query($query2);
$matriz_resultados2 = mysql_fetch_array($resultados2);
?>
<td style="border:1px solid #000000"><?php echo $matriz_resultados2['fic']; ?></td>
<?php 
$query3 ="SELECT COUNT(fichas.correlativo) as fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND fichas.operador = '".$matriz_resultados['rut']."' and YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71'";
$resultados3 = mysql_query($query3);
$matriz_resultados3 = mysql_fetch_array($resultados3);
?>
<td  style="border:1px solid #000000"><?php echo $matriz_resultados3['fic2']; ?></td>
<td  style="border:1px solid #000000"><?php echo $matriz_resultados['num']; ?></td>
<td  style="border:1px solid #000000"><?php echo ($matriz_resultados2['fic']*100); ?></td>
</tr>
<?php
}
?>
</table>


<br /><br />

<table style="font-size:10px; border:1px solid #000000;">
<tr>

<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">&nbsp;</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">IMPORTE</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">PENDIENTE</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">COBRADO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">TOTAL</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>84000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and importe > '70000'";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and importe > '70000'";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and importe > '70000'";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>
 
<tr>
<td>&nbsp;</td>
<td>70000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '60001' AND '70000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '60001' AND '70000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '60001' AND '70000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>60000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '52001' AND '60000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '52001' AND '60000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '52001' AND '60000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>52000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '40001' AND '52000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '40001' AND '52000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '40001' AND '52000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>40000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '34001' AND '40000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '34001' AND '40000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '34001' AND '40000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>34000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '30001' AND '34000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '30001' AND '34000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '30001' AND '34000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>32000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '28001' AND '32000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '28001' AND '32000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '28001' AND '32000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>30000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '28001' AND '30000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '28001' AND '30000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '28001' AND '30000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>28000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '25001' AND '28000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '25001' AND '28000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '25001' AND '28000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>25000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '20001' AND '25000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '20001' AND '25000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '20001' AND '25000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>20000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '16001' AND '20000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '16001' AND '20000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '16001' AND '20000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>16000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '14001' AND '16000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '14001' AND '16000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '14001' AND '16000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>14000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '12001' AND '14000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '12001' AND '14000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '12001' AND '14000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>12000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '11001' AND '12000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '11001' AND '12000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '11001' AND '12000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>


</tr>

<tr>
<td>&nbsp;</td>
<td>11000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '10001' AND '11000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '10001' AND '11000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '10001' AND '11000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>10000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '9501' AND '10000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '9501' AND '10000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '9501' AND '10000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>9500</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '9001' AND '9500')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '9001' AND '9500')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '9001' AND '9500')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>9000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '8001' AND '9000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '8001' AND '9000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '8001' AND '9000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>8000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '7501' AND '8000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '7501' AND '8000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '7501' AND '8000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>7500</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '7001' AND '7500')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '7001' AND '7500')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '7001' AND '7500')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>7000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '6001' AND '7000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '6001' AND '7000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '6001' AND '7000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>6000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '5001' AND '6000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '5001' AND '6000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '5001' AND '6000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>5000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '4001' AND '5000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '4001' AND '5000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '4001' AND '5000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>4000</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '3601' AND '4000')";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '3601' AND '4000')";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and (importe BETWEEN '3601' AND '4000')";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

<tr>
<td>&nbsp;</td>
<td>3600</td>
<?php 
$query_1 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and importe <= '3600'";

$resultados_1 = mysql_query($query_1);
$matriz_resultados_1 = mysql_fetch_array($resultados_1);
?>

<td><?php echo $matriz_resultados_1['fic2']; ?></td>

<?php 
$query_2 ="SELECT COUNT(fichas.correlativo) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
AND YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and importe <= '3600'";

$resultados_2 = mysql_query($query_2);
$matriz_resultados_2 = mysql_fetch_array($resultados_2);
?>

<td><?php echo $matriz_resultados_2['fic2']; ?></td>

<?php 
$query_3 ="SELECT SUM(copago.importe) AS fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71' and importe <= '3600'";

$resultados_3 = mysql_query($query_3);
$matriz_resultados_3 = mysql_fetch_array($resultados_3);
?>

<td><?php echo $matriz_resultados_3['fic2']; ?></td>

</tr>

</table>

<br /><br />

<table style="font-size:10px; border:1px solid #000000;">

<tr>
<td>&nbsp;</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">PENDIENTE</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">% PENDIENTE</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">COBRADO</td>
<td style="font-size:12px; border:1px solid #000000; background:#FFCC00; font-weight:bold;" class="celda1">% COBRADO</td>
</tr>

<?php
$query3 ="SELECT COUNT(fichas.correlativo) as fic2 FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3 || copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
and YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71'";
$resultados3 = mysql_query($query3);
$matriz_resultados3 = mysql_fetch_array($resultados3);

$total = $matriz_resultados3['fic2'];
?>

<tr>
<td>&nbsp;</td>

<?php
$query3 ="SELECT COUNT(fichas.correlativo) as fic2, SUM(importe) as importe FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=4 || copago.tipo_pago=3)
and YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71'";
$resultados3 = mysql_query($query3);
$matriz_resultados3 = mysql_fetch_array($resultados3);

$pendiente = $matriz_resultados3['fic2'];
$pendiente = $pendiente *100;
$pendiente = $pendiente / $total;
?>

<td><?php echo $matriz_resultados3['importe']; ?></td>
<td><?php echo number_format($pendiente,2);?></td>



<?php
$query3 ="SELECT COUNT(fichas.correlativo) as fic2, SUM(importe) as importe FROM copago 
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
WHERE (copago.tipo_pago=1 || copago.tipo_pago=2 || copago.tipo_pago =5)
and YEAR(hora_llamado)='".$anio."' AND MONTH(hora_llamado)='".$mes."'".' '.$dia." and fichas.cod_plan != 'w71'";
$resultados3 = mysql_query($query3);
$matriz_resultados3 = mysql_fetch_array($resultados3);

$cobrado = $matriz_resultados3['fic2'];
$cobrado = $cobrado *100;
$cobrado = $cobrado / $total;

?>
<td><?php echo $matriz_resultados3['importe']; ?></td>
<td><?php echo number_format($cobrado,2); ?></td>
</tr>


</table>