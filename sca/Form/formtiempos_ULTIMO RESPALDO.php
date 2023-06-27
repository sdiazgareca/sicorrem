<?php

$correlativo = $_GET['correlativo'];
$nro_doc = $_GET['nro_doc'];
$num = $_GET['num'];

include('../conf.php');
include('../bd.php');

if ( (isset($_GET['tipopago'])) && (isset($_GET['copago']))  &&  (isset($_GET['boleta'])) ){
$consulta = 'UPDATE fichas SET tipopago="'.$_GET['tipopago'].'",copago="'.$_GET['copago'].'", boleta="'.$_GET['boleta'].'",estado=0 WHERE correlativo="'.$_GET['correlativo'].'"';

?>
<table style="width:500px;border:solid 1px #A6B7AF" class="celda1">
<tr>
<td>Paciente</td>
</tr>
</table>

<table style="width:500px;border:solid 1px #A6B7AF" class="celda1">
<tr>
<td class="celda2">
<?
$resultados = mysql_query($consulta);
if($resultados){
echo 'Cambios Realizados';
}
exit;
}
?>
</td>
</tr>
</table>
<?php

$consulta = "select DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') as hora_llamado,DATE_FORMAT(hora_despacho,'%d-%m-%Y %H:%i:%S') as hora_despacho,DATE_FORMAT(hora_salida_base,'%d-%m-%Y %H:%i:%S') as hora_salida_base,DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y %H:%i:%S') as hora_llegada_domicilio,DATE_FORMAT(hora_sale_domicilio,'%d-%m-%Y %H:%i:%S') as hora_sale_domicilio,telefono,direccion,entre,movil,color,sector.sector as sector,observacion,celular,edad,paciente,correlativo,obser_man,diagnostico from fichas inner join sector on sector.cod = fichas.sector where movil='".$num."' and estado=1";

$resultados = mysql_query($consulta);
$matriz_resultados = mysql_fetch_array($resultados);

if ($num < 1000){
$men = 'Movil '.$num;
}
else{
$men = 'Llamado en Espera '.($num - 1000);
}
?>
<table style="width:500px;border:solid 1px #A6B7AF" class="celda1">
<tr>
<td>Paciente</td>
</tr>
</table>

<table style="width:480px;border:solid 1px #A6B7AF" class="celda1">
<tr>
<td class="celda2">


<h1><a class="boton1"><img src="IMG/folder_user.png" width="16" height="16" /></a>&nbsp;<?php echo $men; ?>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="boton1" onclick="MuestraVentana('control_de_tiempos','<?php echo $matriz_resultados['nro_doc']; ?>','<?php echo $matriz_resultados['correlativo']; ?>')"><img src="IMG/time.png" width="16" height="16" /></a>Asignar horario
</h1>

