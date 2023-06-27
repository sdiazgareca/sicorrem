<?php
$correlativo = $_GET['correlativo'];
$nro_doc = $_GET['nro_doc'];
$num = $_GET['num'];

include('../conf.php');
include('../bd.php');

$consulta = "select DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') as hora_llamado,DATE_FORMAT(hora_despacho,'%d-%m-%Y %H:%i:%S') as hora_despacho,DATE_FORMAT(hora_salida_base,'%d-%m-%Y %H:%i:%S') as hora_salida_base,DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y %H:%i:%S') as hora_llegada_domicilio,DATE_FORMAT(hora_sale_domicilio,'%d-%m-%Y %H:%i:%S') as hora_sale_domicilio,telefono,direccion,entre,movil,color,sector.sector as sector,observacion,celular,edad,paciente,correlativo from fichas inner join sector on sector.cod = fichas.sector where movil='".$num."' and estado=1";

$resultados = mysql_query($consulta);
$matriz_resultados = mysql_fetch_array($resultados);

if ($num < 1000){
$men = 'Movil '.$num;
}
else{
$men = 'Llamado en Espera '.($num - 1000);
}
?>
<div id="formulario" style="width:490px; background-color:#FFFFFF">
<h1><a class="boton1"><img src="IMG/folder_user.png" width="16" height="16" /></a>&nbsp;<?php echo $men; ?></h1>

<?php
if ($num < 1000){
?>
<table style="width:480px; background:#FFFEE0; border:solid 1px #A6B7AF" class="celda3">
<tr>
<td class="celda3" style="background-color:#FFFEE0">Hs Llamado<br /><?php echo $matriz_resultados['hora_llamado']; ?></td>
<td class="celda3" style="background-color:#FFFEE0">Hs Despacho<br /><?php echo $matriz_resultados['hora_despacho']; ?></td>
<td class="celda3" style="background-color:#FFFEE0">Hs salida bas<br /><?php echo $matriz_resultados['hora_salida_base']; ?></td>
<td class="celda3" style="background-color:#FFFEE0">Hs Lleg dom<br /><?php echo $matriz_resultados['hora_llegada_domicilio']; ?></td>
<td class="celda3" style="background-color:#FFFEE0">Hs sale dom<br /><?php echo $matriz_resultados['hora_sale_domicilio']; ?></td>
</tr>
</table>
<?php
}
$dire = $matriz_resultados['direccion'];
$color = $matriz_resultados['color'];
?>
<br />
<table style="width:480px; background:#FFFEE0; border:solid 1px #A6B7AF;" class="celda3">
<tr>
<td width="60" class="celda3" style="background-color:#FFFEE0">Direccion</td>
<td width="408" class="celda3"style="background-color:#FFFEE0"><div id="direccion_ficha>"><?php echo strtoupper($matriz_resultados['direccion']); ?></div></td>
</tr>
</table>

<table style="width:480px; background:#FFFEE0; border-left:solid 1px #A6B7AF; border-right:solid 1px #A6B7AF; border-bottom:solid 1px #A6B7AF;" class="celda3">
<tr>
<td class="celda3"style="background-color:#FFFEE0"><strong>Entre:</strong></td>
<td class="celda2"style="background-color:#FFFEE0"><div id="entre"><?php echo strtoupper($matriz_resultados['entre']); ?></div></td>
<td class="celda3"style="background-color:#FFFEE0"><strong>Sector</strong></td>
<td class="celda2"style="background-color:#FFFEE0"><div id="sector"><?php echo strtoupper($matriz_resultados['sector']); ?></div></td>
</tr>

<tr>
<td width="57" class="celda3" style="background-color:#FFFEE0"><strong>Telefono</strong></td>
<td width="188" class="celda2"style="background-color:#FFFEE0">
<div id="telefono"><?php echo strtoupper($matriz_resultados['telefono']); ?></div>
</td>
<td width="48" class="celda3" style="background-color:#FFFEE0"><strong>Celular</strong></td>
<td width="167" class="celda2"style="background-color:#FFFEE0">
<div id="celular"><?php echo strtoupper($matriz_resultados['celular']); ?></div>
</td>
</tr>
</table>

<?php
$consulta = "select obser_man,edad,nro_doc,correlativo,telefono,direccion,entre,movil,color,sector.sector as sector,observacion,celular,edad,paciente,correlativo from fichas
inner join sector on sector.cod = fichas.sector
 where movil ='".$num."' and estado =1";

$resultados = mysql_query($consulta);
?>

