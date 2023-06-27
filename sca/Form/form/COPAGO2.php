<?php
/////////////////////////////////////////////////-------------------------------------------------------------------------------------
if ( ($num < 1000) and ($matriz_resultados['hora_llamado'] > 0) and ($matriz_resultados['hora_despacho'] > 0) and ($matriz_resultados['hora_salida_base'] > 0) and ($matriz_resultados['hora_llegada_domicilio'] > 0) ){
?>
Acci&oacute;n 
<select id="destino2_<?php echo $matriz_resultados['correlativo']; ?>" style="width:120px">
<option value="0">&nbsp;</option>
<?php
$query = "select * from destino where accion = 3";
$respuesta = mysql_query($query);
while ($mat2 = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $mat2['cod']; ?>"><?php echo $mat2['destino']; ?></option>
<?
}
?>
</select>

<input type="button" value="Aceptar" class="boton" onclick="
if(confirm('Esta de realizar los cambios?')){
var destino = document.getElementById('destino2_<?php echo $matriz_resultados['correlativo']; ?>').value;

$ajaxload('bus','Form/Actualizar_ficha20.php?destino='+destino+'&correlativo=<?php echo $matriz_resultados['correlativo']; ?>',false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
}
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
" />

<br /><br />

<table style="width:480px;">
<tr>
<td>Boleta
</td>
<td>
<input style=" width:150px;" type="text" id="boleta_<?php echo $matriz_resultados['correlativo']; ?>" maxlength="9" />
</td>
</tr>

<tr>
<td>Importe</td>
<td>
<select id="importe_<?php echo $matriz_resultados['correlativo']; ?>" style="width:150px; color:#069; font-size:14px;">
<option value=""></option>
<?php
$sql = "SELECT codigo FROM v_copagos ORDER BY codigo";
$query = mysql_query($sql);
while ($v_cop = mysql_fetch_array($query)){
echo '<option value="'.$v_cop['codigo'].'">$	'.$v_cop['codigo'].'</option>';
}
?>
<option value="0">S/Copago</option>
</select>
</td>
</tr>

<tr>
<td>Tipo de Pago</td>
<td>
<select name="tipopago" id="tipo_pago<?php echo $matriz_resultados['correlativo']; ?>">
  <option value="<?php echo $f_pago1;?>"><?php echo $f_pago2;?></option>
  <option value="1">EFECTIVO</option>
  <option value="2">CHEQUE</option>
  <option value="3">PENDIENTE</option>
  <option value="4">CASOS ESPECIALES</option>
  <option value="5">DESC. X PLANILLA</option>
  <option value="4">MEDIMEL</option>
  <option value="4">VIP PLATINIUM</option>
  <option value="4">VIP DORADO</option>
  <option value="4">ASISTENCIA INTEGRAL</option> 
  <option value="10">TRASLADOS</option>
  <option value="11">S/COPAGO</option>  
</select>
</td>
</tr>

<tr>
<td>Folio MED N&ordm;</td>
<td><input style=" width:150px;" type="text" id="med_<?php echo $matriz_resultados['correlativo']; ?>" maxlength="9" /></td>
</tr>


<tr>
<td>&nbsp;</td>
<td align="right">
<?php

if (($matriz_resultados['obser_man'] == 24) and ($matriz_resultados['hora_sale_destino'] > 0) ){
?>
<input type="button" value="GUARDAR" class="boton" id="guardar_<?php echo $matriz_resultados['correlativo']; ?>" / onclick="
var boleta= document.getElementById('boleta_<?php echo $matriz_resultados['correlativo']; ?>').value;
var importe= document.getElementById('importe_<?php echo $matriz_resultados['correlativo']; ?>').value;
var tipo_pago =document.getElementById('tipo_pago<?php echo $matriz_resultados['correlativo']; ?>').value; 
var folio_med = document.getElementById('med_<?php echo $matriz_resultados['correlativo']; ?>').value;


if( (!boleta) || (!importe) || (!tipo_pago) ){
alert('Debe llenar los campos numero de boleta e importe');
}
else{
if(confirm('Esta seguro de finalizar el llamado')) {	
$ajaxload('bus','Form/guardar_form.php?boleta='+boleta+'&importe='+importe+'&tipo_pago='+tipo_pago+'&movil=<?php echo $matriz_resultados['movil']; ?>&correlativo=<?php echo $matriz_resultados['correlativo']; ?>&nsocio=<?php echo $matriz_resultados['num_solici']; ?>&folio_med='+folio_med,'Cargando',false,false);
}
}
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
" >
<?php
}
?>
</td>
</tr>

</table>
<?php
}//FIN IF COM PURBEA
?>