<?php
if ($num < 1000){
?>

<table style="width:480px; background:#FFFEE0; border:solid 1px #A6B7AF" class="celda2">
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

<?php
$consulta = "select direccion,obser_man,edad,nro_doc,correlativo,telefono,direccion,entre,movil,color,sector.sector as sector,observacion,celular,edad,paciente,correlativo, hora_llegada_domicilio,diagnostico,obser_man,tipo_plan,isapre,cod_plan from fichas
inner join sector on sector.cod = fichas.sector
 where movil ='".$num."' and estado =1";

$resultados = mysql_query($consulta);
?>

<br />
<?php
while ($matriz_resultados2 = mysql_fetch_array($resultados)){
?>
<table style="width:480px; background:#FFFEE0; border: solid 1px #A6B7AF; border-bottom:none;" class="celda3">
<tr>
<td width="68" class="celda3" style="background-color:#FFFEE0">Protocolo</td>
<td width="27" class="celda2"style="background-color:#FFFEE0"><div id="correlativo"><?php echo $matriz_resultados2['correlativo']; ?></div></td>
<td width="55" class="celda3" style="background-color:#FFFEE0">Paciente</td>
<td width="226" class="celda2"style="background-color:#FFFEE0">&nbsp;<?php echo strtoupper($matriz_resultados2['paciente']); ?></td>
<td width="32" class="celda3" style="background-color:#FFFEE0">Edad</td>
<td width="44" class="celda2" style="background-color:#FFFEE0"><?php echo $matriz_resultados2['edad']; ?></td>
</tr>
</table>

<table style="width:480px; background:#FFFEE0; border:solid 1px #A6B7AF; border-top:none" class="celda3">
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

<table style="width:480px; background:#FFFEE0; border-left: solid 1px #A6B7AF; border-right: solid 1px #A6B7AF; border-bottom:none;" class="celda3">
<tr>
<td width="60" class="celda3" style="background-color:#FFFEE0">Direccion</td>
<td width="408" class="celda3"style="background-color:#FFFEE0"><div id="direccion_ficha>"><?php echo strtoupper($matriz_resultados2['direccion']); ?></div></td>

</tr>
</table>

<table style="width:480px; background:#FFFEE0; border-left:solid 1px #A6B7AF; border-right:solid 1px #A6B7AF; border-bottom:solid 1px #A6B7AF;" class="celda3">
<tr>
<td class="celda3"style="background-color:#FFFEE0"><strong>Entre:</strong></td>
<td class="celda2"style="background-color:#FFFEE0"><div id="entre"><?php echo strtoupper($matriz_resultados2['entre']); ?></div></td>
<td class="celda3"style="background-color:#FFFEE0"><strong>Sector</strong></td>
<td class="celda2"style="background-color:#FFFEE0"><div id="sector"><?php echo strtoupper($matriz_resultados2['sector']); ?></div></td>
</tr>

<tr>
<td width="57" class="celda3" style="background-color:#FFFEE0"><strong>Telefono</strong></td>
<td width="188" class="celda2"style="background-color:#FFFEE0">
<div id="telefono"><?php echo strtoupper($matriz_resultados2['telefono']); ?></div>
</td>
<td width="48" class="celda3" style="background-color:#FFFEE0"><strong>Celular</strong></td>
<td width="167" class="celda2"style="background-color:#FFFEE0">
<div id="celular"><?php echo strtoupper($matriz_resultados2['celular']); ?></div>
</td>
</tr>
</table>

<?php
if ($num >= 1000){
?>
<table style="width:480px; background:#FFFEE0; border:solid 1px #A6B7AF; border-top:none" class="celda3">
<tr>
<td width="320" class="celda2"style="background-color:#FFFEE0">
<strong>Observaciones</strong>
<textarea name="observacion_edicion_<?php echo $matriz_resultados2['correlativo']; ?>" cols="40" rows="4" id="observacion_edicion_<?php echo $matriz_resultados2['correlativo']; ?>" style="color:#000000;height:90px; width:320px">
<?php echo $matriz_resultados2['observacion']; ?>
</textarea>
<input type="button" class="boton" value="Gravar Observaciones" 
onclick="
var ob = document.getElementById('observacion_edicion_<?php echo $matriz_resultados2['correlativo']; ?>').value;
$ajaxload('cambio_<?php echo $matriz_resultados2['correlativo']; ?>','Form/Actualizar_ficha2.php?ob='+ob+'&correlativo=<?php echo $matriz_resultados2['correlativo']; ?>',false,false,false);

$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);

$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);" /></td>

<td width="148">
<div id="movil_asignados_<?php echo $matriz_resultados2['correlativo']; ?>" style="background-color:#FFFEE0; padding:1px;width:100px;" align="left">

<a style="color:#000000" href="#" onclick="$ajaxload('movil_asignados_<?php echo $matriz_resultados2['correlativo']; ?>', 'Form/Muestra_moviol_compartir3.php?id=movil_<?php echo $matriz_resultados2['correlativo']; ?>&correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>&movil=<?php echo $matriz_resultados['numero']; ?>',false,false,false);">Movil Libre</a>

<select name="movil_<?php echo $matriz_resultados2['correlativo']; ?>" size="5" id="movil_<?php echo $matriz_resultados2['correlativo']; ?>" style="background-color:#FFFEE0; height:120px;width:120px;">
<?php
$consultare = "select numero from movilasig where estado = 0  and medico > 0 ";		
$resultadosre = mysql_query($consultare);
while($matriz_resultadosre = mysql_fetch_array($resultadosre)){
?>
<option class="text" onDblClick="cambiar_amb(this.value,'<?php echo $matriz_resultados2['correlativo']; ?>','<?php echo $num;?>')" value="<?php echo $matriz_resultadosre['numero']; ?>"><?php echo 'Movil '.$matriz_resultadosre['numero']; ?></option>
<?php
}
?>
</select>
</div>
</td>
</tr>
</table>

<!-- ----------------------------------------------------------------------------------------------------------------- -->




<table style="width:480px; background:#FFFEE0; border:solid 1px #A6B7AF; border-top:none" class="celda3">
<tr>
<td>
Anular&nbsp;
<select id="destino_<?php echo $matriz_resultados2['correlativo']; ?>">
<option value="0">&nbsp;</option>
<?php
$query = "select cod,destino from destino where cod != 24 and cod != 42";
$respuesta = mysql_query($query);

while ($mat2 = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $mat2['cod']; ?>"><?php echo $mat2['destino']; ?></option>
<?
}
?>
</select>





<input type="button" value="Anular" class="boton" onclick="
if(confirm('Esta seguro de anular el llamado?')){

var destino = document.getElementById('destino_<?php echo $matriz_resultados2['correlativo']; ?>').value;

$ajaxload('cambio_<?php echo $matriz_resultados2['correlativo']; ?>','Form/Actualizar_ficha.php?destino='+destino+'&correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&direccion=<?php echo $dire; ?>&color=<?php echo $color; ?>&movil=<?php echo $num;?>',false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
}
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
" />
</td>
</tr>
</table>
<br />
<?php
}
else{
?>
<table style="width:480px; background:#FFFEE0; border:solid 1px #A6B7AF; border-top:none" class="celda3">
<tr>
<td width="320" class="celda2"style="background-color:#FFFEE0">
<div style="width:320px">
  <div align="right"><strong>Observaciones</strong>
      <textarea name="observacion_edicion_<?php echo $matriz_resultados2['correlativo']; ?>" cols="40" rows="4" id="observacion_edicion_<?php echo $matriz_resultados2['correlativo']; ?>" style="color:#000000;height:90px; width:320px">
<?php echo $matriz_resultados2['observacion']; ?>
    </textarea>
      <input type="button" class="boton" value="Gravar Observaciones" 
onclick="
var ob = document.getElementById('observacion_edicion_<?php echo $matriz_resultados2['correlativo']; ?>').value;
$ajaxload('cambio_<?php echo $matriz_resultados2['correlativo']; ?>','Form/Actualizar_ficha2.php?ob='+ob+'&correlativo=<?php echo $matriz_resultados2['correlativo']; ?>',false,false,false);

$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);

$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);" />
  </div>
