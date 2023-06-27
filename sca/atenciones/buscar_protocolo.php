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
$consulta = "
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
CentroHospitalario,
fichas.nro_doc,
fichas.traslado

FROM fichas
INNER JOIN color ON fichas.color=color.cod
INNER JOIN operador ON operador.rut = fichas.operador
INNER JOIN destino ON destino.cod=fichas.obser_man
INNER JOIN sector ON sector.cod=fichas.sector
where fichas.correlativo ='".$_GET['protocolo']."'";

$resultados = mysql_query($consulta);
?>
<div style="font-size:12px;"  >
<?php
$matriz_resultados = mysql_fetch_array($resultados);


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

<?php
if ($plann == 'PARTICULAR'){
?>
<table class="celda1" style="width:480px; background:#FFF; color:#000" border="1">
<tr>
<td><?php echo $plann; ?></td>
</tr>

<tr>
<td>Paciente: <?php echo $matriz_resultados['paciente']; ?></td>
</tr>
</table>
<?php
}
?>

<?php
if (($plann == 'TRASLADO MEDICALIZADO CONVENIO') || ($plann == 'TRASLADO SIMPLE CONVENIO')){

$tras ="SELECT traslado_tipo.traslado, planes_traslados.desc_plan, planes_traslados.cod_plan
FROM traslados
INNER JOIN traslado_tipo ON traslados.tipo_traslado = traslado_tipo.cod
INNER JOIN planes_traslados ON planes_traslados.cod_plan = traslados.convenio
WHERE traslados.cod = '".$matriz_resultados['traslado']."'";

$tras_query = mysql_query($tras);
$datos_tras = mysql_fetch_array($tras_query);
?>
<table class="celda1" style="width:480px; background:#FFF; color:#000" border="1">
<tr>
<td><?php echo $datos_tras['traslado']; ?></td>
</tr>

<tr>
<td>Convenio: <?php echo $datos_tras['desc_plan']; ?></td>
</tr>
</table>

<div align="right"><input type="button" value="Listado Atenciones" class="boton" onclick="$ajaxload('info', 'atenciones/buscar_convenio?convenio=<?php echo $datos_tras['cod_plan']; ?>',false,false);" /></div>

<?php
}
?>

<?php
if  (($plann == 'AFILIADO') || ($plann == 'FAMILIAR DIRECTO') || ($plann == 'TRASLADO SIMPLE DE PARTICULARES')){

	$afil ="SELECT afiliados.nro_doc AS nro_doc,nombre1,nombre2,apellido,mot_baja.descripcion AS descripcion1,mot_baja.codigo,categoria.descripcion AS descripcion2,tipo_plan.tipo_plan_desc,reducido, planes.desc_plan,titular,planes.cod_plan,obras_soc.nro_doc AS isapre,num_solici
FROM afiliados
INNER JOIN mot_baja ON afiliados.cod_baja = mot_baja.codigo
INNER JOIN categoria ON afiliados.categoria = categoria.categoria
INNER JOIN tipo_plan ON afiliados.tipo_plan = tipo_plan.tipo_plan
INNER JOIN obras_soc ON afiliados.obra_numero = obras_soc.nro_doc
INNER JOIN planes ON afiliados.cod_plan = planes.cod_plan AND afiliados.tipo_plan = planes.tipo_plan
WHERE afiliados.nro_doc = '".$matriz_resultados['nro_doc']."'";

$afil_query = mysql_query($afil);
$datos_afil = mysql_fetch_array($afil_query);
echo $plann;
?>


<table class="celda1" style="width:480px; background:#FFF; color:#000" border="1">
<tr>
<td><?php echo 'Contrato: '.$datos_afil['num_solici']; ?></td>
<td><?php echo 'Rut: '.$datos_afil['nro_doc']; ?></td>
<td><?php echo 'Estado: '.$datos_afil['descripcion1'];?></td>
</tr>
</table>

<table class="celda1" style="width:480px; background:#FFF; color:#000" border="1">
<tr>
<td><?php echo 'Afiliado: '.$datos_afil['nombre1'].' '.$datos_afil['nombre2'].' '.$datos_afil['apellido']; ?></td>
</tr>
</table>

<table class="celda1" style="width:480px; background:#FFF; color:#000" border="1">

<tr>
<td><?php echo 'Categoria: '.$datos_afil['descripcion2']; ?></td>
<td><?php echo 'Plan: '.$datos_afil['tipo_plan_desc']; ?></td>
<td><?php echo 'Isapre: '.$datos_afil['reducido']; ?></td>
</tr>
</table>

<div align="right"><input type="button" value="Listado Atenciones" class="boton" onclick="$ajaxload('info', 'atenciones/buscar_contrato?protocolo=<?php echo $datos_afil['num_solici']; ?>',false,false);" /></div>

<?php
}
?>




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
where fichas.correlativo ='".$_GET['protocolo']."' order by hora_llamado DESC";

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
