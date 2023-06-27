<?php
include('../conf.php');
include('../bd.php');
?>
<div class="formulario">
<form method="get" name="form1">
<table>
<tr>
<td class="celda1">DETALLE PACIENTE</td>
</tr>
</table>

<table>
<tr>
<td class="celda2">

<?php

$consulta = "SELECT num_solici, fichas.correlativo, 
DATE_FORMAT(fichas.hora_llamado,'%T %d-%m-%Y') AS llamado, 
DATE_FORMAT(fichas.hora_llegada_domicilio,'%T %d-%m-%Y') AS aten, destino.destino 
FROM fichas 
INNER JOIN destino ON destino.cod=fichas.obser_man 
INNER JOIN traslados ON fichas.traslado = traslados.cod
INNER JOIN traslado_tipo ON traslados.tipo_traslado = traslado_tipo.cod
INNER JOIN planes_traslados ON planes_traslados.cod_plan = traslados.convenio
WHERE planes_traslados.cod_plan ='".$_GET['convenio']."' 
ORDER BY hora_llamado DESC";

$resultados = mysql_query($consulta);

?>
<div style="font-size:12px;"  >
<?php
$matriz_resultados = mysql_fetch_array($resultados);
?>

<table class="celda1" style="width:480px; background:#FFF; color:#000" border="1">
<tr>
<td><?php echo 'Convenio: '.$matriz_resultados['desc_plan']; ?></td>
</tr>
</table>

<div align="right"><input type="button" value="Listado Atenciones" class="boton" onclick="$ajaxload('info', 'atenciones/buscar_convenio?convenio=<?php echo $_GET['convenio']; ?>',false,false);" /></div>

</div>
</td>
</tr>
</table>

<div id="det">
<?php
$con2 = "SELECT num_solici, fichas.correlativo, 
DATE_FORMAT(fichas.hora_llamado,'%T %d-%m-%Y') AS llamado, 
DATE_FORMAT(fichas.hora_llegada_domicilio,'%T %d-%m-%Y') AS aten, destino.destino 
FROM fichas 
INNER JOIN destino ON destino.cod=fichas.obser_man 
INNER JOIN traslados ON fichas.traslado = traslados.cod
INNER JOIN traslado_tipo ON traslados.tipo_traslado = traslado_tipo.cod
INNER JOIN planes_traslados ON planes_traslados.cod_plan = traslados.convenio
WHERE planes_traslados.cod_plan ='".$_GET['convenio']."' 
ORDER BY hora_llamado DESC";

$resultados2 = mysql_query($con2);
$num1 = mysql_num_rows($resultados2);

if ($num1 < 1){
echo '<table width="500px" align="center"><tr><td  class="celda4">';
echo 'No registra Atenciones';
echo '</td></tr></table>';
exit;
}


?>
<table style="background-color:#FFF; width:500px;" border="1">

<tr style="background-color:#A6B7AF; color:#FFF; font-weight:bold; font-size:10px;">
<td style="background-color:#A6B7AF">PROTO</td>
<td style="background-color:#A6B7AF" >FECHA LLAM</td>
<td style="background-color:#A6B7AF">FECHA ATEN</td>
<td style="background-color:#A6B7AF">&nbsp;</td>
<td style="background-color:#A6B7AF">&nbsp;</td>
</tr>

<?php
while($matriz_resultados2 = mysql_fetch_array($resultados2)){
	?>
    <tr style="font-size:11px;">
    <td><?php echo $matriz_resultados2['correlativo']; ?></td>
    <td><?php echo $matriz_resultados2['llamado']; ?></td>
    <td><?php echo $matriz_resultados2['aten']; ?></td>    
    <td><?php echo $matriz_resultados2['destino']; ?></td>
	<td><input type="button" value="Ver" class="boton" onclick="$ajaxload('det', 'atenciones/natenciones2.php?protocolo=<?php echo $matriz_resultados2['correlativo']; ?>',false,false,false);" /></td>
    </tr>
    <?php
}
?>
</table>
</div>
</form>
</div>