</div></td>




<td width="148">
<div id="movil_asignados_<?php echo $matriz_resultados2['correlativo']; ?>" style="background-color:#FFFEE0; padding:1px;width:100px;" align="left">

<a style="color:#000000" href="#" onclick="$ajaxload('movil_asignados_<?php echo $matriz_resultados2['correlativo']; ?>', 'Form/Muestra_moviol_compartir5.php?id=movil_<?php echo $matriz_resultados2['correlativo']; ?>&correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>&movil=<?php echo $matriz_resultados['numero']; ?>',false,false,false);">Movil Libre</a>
<select name="movil_<?php echo $matriz_resultados2['correlativo']; ?>" size="5" id="movil_<?php echo $matriz_resultados2['correlativo']; ?>" style="background-color:#FFFEE0; height:120px;width:120px;">
<?php
$consultare = "select numero from movilasig where estado = 0  and medico > 0 ";		
$resultadosre = mysql_query($consultare);
while($matriz_resultadosre = mysql_fetch_array($resultadosre)){
?>
<option class="text" onDblClick="cambiar_amb2(this.value,'<?php echo $matriz_resultados2['correlativo']; ?>','<?php echo $num;?>')" value="<?php echo $matriz_resultadosre['numero']; ?>"><?php echo 'Movil '.$matriz_resultadosre['numero']; ?></option>
<?php
}
?>

<?php
$consultare = "select cod,espera from movil_espera where estado = 0 limit 1";		
$resultadosre = mysql_query($consultare);
while($matriz_resultadosre = mysql_fetch_array($resultadosre)){
?>
<option class="text" onDblClick="cambiar_amb3(this.value,'<?php echo $matriz_resultados2['correlativo']; ?>','<?php echo $num;?>')" value="<?php echo $matriz_resultadosre['cod']; ?>"><?php echo 'Espera '.$matriz_resultadosre['espera']; ?></option>
<?php
}
?>
</select>
</div></td>
</tr>

<tr>
<td>
Anular&nbsp;&nbsp;
<select id="destino_<?php echo $matriz_resultados2['correlativo']; ?>">
<option value="0">&nbsp;</option>
<?php
$query = "select cod,destino from destino where cod != 24 and cod != 42";
$respuesta = mysql_query($query);

while ($mat2 = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $mat2['cod']; ?>"><?php echo $mat2['destino']; ?></option>
<?
}
?>
</select></td>
<td>
<input type="button" value="Anular" class="boton" onclick="
if(confirm('Esta seguro de anular el llamado?')){

var destino = document.getElementById('destino_<?php echo $matriz_resultados2['correlativo']; ?>').value;
$ajaxload('cambio_<?php echo $matriz_resultados2['correlativo']; ?>','Form/Actualizar_ficha.php?destino='+destino+'&correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&direccion=<?php echo $dire; ?>&color=<?php echo $color; ?>&movil=<?php echo $num;?>',false,false,false);
if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
}
" /></td>
</tr>
<?php