<br />
<?php
while ($matriz_resultados2 = mysql_fetch_array($resultados)){
?>
<table style="width:480px; background:#FFFEE0; border:solid 1px #A6B7AF" class="celda3">
<tr>
<td width="75" class="celda3" style="background-color:#FFFEE0">Correlativo</td>
<td width="393" class="celda2"style="background-color:#FFFEE0"><div id="correlativo"><?php echo $matriz_resultados2['correlativo']; ?></div></td>
</tr>
</table>

<table style="width:480px; background:#FFFEE0; border:solid 1px #A6B7AF" class="celda3">
<tr>
<td width="57" class="celda3" style="background-color:#FFFEE0">Paciente</td>
<td width="226" class="celda2"style="background-color:#FFFEE0">&nbsp;<?php echo strtoupper($matriz_resultados2['paciente']); ?></td>
<td width="32" class="celda3" style="background-color:#FFFEE0">Edad</td>
<td width="145" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz_resultados2['edad']; ?></td>
</tr>
</table>

<table style="width:480px; background:#FFFEE0; border-left:solid 1px #A6B7AF; border-right:solid 1px #A6B7AF;" class="celda3">
<tr>
<td width="58" class="celda3" style="background-color:#FFFEE0">Sintomas</td>
<td width="410" class="celda2"style="background-color:#FFFEE0">

<?php
$consu = "select sintomas.sintoma from sintomas
inner join sintomas_reg on sintomas_reg.sintoma = sintomas.cod
inner join afiliados on afiliados.nro_doc = sintomas_reg.rut
where sintomas_reg.rut = ".$matriz_resultados2['nro_doc']." and sintomas_reg.correlativo = '".$matriz_resultados2['correlativo']."'";

$resul = mysql_query($consu);
while ($mat = mysql_fetch_array($resul)){
echo strtoupper($mat['sintoma'].'- ');
}
?></td>
</tr>
</table>

<table style="width:480px; background:#FFFEE0; border-left:solid 1px #A6B7AF; border-right:solid 1px #A6B7AF;" class="celda3">
<tr>
<td class="celda3" style="background-color:#FFFEE0">Observaciones</td>

<td class="celda3" style="background:#FFFEE0;">
<a href="#" class="boton1" onclick="alert('servicio no disponible');"><img src="IMG/database_lightning.png" width="16" height="16" /></a>&nbsp;
<a href="#" class="boton1" 
onclick="if(confirm('Desea mostrar los moviles asignados?')){
$ajaxload('movil_asignados','Form/Muestra_moviol_compartir.php',false,false,false);}"><img src="IMG/ICONOS/car.png" width="16" height="16" /></a>&nbsp;<a href="#" onclick="if(confirm('Desea mostrar los moviles disponibles?')) {
$ajaxload('movil_asignados','Form/Muestra_moviol_compartir2.php',false,false,false);}" class="boton1"><img src="IMG/car_add.png" width="16" height="16" /></a>
</td>
</tr>

<tr>
<td class="celda2"style="background-color:#FFFEE0">
<textarea cols="40" rows="4" id="observacion_edicion_<?php echo $matriz_resultados2['correlativo']; ?>" style="color:#000000">
<?php echo $matriz_resultados2['observacion']; ?>
</textarea>
</td>

<td>
<div id="movil_asignados">
<select name="movil" size="5" id="movil" style="background-color:#FFFEE0">
<?php
$consulta = "select numero from movilasig where estado = 0";		
$resultados = mysql_query($consulta);
while($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option class="text" ondblclick="DetalleAmbulancia('<? echo $matriz_resultados['numero'];?>')" value="<?php echo $matriz_resultados['numero']; ?>"><?php echo $matriz_resultados['numero']; ?></option>
<?php
}
?>

<?php
$consultaY = "select cod,espera from movil_espera where estado = 0 limit 1";		
$resultadosY = mysql_query($consultaY);
while($matriz_resultadosY = mysql_fetch_array($resultadosY)){
?>
<option class="text" value="<?php echo $matriz_resultadosY['cod']; ?>">Espera&nbsp;<?php echo $matriz_resultadosY['espera']; ?></option>
<?php
}
?>
</select>
</div>
</td>
</tr>
</table>
<table style="width:480px; background:#FFFEE0;  border-left:solid 1px #A6B7AF; border-right:solid 1px #A6B7AF; border-bottom:solid 1px #A6B7AF;" class="celda3">

<tr>
<td>&nbsp;</td>
<td>
<?php
if ($matriz_resultados2['obser_man'] == 42){
?>

<select id="destino_<?php echo $matriz_resultados2['correlativo']; ?>">
<option value="0">&nbsp;</option>
<?php
$query = "select cod,diagnostico from diagnostico";
$respuesta = mysql_query($query);

while ($mat2 = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $mat2['cod']; ?>"><?php echo $mat2['diagnostico']; ?></option>
<?
}
?>
</select>

<?php
}
else{
?>
<select id="destino_<?php echo $matriz_resultados2['correlativo']; ?>">
<option value="0">&nbsp;</option>
<?php
$query = "select cod, destino from destino";
$respuesta = mysql_query($query);

while ($mat2 = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $mat2['cod']; ?>"><?php echo $mat2['destino']; ?></option>
<?
}
?>
</select>
<?php
}
?>
</td>
</tr>
</table>

<table style="width:480px; background:#FFFEE0;  border-left:solid 1px #A6B7AF; border-right:solid 1px #A6B7AF; border-bottom:solid 1px #A6B7AF;" class="celda3">
<tr>
<td class="celda3" style="background:#FFFEE0;">&nbsp;</td>
<td class="celda2" style="background:#FFFEE0;">
<?php
if ($matriz_resultados2['obser_man'] == 42){
echo "";
}
else{
?>
<div align="right"><input type="button" value="Guardar" class="boton" onclick="
if(confirm('Esta seguro de giardar los cambios?')){

var observacion = document.getElementById('observacion_edicion_<?php echo $matriz_resultados2['correlativo']; ?>').value;
var destino = document.getElementById('destino_<?php echo $matriz_resultados2['correlativo']; ?>').value;

$ajaxload('cambio_<?php echo $matriz_resultados2['correlativo']; ?>','Form/Actualizar_ficha.php?observacion='+observacion+'&destino='+destino+'&correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&direccion=<?php echo $dire; ?>&color=<?php echo $color; ?>&movil=<?php echo $num;?>',false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
}
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
" /></div>
<?
}
?>
</td>
</tr>
</table>
<div id="cambio_<?php echo $matriz_resultados2['correlativo']; ?>">&nbsp;</div>
<br />
</form>
<?php  
}
?>
</div>

<script type="text/javascript">
function guardar1(){
}
</script>