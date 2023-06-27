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
$consulta = "select afiliados.nro_doc as nro_doc,nombre1,nombre2,apellido,mot_baja.descripcion as descripcion1,mot_baja.codigo,categoria.descripcion as descripcion2,tipo_plan.tipo_plan_desc,reducido, planes.desc_plan,titular,planes.cod_plan,obras_soc.nro_doc as isapre,num_solici
from afiliados
inner join mot_baja on afiliados.cod_baja = mot_baja.codigo
inner join categoria on afiliados.categoria = categoria.categoria
inner join tipo_plan on afiliados.tipo_plan = tipo_plan.tipo_plan
inner join obras_soc on afiliados.obra_numero = obras_soc.nro_doc
inner join planes on afiliados.cod_plan = planes.cod_plan and afiliados.tipo_plan = planes.tipo_plan
where afiliados.nro_doc ='".$_GET['rut']."'";

$resultados = mysql_query($consulta);
?>
<div style="font-size:12px;"  >
<?php
$matriz_resultados = mysql_fetch_array($resultados);
?>
<table class="celda1" style="width:480px; background:#FFF; color:#000" border="1">
<tr>
<td><?php echo 'Contrato: '.$matriz_resultados['num_solici']; ?></td>
<td><?php echo 'Rut: '.$matriz_resultados['nro_doc']; ?></td>
<td><?php echo 'Estado: '.$matriz_resultados['descripcion1'];?></td>
</tr>
</table>

<table class="celda1" style="width:480px; background:#FFF; color:#000" border="1">
<tr>
<td><?php echo 'Afiliado: '.$matriz_resultados['nombre1'].' '.$matriz_resultados['nombre2'].' '.$matriz_resultados['apellido']; ?></td>
</tr>
</table>

<table class="celda1" style="width:480px; background:#FFF; color:#000" border="1">

<tr>
<td><?php echo 'Categoria: '.$matriz_resultados['descripcion2']; ?></td>
<td><?php echo 'Plan: '.$matriz_resultados['tipo_plan_desc']; ?></td>
<td><?php echo 'Isapre: '.$matriz_resultados['reducido']; ?></td>
</tr>
</table>

<div align="right"><input type="button" value="Listado Atenciones" class="boton" onclick="$ajaxload('info', 'atenciones/buscar_rut?rut=<?php echo $_GET['rut']; ?>',false,false);" /></div>

</div>
</td>
</tr>
</table>

<div id="det">
<?php
$con2 = "SELECT num_solici, fichas.correlativo,
DATE_FORMAT(fichas.hora_llamado,'%T %d-%m-%Y') AS llamado,
DATE_FORMAT(fichas.hora_llegada_domicilio,'%T %d-%m-%Y') AS aten,
destino.destino
FROM fichas
INNER JOIN destino ON destino.cod=fichas.obser_man
 WHERE fichas.num_solici='".$matriz_resultados['num_solici']."' order by hora_llamado DESC";

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