if($matriz_resultados2['hora_llegada_domicilio'] > 1){
if ((!$matriz_resultados2['obser_man'])&&(!$matriz_resultados2['diagnostico'])){
?>
<tr>
<td> Accion
&nbsp;
<select id="accionn_<?php echo $matriz_resultados2['correlativo']; ?>">
<option value="0">&nbsp;</option>
<?php
$query = "select cod,destino from destino where cod = 42 || cod =45";
$respuesta = mysql_query($query);

while ($mat2 = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $mat2['cod']; ?>"><?php echo $mat2['destino']; ?></option>
<?
}
?>
</select></td>
<td>
<input type="button" value="Guardar" class="boton" onclick="
if(confirm('Esta seguro de guardar los cambios?')){

var destino = document.getElementById('accionn_<?php echo $matriz_resultados2['correlativo']; ?>').value;

$ajaxload('cambio_<?php echo $matriz_resultados2['correlativo']; ?>','Form/Actualizar_ficha3.php?destino='+destino+'&correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&direccion=<?php echo $dire; ?>&color=<?php echo $color; ?>&movil=<?php echo $num;?>',false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
}
" /></td>
</tr>
<?php
}

if (  ($matriz_resultados2['obser_man'] == 42)  &&(!$matriz_resultados2['diagnostico'])){
?>
<tr>
<td>
Diagnostico
&nbsp;
<select id="diagnostico<?php echo $matriz_resultados2['correlativo']; ?>" style="width:260px">
<option value="0">&nbsp;</option>
<?php
$query = "select cod, diagnostico from diagnostico order by cod";
$respuesta = mysql_query($query);

while ($mat2 = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $mat2['cod']; ?>"><?php echo $mat2['cod']/*htmlentities($mat2['diagnostico'])*/; ?></option>
<?
}
?>
</select></td>
<td>
<input type="button" value="Guardar" class="boton" onclick="
if(confirm('Esta seguro de guardar los cambios?')){

var destino = document.getElementById('diagnostico<?php echo $matriz_resultados2['correlativo']; ?>').value;

$ajaxload('cambio_<?php echo $matriz_resultados2['correlativo']; ?>','Form/Actualizar_ficha4.php?destino='+destino+'&correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&direccion=<?php echo $dire; ?>&color=<?php echo $color; ?>&movil=<?php echo $num;?>',false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
}
" />

</td>
</tr>
<?php
}

if(($matriz_resultados2['obser_man'] == 42)&&($matriz_resultados2['diagnostico'])){
?>
<tr>
<td>
<br />
Copago 
<input type="text" id="copago" size="43" />
<br />

<?php 
/*
if(($matriz_resultados2['tipo_plan'] == 'CA') && ($matriz_resultados2['isapre'] == 'CA') && ($matriz_resultados2['cod_plan'] =='CA')){
echo 'Copago = <input type="text" id="boleta" value="$30.000" />';
}
?>
<?php 
if(($matriz_resultados2['tipo_plan'] == 'PA') && ($matriz_resultados2['isapre'] == 'PA') && ($matriz_resultados2['cod_plan'] =='PA')){
echo 'Copago = <input type="text" id="boleta" value="$70.000" />';
}
*/
?>

<?php 
if(($matriz_resultados2['tipo_plan'] != 'PA') && ($matriz_resultados2['tipo_plan'] != 'CA')){

}
?>
<br />
N&deg;&nbsp;Boleta&nbsp;
<input type="text" id="boleta" size="40" />
<br /><br />
Pago&nbsp;
<select name="tipopago" id="tipopago">
  <option value="1">Efectivo</option>
  <option value="2">Cheque</option>
  <option value="3">Pendiente</option>
  <option value="4">Casos Especiales</option>
  <option value="5">MEDIMEL</option>
</select>
<br /></td>
<td>
  <div align="right">
    <input type="button" class="boton" value="Guardar" onclick="

var tipopago = document.getElementById('tipopago').value;
var copago = document.getElementById('copago').value;
var boleta = document.getElementById('boleta').value;
var correlativo = '<?php echo $matriz_resultados2['correlativo']; ?>';

if ((!tipopago) || (!copago) || (!boleta) ){

alert('Debe ingresar datos...');
}
else{
$ajaxload('bus','Form/formtiempos.php?tipopago='+tipopago+'&copago='+copago+'&boleta='+boleta+'&correlativo='+correlativo,false,false,false);
}" />
  </div></td>
</tr>




<?php
}
if(($matriz_resultados2['obser_man'] == 24)&&(!$matriz_resultados2['diagnostico'])){
?>
<tr>
<td><!-- Calcular COPAGO Traslado --> </td>
</tr>
<?php
}
}
?>
</table>
<br />
<?php
}
}
?>
</td>
</tr>
</table>