<script type="text/javascript">
$(document).ready(function() {

$('#borrar').click(function(){
	$('input[name=nro_doc]').val('');
	$('input[name=nombre1]').val('');
	$('input[name=apellidos]').val('');
});

$('#ajax #M_VEND').submit(function(){
 
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax3').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});

$('#ajax1 a').click(function() {
						  
 	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta ="";
 	return false;
 });
});
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>

<h1>COBRADORES</h1>

<div class="caja_cabezera">Cobradores</div>
<form action="INT/M_COBR.php" method="post" name="M_VEND" id="M_VEND">
<div class="caja">
<input type="text" name="ff_busq" value="1" style="display:none" />
<table>
<tr>
<td>COD</td><td><input type="text" name="codigo" size="4" /></td>
<td>RUT</td><td><input type="text" name="nro_doc" size="10" /></td>
<td>NOMBRE1</td><td><input type="text" name="nombre1" size="20" /></td>
<td>APELLIDOS</td><td><input type="text" name="apellidos" size="20" /></td>
</tr>
</table>

<div align="right">
<input type="submit" value="Buscar" class="boton" />
&nbsp;&nbsp;<input type="button" value="Borrar" class="boton" id="borrar" />
</div>

<div align="left" id="link">
<a href="FOR/COBRANZA/F_COBR.php" class="boton2">INGRESO COBRADOR</a>
</div>
</div>

</form>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>