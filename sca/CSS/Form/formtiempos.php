<?php
$correlativo = $_GET['correlativo'];
$nro_doc = $_GET['nro_doc'];

include('../conf.php');
include('../bd.php');

$consulta = "select 
afiliados.num_solici,
afiliados.nro_doc,
nombre1,
nombre2,
apellido,
mot_baja.descripcion as descripcion1,
mot_baja.codigo as codigo,
categoria.descripcion as descripcion2,
tipo_plan.tipo_plan_desc,
tipo_plan.tipo_plan,reducido,
planes.desc_plan,
sector.sector as sector,
fichas.direccion,
fichas.entre,
fichas.telefono,
fichas.celular,
fichas.paciente,
fichas.observacion,
fichas.correlativo,
fichas.movil,
color.color

from afiliados 
inner join mot_baja on afiliados.cod_baja = mot_baja.codigo 
inner join categoria on afiliados.categoria = categoria.categoria
inner join tipo_plan on afiliados.tipo_plan = tipo_plan.tipo_plan
inner join obras_soc on afiliados.obra_numero = obras_soc.nro_doc
inner join planes on afiliados.cod_plan = planes.cod_plan and afiliados.tipo_plan = planes.tipo_plan
inner join fichas on afiliados.nro_doc = fichas.nro_doc
inner join sector on fichas.sector = sector.cod
inner join color on fichas.color = color.cod 
where fichas.correlativo= '".$correlativo."'";


$resultados = mysql_query($consulta);
$matriz_resultados = mysql_fetch_array($resultados);
?>
<div class="formulario">
<form method="get" name="form1">
<table style="width:500px;">
<tr>
<td class="celda1"><div>Numero de Contrato</div><div id="ncontrato" style="float:left; width:auto;"><?php echo $matriz_resultados['num_solici']; ?></div></td>
<td class="celda1"><div>Correlativo</div><div id="ncontrato" style="float:left; width:auto;"><?php echo $matriz_resultados['correlativo']; ?></div></td>
<td class="celda1"><div>Clave</div><div id="ncontrato" style="float:left; width:auto;"><?php echo $matriz_resultados['color']; ?></div></td>
</tr>
</table>
<table style="width:500px;">
<tr>
<td class="celda2">

<h1><a onclick="$toggle('myId');" class="boton1"><img src="IMG/user.png" width="16" height="16" /></a>&nbsp;Datos Afiliado
&nbsp;<a href="#" class="boton1" onclick="MuestraVentana('control_de_tiempos','<?php echo $matriz_resultados['nro_doc']; ?>','<?php echo $matriz_resultados['correlativo']; ?>')"><img src="IMG/time.png" width="16" height="16" /></a>&nbsp;Estado</h1>
<table style="width:480px; background:#FFFEE0" class="celda3">
<tr style="background-color:#FFFEE0">
<td class="celda3" style="background-color:#FFFEE0">Rut</td>
<td class="celda2" style="background-color:#FFFEE0"><div id="a"><?php echo htmlentities($matriz_resultados['nro_doc']); ?></div></td>
<td  class="celda3" style="background-color:#FFFEE0">Afiliado</td>
<td  class="celda2" style="background-color:#FFFEE0"><div id="paciente"><?php echo htmlentities(strtoupper($matriz_resultados['apellido']));?> <?php echo htmlentities(strtoupper($matriz_resultados['nombre1'])); ?> <?php echo strtoupper($matriz_resultados['$nombre2']); ?></div></td>
<td  class="celda3" style="background-color:#FFFEE0">Estado</td>
<td class="celda2" style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['descripcion1']);?></td>
</tr>
</table>
<div id="myId" style="display:none;" >
<table style="width:480px; background:#FFFEE0" class="celda3">
<tr style="background-color:#FFFEE0">
<td  class="celda3" style="background-color:#FFFEE0">Plan</td>
<td class="celda2" style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['desc_plan']);?></td>
<td  class="celda3" style="background-color:#FFFEE0">Isapre</td>
<td class="celda2" style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['reducido']); ?></td>
<td class="celda3" style="background-color:#FFFEE0">Categoria</td>
<td class="celda2"style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['descripcion2']);?></td>
</tr>
<tr style="background-color:#FFFEE0">
<td class="celda3" style="background-color:#FFFEE0">Tipo</td>
<td class="celda2" style="background-color:#FFFEE0"><?php echo htmlentities($matriz_resultados['tipo_plan_desc']);?></td>
<td class="celda3" style="background-color:#FFFEE0">Fono Referencia</td>
<?php

