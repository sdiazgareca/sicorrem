<table class="celda2" style="width:90%;">
<tr>
<?php
include('../conf.php');
include('../bd.php');

$query = "SELECT planes.desc_plan,afiliados.nombre1,afiliados.apellido,afiliados.nro_doc,copago.numero_socio,copago.fecha,copago.protocolo, copago.tipo_pago, copago.importe, copago.boleta FROM copago INNER JOIN afiliados ON afiliados.num_solici = copago.numero_socio AND afiliados.num_solici = '".$_GET['ncontrato']."' AND copago.numero_socio ='".$_GET['ncontrato']."' AND afiliados.categoria =1 
INNER JOIN planes ON planes.cod_plan=afiliados.cod_plan AND planes.tipo_plan=afiliados.tipo_plan
GROUP BY afiliados.nro_doc";

$resultados = mysql_query($query);
while ($matriz_resultados = mysql_fetch_array($resultados)){
?>
<td style="color:#000000; font-size:12px;">Titular: <?php echo $matriz_resultados['nombre1']; ?>&nbsp;<?php echo $matriz_resultados['apellido']; ?></td>
<td style="color:#000000; font-size:12px;">Rut: <?php echo $matriz_resultados['nro_doc']; ?></td>
<td style="color:#000000; font-size:12px;">Contrato: <?php echo $matriz_resultados['numero_socio']; ?> </td>
<td style="color:#000000; font-size:12px;">Plan: <?php echo $matriz_resultados['desc_plan']; ?></td>
<?php
}
?>
</tr>
</table>

<table class="celda2" style="width:90%; border:1px solid #FFCC33; background-color:#FFCC33">

<tr class="celda2">
<td style="color:#000000; font-weight:bold; background-color:#FFCC33">Prot</td>
<td style="color:#000000; font-weight:bold; background-color:#FFCC33">Paciente</td>
<td style="color:#000000; font-weight:bold; background-color:#FFCC33">Fecha Llamado</td>
<td style="color:#000000; font-weight:bold; background-color:#FFCC33">N Boleta</td>
<td style="color:#000000; font-weight:bold; background-color:#FFCC33">Tipo de Pago</td>
<td style="color:#000000; font-weight:bold; background-color:#FFCC33">Importe</td>
</tr>

<?php
$query2="SELECT fichas.paciente,fichas.correlativo,DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') as hora_llamado,
copago.boleta,tipo_pago.tipo_pago,copago.importe
FROM copago INNER JOIN fichas ON copago.protocolo=fichas.correlativo
INNER JOIN tipo_pago ON copago.tipo_pago= tipo_pago.cod WHERE copago.numero_socio='".$_GET['ncontrato']."'";

$resultados2 = mysql_query($query2);
while ($matriz_resultados2 = mysql_fetch_array($resultados2)){
?>
<tr class="celda2" style="background-color:#FFFFFF">
<td style="background-color:#FFFFFF"><?php echo $matriz_resultados2['correlativo'];?></td>
<td style="background-color:#FFFFFF"><?php echo $matriz_resultados2['paciente'];?></td>
<td style="background-color:#FFFFFF"><?php echo $matriz_resultados2['hora_llamado'];?></td>
<td style="background-color:#FFFFFF"><?php echo $matriz_resultados2['boleta'];?></td>
<td style="background-color:#FFFFFF"><?php echo $matriz_resultados2['tipo_pago'];?></td>
<td style="background-color:#FFFFFF">$ <?php echo $matriz_resultados2['importe'];?></td>
</tr>
<?php
}
?>

</table>