<?php
include('../conf.php');
include('../bd.php');
$consulta = "select DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') as hora_llamado, DATE_FORMAT(hora_despacho,'%d-%m-%Y %H:%i:%S') as hora_despacho, DATE_FORMAT(hora_salida_base,'%d-%m-%Y %H:%i:%S') as hora_salida_base, DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y %H:%i:%S') as hora_llegada_domicilio,
DATE_FORMAT(hora_sale_domicilio,'%d-%m-%Y %H:%i:%S') as hora_sale_domicilio from fichas where fichas.correlativo = '".$_GET['correlativo']."'";
$resultados = mysql_query($consulta);
while ($matriz_resultados = mysql_fetch_array($resultados)){
?>
<div align="right" style="padding:0; margin:0px; font-size:12px">
Aviso
<a href="#" onclick="javascript:cerrarPopup('control_de_tiempos',false)" class="boton1">
<img style="background-color:#F7F7F7" src="IMG/exclamation.png" width="16" height="16" />
</a>
</div>

<div style="overflow:auto; height:170px" id="mensajehorario">
<table class="celda3" style="width:380px">
<tr>
<td><a href="#" class="boton1"><img src="IMG/clock.png" width="16" height="16"></a>&nbsp;Hs Llamado
</td>

<td>
<a href="#" class="boton1"
<?php if ($matriz_resultados['hora_despacho'] < 1){ ?>
 onclick="if (confirm('Esta seguro de agregar?')) {
$ajaxload('Hs_despacho', 'PHP/main.php?gravarhora=1&rut=<?php echo $_GET['rut'];?>&correlativo=<?php echo $_GET['correlativo']; ?>&consulta_para_hora=hora_despacho','Cargando',false,false);}"
<?php } ?>> 
<img src="IMG/clock.png" width="16" height="16"></a>&nbsp;Hs despacho
</td>


<td>
<a href="#" class="boton1"
<?php if (($matriz_resultados['hora_despacho'] > 0) && ($matriz_resultados['hora_salida_base'] < 1)){?>
onclick="if (confirm('Esta seguro de agregar?')) {
$ajaxload('Hs_salida_base', 'PHP/main.php?gravarhora=1&rut=<?php echo $_GET['rut'];?>&correlativo=<?php echo $_GET['correlativo']; ?>&consulta_para_hora=hora_salida_base','Cargando',false,false);}"
<?php } ?>><img src="IMG/clock.png" width="16" height="16"></a>&nbsp;Hs salida bas
</td>

<td>
<a href="#" class="boton1"
<?php if(($matriz_resultados['hora_salida_base'] > 0) && (!$matriz_resultados['hora_llegada_domicilio'] < 1)){?>
onclick="if (confirm('Esta seguro de agregar?')) {
$ajaxload('Hs_llega_domicilio', 'PHP/main.php?gravarhora=1&rut=<?php echo $_GET['rut'];?>&correlativo=<?php echo $_GET['correlativo']; ?>&consulta_para_hora=hora_llegada_domicilio','Cargando',false,false);}"
<?php } ?>> 
<img src="IMG/clock.png" width="16" height="16"></a>&nbsp;Hs llega domicilio
</td>

<td>
<a href="#" class="boton1"
<?php if(($matriz_resultados['hora_llegada_domicilio'] > 0) && (!$matriz_resultados['hora_sale_domicilio']< 1)){?>
onclick="if (confirm('Esta seguro de agregar?')) {
$ajaxload('Hs_sale_domicilio', 'PHP/main.php?gravarhora=1&rut=<?php echo $_GET['rut'];?>&correlativo=<?php echo $_GET['correlativo']; ?>&consulta_para_hora=hora_sale_domicilio','Cargando',false,false);}"
<?php } ?>> 
<img src="IMG/clock.png" width="16" height="16"></a>&nbsp;Hs sale domicilio
</td>
</tr>

<tr>
<td><div id="Hs_llamado"><?php echo $matriz_resultados['hora_llamado']; ?></div></td>
<td><div id="Hs_despacho"><?php echo $matriz_resultados['hora_despacho']; ?></div></td>
<td><div id="Hs_salida_base"><?php echo $matriz_resultados['hora_salida_base']; ?></div></td>
<td><div id="Hs_llega_domicilio"><?php echo $matriz_resultados['hora_llegada_domicilio']; ?></div></td>
<td><div id="Hs_sale_domicilio"><?php echo $matriz_resultados['hora_sale_domicilio']; ?></div></td>
</tr>
</table>

<table class="celda3" style="width:380px">
<tr>
<td></td>
<td>
<?php

$consulta = "select cod, destino from destino";
$resultados = mysql_query($consulta);
?>
<select id="destino_">
<?php
while ($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option value="<?php echo $matriz_resultados['cod']; ?>"><?php echo $matriz_resultados['destino'];?></option>
<?php
}
?>
</select>
</td>
</tr>
</table>

<div id="estado_con"></div>

<table class="celda3" style="width:380px">
<tr>
<td><div align="right"><input type="button" value="Gravar" class="boton" onclick="javascript:$ajaxload('estado_con', 'PHP/ANULADO.php?rut=<?php echo $_GET['rut'];?>&correlativo=<?php echo $_GET['correlativo']; ?>&destino_='+document.getElementById('destino_').value,'Cargando',false,false);" /></div></td>
</tr>
</table>
<?php
}
mysql_close($conexion);
?>
