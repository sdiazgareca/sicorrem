<?php
include('../conf.php');
include('../bd.php');

$consulta = "select movil,DATE_FORMAT(hora_llamado,'%d-%m-%Y %H:%i:%S') as hora_llamado, DATE_FORMAT(hora_despacho,'%d-%m-%Y %H:%i:%S') as hora_despacho, DATE_FORMAT(hora_salida_base,'%d-%m-%Y %H:%i:%S') as hora_salida_base, DATE_FORMAT(hora_llegada_domicilio,'%d-%m-%Y %H:%i:%S') as hora_llegada_domicilio,DATE_FORMAT(hora_llega_destino,'%d-%m-%Y %H:%i:%S') AS hora_llega_destino,obser_man,color,
DATE_FORMAT(hora_sale_destino,'%d-%m-%Y %H:%i:%S') AS hora_sale_destino,
DATE_FORMAT(hora_sale_domicilio,'%d-%m-%Y %H:%i:%S') as hora_sale_domicilio from fichas where fichas.correlativo = '".$_GET['correlativo']."' and fichas.estado=1";

//echo "<br /><strong>".$consulta."</strong><br />";

$resultados = mysql_query($consulta);
while ($matriz_resultados = mysql_fetch_array($resultados)){
?>
<div align="right" style="padding:0; margin:0px; font-size:12px">
Aviso
<a href="#" onclick="javascript:cerrarPopup('control_de_tiempos',false);
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultadosX['correlativo']; ?>&nro_doc=<?php echo $matriz_resultadosX['nro_doc']; ?>&num=<?php echo $matriz_resultados['movil']; ?>','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);"
" class="boton1">
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
$ajaxload('Hs_despacho', 'PHP/main.php?gravarhora=1&movil=<?php echo $matriz_resultados['movil'];?>&rut=<?php echo $_GET['rut'];?>&correlativo=<?php echo $_GET['correlativo']; ?>&consulta_para_hora=hora_despacho','Cargando',false,false);}"
<?php } ?>> 
<img src="IMG/clock.png" width="16" height="16"></a>&nbsp;Hs despacho
</td>


<td>
<a href="#" class="boton1"
<?php if (($matriz_resultados['hora_salida_base'] < 1)){?>
onclick="if (confirm('Esta seguro de agregar?')) {
$ajaxload('Hs_salida_base', 'PHP/main.php?gravarhora=1&movil=<?php echo $matriz_resultados['movil'];?>&rut=<?php echo $_GET['rut'];?>&correlativo=<?php echo $_GET['correlativo']; ?>&consulta_para_hora=hora_salida_base','Cargando',false,false);}"
<?php } ?>><img src="IMG/clock.png" width="16" height="16"></a>&nbsp;Hs salida bas
</td>

<td>
<a href="#" class="boton1"
<?php if(($matriz_resultados['hora_salida_base'] > 0) && (!$matriz_resultados['hora_llegada_domicilio'] < 1)){?>
onclick="if (confirm('Esta seguro de agregar?')) {
$ajaxload('Hs_llega_domicilio', 'PHP/main.php?gravarhora=1&movil=<?php echo $matriz_resultados['movil'];?>&rut=<?php echo $_GET['rut'];?>&correlativo=<?php echo $_GET['correlativo']; ?>&consulta_para_hora=hora_llegada_domicilio','Cargando',false,false);}"
<?php } ?>> 
<img src="IMG/clock.png" width="16" height="16"></a>&nbsp;Hs llega domicilio
</td>

<td>
<a href="#" class="boton1"
<?php if(($matriz_resultados['hora_llegada_domicilio'] > 0) && (!$matriz_resultados['hora_sale_domicilio']< 1)){?>
onclick="if (confirm('Esta seguro de agregar?')) {
$ajaxload('Hs_sale_domicilio', 'PHP/main.php?gravarhora=1&movil=<?php echo $matriz_resultados['movil'];?>&rut=<?php echo $_GET['rut'];?>&correlativo=<?php echo $_GET['correlativo']; ?>&consulta_para_hora=hora_sale_domicilio','Cargando',false,false);}"
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

<?php
if ( ($matriz_resultados['color'] == '4') || ($matriz_resultados['obser_man'] == '45') ){
?>
<tr>
<td><a href="#" class="boton1"
<?php if(($matriz_resultados['hora_llegada_domicilio'] > 0) && (!$matriz_resultados['hora_llega_destino']< 1)){?>
onclick="if (confirm('Esta seguro de agregar?')) {
$ajaxload('hora_llega_destino', 'PHP/main.php?gravarhora=1&movil=<?php echo $matriz_resultados['movil'];?>&rut=<?php echo $_GET['rut'];?>&correlativo=<?php echo $_GET['correlativo']; ?>&consulta_para_hora=hora_llega_destino','Cargando',false,false);}"
<?php } ?>> <img src="IMG/clock.png" alt="" width="16" height="16" /></a>&nbsp;Hs llega Destino</td>

<td>
<a href="#" class="boton1"
<?php if ($matriz_resultados['hora_llega_destino'] > 0){ ?>
 onclick="if (confirm('Esta seguro de agregar?')) {
$ajaxload('hora_sale_destino', 'PHP/main.php?gravarhora=1&movil=<?php echo $matriz_resultados['movil'];?>&rut=<?php echo $_GET['rut'];?>&correlativo=<?php echo $_GET['correlativo']; ?>&consulta_para_hora=hora_sale_destino','Cargando',false,false);}"
<?php } ?>> 
<img src="IMG/clock.png" width="16" height="16"></a>&nbsp;Hs Sale Destino</td>
</tr>

<tr>
<td><div id="hora_llega_destino"><?php echo $matriz_resultados['hora_llega_destino']; ?></div></td>
<td><div id="hora_sale_destino"><?php echo $matriz_resultados['hora_sale_destino']; ?></div></td>
</tr>
<?php
}
?>
</table>
<?php
}
mysql_close($conexion);
?>
