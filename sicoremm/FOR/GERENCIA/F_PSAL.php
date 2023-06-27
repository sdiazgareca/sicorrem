<script type="text/javascript">
$(document).ready(function() {


$('.rut').Rut({
  on_error: function(){ alert('Rut incorrecto'); }
});


$('#ajax3 #ingVenFree').submit(function(){
 	
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
//include_once('../DAT/conf.php');
//include_once('../DAT/bd.php');
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>

<div id="ajax1">
<h1>INGRESO PREVISI&Oacute;N DE SALUD</h1>

<form action="INT/M_PSALU.php" method="post" id="ingVenFree" name="ingVenFree" >
<div class="caja_cabezera">

&nbsp;INGRESO

</div> 

<div class="caja">
 <table>
 <tr> 
 <td>
 <input type="text" name="ff_ing_psalu" style="display:none" value="1"/>
 <label for="ContactName">N&Uacute;MERO</label> <input type="text" name="nro_doc"/>
 </td>
 <td>
 <label for="ContactName">Nombre</label> <input type="text" name="descripcion"/>
 </td>
 <td>Abre
   <input type="text" name="reducido"/>
 </td>

 <td>Tipo 
   <?php 
$estado = new Select; 
$estado->selectSimple('tipo_obrasocial','tipo,codigo','tipo','codigo','tipo','tipo','NULL');
?>
</td>
</tr>
</table>
</div>
<div class="caja_boton" align="right"><input type="submit" value="Guardar" class="boton"></div>
</form>
</div>