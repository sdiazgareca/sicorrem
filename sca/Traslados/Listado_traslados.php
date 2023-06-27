<?php
include('../conf.php');
include('../bd.php');
$consulta = "SELECT traslado_tipo.traslado, planes_traslados.desc_plan,fichas.paciente,DATE_FORMAT(traslados.fecha_traslado,'%d-%m-%Y %H:%i:%S') as fecha_traslado, traslados.cod AS cod
FROM fichas 
INNER JOIN traslados ON traslados.cod=fichas.traslado 
INNER JOIN traslado_tipo ON traslado_tipo.cod=traslados.tipo_traslado
INNER JOIN planes_traslados ON planes_traslados.cod_plan = traslados.convenio
WHERE fichas.estado=0 AND traslados.estado=0";

$resultados = mysql_query($consulta);
?>
<br />
<table style="width:480px">
<tr>
<td class="celda1">Convenio</td> 
<td class="celda1">Paciente</td> 
<td class="celda1">Tipo</td> 
<td class="celda1">Fecha Traslado</td> 
<td class="celda1">&nbsp;</td>
<?php
while ($matriz_resultados = mysql_fetch_array($resultados)){
?>
<tr>
<td class="celda3"><?php echo $matriz_resultados['desc_plan']; ?></td>
<td class="celda3"><?php echo $matriz_resultados['paciente']; ?></td>
<td class="celda3"><?php echo $matriz_resultados['traslado']; ?></td>
<td class="celda3"><?php echo $matriz_resultados['fecha_traslado']; ?></td>
<td class="celda3"><input type="button" value="Asignar Movil" class="boton" onclick="$ajaxload('traslado_s','Traslados/AsignarMovil_traslado.php?cod=<?php echo $matriz_resultados['cod']; ?>&operador=<?php echo $_GET['operador']; ?>',false,false,false);"></td>
</tr>
<?php
}
?>
</table>