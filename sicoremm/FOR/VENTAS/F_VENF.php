<script type="text/javascript">
$(document).ready(function() {


$('.rut').Rut({
  on_error: function(){ alert('Rut incorrecto'); }
});


$('#ingVenFree').submit(function(){
 	
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax3').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});

$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

});


</script>

<?php

include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>

<div id="ajax1">
<h1>INGRESO VENDEDORES FREE LANCE</h1>

<form action="INT/M_VEND.php" method="post" id="ingVenFree" name="ingVenFree" >
<div class="caja_cabezera">

&nbsp;Antecedentes Personales

</div> 

<div class="caja">
 <table>
 <tr> 
 <td>
 <input type="text" name="ff_freelance" style="display:none"/>
 <label for="ContactName">Nombre</label> <input type="text" name="nombre1"/>
 </td>
 <td>
 <label for="ContactName">Nombre 2</label> <input type="text" name="nombre2"/>
 </td>
 <td>
 <label for="ContactName">Apellidos</label> <input type="text" name="apellidos"/>
 </td>
 </tr>
 
 <tr>
 <td><label for="ContactName">F. Nacimiento</label> <input type="text" class="calendario" name="ff_nac" size="10" maxlength="10"/></td>
 
 <td><label for="ContactName">RUT</label> <input type="text" name="nro_doc" class="rut" size="10" /></td>
 
 </tr>
 </table>
 
 <table>
 <tr>
 <td><label for="ContactName">Domicilio</label> <input type="text" name="domicilio" size="50"/></td>
 <td><label for="ContactName">Fono Fijo</label> <input type="text" name="fono" size="10"/></td>
 <td><label for="ContactName">Celular</label> <input type="text" name="celular" size="10"/></td> 
 <td><label for="ContactName">Email</label> <input type="text" name="email" size="10"/></td>  
 </tr>
 </table>

</div>

<div class="caja_cabezera">&nbsp;Antecedentes Laborales</div>
 
<div class="caja">

<table>
<tr>
<td>Lugar de Trabajo</td><td><input type="text" name="t_lugar" /></td>
<td>Domicilio de Trabajo</td><td><input type="text" name="t_domicilio" /></td>
</tr>

<tr>
<td>Fono Trabajo</td><td><input type="text" name="t_fono" /></td>
<td>Celular Trabajo</td><td><input type="text" name="t_celular" /></td>
<td>Email Trabajo</td><td><input type="text" name="t_email" /></td>
</tr>

<tr>
<td>Funcionario ReMM <input type="checkbox" name="t_remm" value="1" /></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>

</div>
<div class="caja_boton"><input type="submit" value="Guardar" class="boton"></div>
</form>
</div>