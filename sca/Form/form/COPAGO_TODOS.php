<?php
/////////////////////////////////////////////////-------------------------------------------------------------------------------------
if ( ($num < 1000) and ($matriz_resultados['hora_llamado'] > 0) and ($matriz_resultados['hora_despacho'] > 0) and ($matriz_resultados['hora_salida_base'] > 0) and ($matriz_resultados['hora_llegada_domicilio'] > 0) ){
?>
Acci&oacute;n&nbsp;&nbsp;
<select id="destino2_<?php echo $matriz_resultados['correlativo']; ?>" style="width:300px">
<option value="0">&nbsp;</option>
<?php
if ($matriz_resultados['cod'] != '4'){/*****************************************************/

$consu2 = "where accion = 2";
}
else{
$consu2 = "where accion = 3";
}

$query = "select * from destino ".$consu2."";
$respuesta = mysql_query($query);
?>
      
<?php
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
<br  /><br />
<?php 
if ($matriz_resultados['obser_man'] == '45' || $matriz_resultados['obser_man'] == '42' )
{ 
?>
Diagnostico&nbsp;
<select id="diagnosticos_<?php echo $matriz_resultados['correlativo']; ?>" style="width:auto">
<option value="0">&nbsp;</option>
<?php
$query = "select cod, diagnostico from diagnostico order by cod";
$respuesta = mysql_query($query);

while ($diagnostico = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $diagnostico['cod']; ?>"><?php echo $diagnostico['cod']; ?></option>
<?
}
?>
</select>
<input type="button" value="Aceptar" class="boton" onclick="
if(confirm('Esta seguro de guardar los cambios?')){

var diagnostico = document.getElementById('diagnosticos_<?php echo $matriz_resultados['correlativo']; ?>').value;

$ajaxload('bus','Form/Actualizar_ficha4.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&diagnostico='+diagnostico,false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
}
" />
<?php 
if ($matriz_resultados['obser_man'] == '45')
{ 
?>
&nbsp;
C. Hospitalario&nbsp;
<select style="width:80px;" id="centro_hospi_<?php echo $matriz_resultados2['correlativo'] ;?>">
<option value="0">&nbsp;</option>
<?php
$hospital ="SELECT cod, Lugar FROM centrohospita";
$hospital_q = mysql_query($hospital);
while ($mat_hospi = mysql_fetch_array($hospital_q)){
?>
<option value="<?php echo $mat_hospi['cod']; ?>"><?php echo $mat_hospi['Lugar']; ?></option>
<?php
}
?>
</select>

&nbsp;<input type="button" value="Aceptar" class="boton" 

onclick="
if(confirm('Esta seguro de guardar los cambios?')){

var hospital = document.getElementById('centro_hospi_<?php echo $matriz_resultados2['correlativo'] ;?>').value;

$ajaxload('bus','Form/Actualizar_ficha40.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&hospital='+hospital,false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
}
"

 />
<?php
}
?>

<br /><br />
<?
///////////////////////////////////////////////////////////////////////////////////////////
$estado = "SELECT destino FROM destino WHERE cod = '".$matriz_resultados['obser_man']."'";
$con_estado = mysql_query($estado);
$estado_num = mysql_num_rows($con_estado);

if($estado_num > 0){

$mat_estado = mysql_fetch_array($con_estado);
echo '<h1 style="color:#00CC66">Estado: '.$mat_estado['destino'].'</h1>';
}
else{
echo '<br /><blink style="color:#FF0000">Debe Registrar accion</blink>';
}

$diagnostico_n = "SELECT diagnostico.diagnostico FROM fichas INNER JOIN diagnostico ON diagnostico.cod = fichas.diagnostico WHERE fichas.correlativo = ".$matriz_resultados['correlativo']."";
$diagnostico_n_q = mysql_query($diagnostico_n);
$diag_num = mysql_num_rows($diagnostico_n_q);

if($diag_num > 0){
$mat_diag_q = mysql_fetch_array($diagnostico_n_q);
echo '<h1 style="color:#00CC66">Diagnostico: '.$mat_diag_q['diagnostico'].'</h1>';
}
else{
echo '<blink style="color:#FF0000">Debe Registrar el diagnostico</blink>';

}

if ($matriz_resultados['obser_man'] == '45')
{ 
	$estado = "SELECT Lugar FROM centrohospita WHERE cod = '".$matriz_resultados['CentroHospitalario']."'";
	$con_estado = mysql_query($estado);
	$estado_num = mysql_num_rows($con_estado);

	if($estado_num > 0){

	$mat_estado = mysql_fetch_array($con_estado);
	echo '<h1 style="color:#00CC66">Centro Hospitalario: '.$mat_estado['Lugar'].'</h1>';
	}
	else{
	echo '<br /><blink style="color:#FF0000">Debe Registrar el Centro Hospitalario</blink>';
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($matriz_resultados['cod_plan'] == 'CA'){
$plann = 'CARGA NO REGISTRADA';
}
if($matriz_resultados['cod_plan'] == 'PA'){
$plann = 'PARTICULAR';
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<br /><br />
<?php 
if ($matriz_resultados['obser_man'] == '45')
{ 
?>
<table style="width:auto; background:#FFFEE0; border:solid 1px #A6B7AF" class="celda2">
<tr>
<td class="celda3" style="background-color:#FFFEE0">
<a href="#" onclick="$ajaxload('bus','Form/cambiarhora.php?corre=<?php echo $num; ?>','Cargando',false,false);
if($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo'];?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);}">Hs Llega Destino</a><br />
  <div id="hs_Llega_Destino_<?php echo $matriz_resultados['correlativo']; ?>"><?php echo $matriz_resultados['hora_llega_destino']; ?></div></td>

<td class="celda3" style="background-color:#FFFEE0">
<a href="#" onclick="$ajaxload('bus','Form/cambiarhora2.php?corre=<?php echo $num; ?>','Cargando',false,false);
if($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo'];?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);}
">Hs sale Destino</a><br />
  <div id="hs_sale_Destino_<?php echo $matriz_resultados['correlativo']; ?>"><?php echo $matriz_resultados['hora_sale_destino']; ?></div></td>
</tr>
</table>
<?php
}
?>
<br />
Boleta&nbsp;<input type="text" id="boleta_<?php echo $matriz_resultados['correlativo']; ?>" />&nbsp;
Importe&nbsp;<input type="text" id="importe_<?php echo $matriz_resultados['correlativo']; ?>" /><br /><br />
Tipo de Pago&nbsp;<select name="tipopago" id="tipo_pago<?php echo $matriz_resultados['correlativo']; ?>">
  <option value="1">EFECTIVO</option>
  <option value="2">CHEQUE</option>
  <option value="3">PENDIENTE</option>
  <option value="4">CASOS ESPECIALES</option>
  <option value="5">DESC. X PLANILLA</option>
</select>
<?php
}//FIN IF COM PURBEA
?>
<!------------------------------------------------------------------------------------------------------------------------------------------------------- -->  
<br /><br />
<div align="right"><input type="button" value="GUARDAR" class="boton" id="guardar_<?php echo $matriz_resultados['correlativo']; ?>" / onclick="
var boleta= document.getElementById('boleta_<?php echo $matriz_resultados['correlativo']; ?>').value;
var importe= document.getElementById('importe_<?php echo $matriz_resultados['correlativo']; ?>').value;
var tipo_pago =document.getElementById('tipo_pago<?php echo $matriz_resultados['correlativo']; ?>').value; 

if( (!boleta) || (!importe) || (!tipo_pago) ){
alert('Debe llenar los campos');
}
else{
$ajaxload('bus','Form/guardar_form.php?boleta='+boleta+'&importe='+importe+'&tipo_pago='+tipo_pago+'&movil=<?php echo $matriz_resultados['movil']; ?>&correlativo=<?php echo $matriz_resultados['correlativo']; ?>&nsocio=<?php echo $matriz_resultados['num_solici']; ?>','Cargando',false,false);
}
" ></div>

  <?php
}//FIN TRASLADOA CENTRO HOSPITALARIO
?>