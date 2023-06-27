<?php
include('../conf.php');
include('../bd.php');
?>

<table class="celda3">
<tr>
<td>
<div style="padding:5px;">

<table>
<tr>
<td>Contrato</td><td><input type="text" id="contrato" /></td>
<td>
<input type="button" value="Buscar" onclick="
if(
(!document.getElementById('contrato').value) || (document.getElementById('contrato').value < 1 )|| (isNaN(parseInt(document.getElementById('contrato').value)))){
alert('Debe Ingresar un valor');
}
else{
$ajaxload('info', 'atenciones/buscar_contrato.php?protocolo='+document.getElementById('contrato').value,false,false,false);
document.getElementById('protocolo').value = '';
document.getElementById('rut').value = '';
}"
class="boton"/>
</td>
</tr>

<tr>
<td>RUT</td>
<td><input type="text" id="rut" /></td>
<td>
<input type="button" value="Buscar" onclick="
if(
(!document.getElementById('rut').value) || (document.getElementById('rut').value < 1 )|| (isNaN(parseInt(document.getElementById('rut').value)))){
alert('Debe Ingresar un valor');
}
else{
$ajaxload('info', 'atenciones/buscar_rut.php?rut='+document.getElementById('rut').value,false,false,false);
document.getElementById('protocolo').value = '';
document.getElementById('contrato').value = '';

}" class="boton"/>
</td>
</tr>

<tr>
<td>Protocolo</td>
<td><input type="text" id="protocolo" /></td>
<td><input type="button" value="Buscar" onclick="
if(
(!document.getElementById('protocolo').value) || (document.getElementById('protocolo').value < 1 )|| (isNaN(parseInt(document.getElementById('protocolo').value)))){
alert('Debe Ingresar un valor');
}
else{
$ajaxload('info', 'atenciones/buscar_protocolo.php?protocolo='+document.getElementById('protocolo').value,false,false,false)
document.getElementById('rut').value = '';
document.getElementById('contrato').value = '';
};" class="boton"/>
</td>
</tr>

<tr>
<td>Convenio</td>
<td>
<select name="convenio" id="convenio">
<option value="">&nbsp;</option>
<?php
$convenio_2 = "SELECT cod_plan, desc_plan FROM planes_traslados";
$convio_query = mysql_query($convenio_2);
while ($convenio_tras = mysql_fetch_array($convio_query)){
?>
<option value="<?php echo $convenio_tras['cod_plan']; ?>"><?php echo $convenio_tras['desc_plan']; ?></option>
<?php
}
?>
</select>
</td>
<td>


<input type="button" value="Buscar" onclick="
if(!document.getElementById('convenio').value){
alert('Debe Ingresar un valor');
}
else{
$ajaxload('info', 'atenciones/buscar_convenio?convenio='+document.getElementById('convenio').value,false,false,false)
document.getElementById('rut').value = '';
document.getElementById('contrato').value = '';
};" class="boton"/>
</td>
</tr>


<tr>
<td>Fecha</td>
<td>
<select name="dia" id="dia">

<?php
for($i =1;$i < 32;$i ++){
?>
<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php
}

?>

</select>&nbsp;

<select name="mes" id="mes">
<?php
for($i =1;$i < 13;$i ++){
?>
<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php
}

?>

</select>&nbsp;

<select name="anio" id="anio">

<?php
for($i =2009;$i < (date('Y')+1);$i ++){
?>
<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php
}

?>

</select>

</td>
<td>
<input type="button" value="Buscar" onclick="
$ajaxload('info', 'atenciones/buscar_fecha?dia='+document.getElementById('dia').value+'&mes='+document.getElementById('mes').value+'&anio='+document.getElementById('anio').value,false,false,false);" class="boton"/>
</td>
</tr>
</table>



</div>
<?php
include('../conf.php');
include('../bd.php');



?>
<div id="info">

&nbsp;</div>
</td>
</tr>
</table>