$consulta3 = "select telefono from afiliados 
inner join domicilios on afiliados.nro_doc = domicilios.nro_doc
where afiliados.nro_doc ='".$matriz_resultados['nro_doc']."'";
		
$resultados3 = mysql_query($consulta3);
$nbd = mysql_num_rows($resultados3);


$matriz_resultados3 = mysql_fetch_array($resultados3);
?>
<td class="celda2" style="background-color:#FFFEE0"><?php if(!$matriz_resultados3['telefono']){echo 'No registra';} else{ echo htmlentities($matriz_resultados3['telefono']);}?></td>
<td class="celda3" style="background-color:#FFFEE0">&nbsp;</td>
<td class="celda2" style="background-color:#FFFEE0"><div id="edad"></div></td>
</tr>
</table>
</div>
<h1><a class="boton1"><img src="IMG/folder_user.png" width="16" height="16" /></a>&nbsp;Ficha Paciente</h1>

<table style="width:480px; background:#FFFEE0" class="celda3">
<tr>
<td class="celda3" style="background-color:#FFFEE0">Paciente</td><td class="celda2"style="background-color:#FFFEE0"><input type="text" id="paciente_ficha" value="<?php echo strtoupper($matriz_resultados['paciente']); ?>" size="60" /></td>
</tr>
</table>

<table style="width:480px; background:#FFFEE0" class="celda3">
<tr>
<td class="celda3" style="background-color:#FFFEE0">Telefono</td><td class="celda2"style="background-color:#FFFEE0"><input id="telefono_ficha" type="text" value="<?php echo strtoupper($matriz_resultados['telefono']); ?>" size="8" /></td>
<td class="celda3" style="background-color:#FFFEE0">Celular</td>
<td class="celda2"style="background-color:#FFFEE0"><input type="text" id="celular_ficha" value="<?php echo strtoupper($matriz_resultados['celular']); ?>"  size="8"/></td>
</tr>
</table>

<table style="width:480px; background:#FFFEE0" class="celda3">
<tr>
<td class="celda3" style="background-color:#FFFEE0">Sintomas</td>
<td class="celda2"style="background-color:#FFFEE0">

<?php
$consu = "select sintomas.sintoma from sintomas
inner join sintomas_reg on sintomas_reg.sintoma = sintomas.cod
inner join afiliados on afiliados.nro_doc = sintomas_reg.rut
where sintomas_reg.rut = ".$matriz_resultados['nro_doc']." and sintomas_reg.correlativo = '".$matriz_resultados['correlativo']."'";

$resul = mysql_query($consu);
while ($mat = mysql_fetch_array($resul)){
echo strtoupper($mat['sintoma'].'- ');
}
?>

</td>
</tr>

<tr>
<td class="celda3" style="background-color:#FFFEE0">Direccion</td>
<td class="celda2"style="background-color:#FFFEE0"><?php echo strtoupper($matriz_resultados['direccion']); ?>&nbsp;<strong>Entre:</strong><?php echo strtoupper($matriz_resultados['entre']); ?>&nbsp;<strong>Sector:</strong>&nbsp;<?php echo strtoupper($matriz_resultados['sector']); ?></td>
</tr>

<tr>
<td class="celda3" style="background-color:#FFFEE0">Observaci&oacute;n</td>
<td class="celda2"style="background-color:#FFFEE0">
<textarea cols="43" id="observacion_edicion" style="color:#000000">
<?php echo strtoupper($matriz_resultados['observacion']); ?>
</textarea>
</td>
</tr>
</table>
<div align="right"><input type="button" value="Guardar" class="boton" /></div>
</td>
</tr>
</table>
</form>
</div>