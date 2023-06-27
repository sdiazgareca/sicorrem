
<script type="text/javascript">
$(document).ready(function() {

$('#ajax3 a').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax4').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('a:contains("Listado")').click(function() {
	var ruta = $(this).attr('href');	
 	$('#ajax4').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('#borrar1').click(function(){
	$('input[name=de]').val('');
	$('input[name=a]').val('');
	$('input[name=monto]').val('');
});

$('#bono').submit(function(){
 
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax4').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});
});
</script>

<?php
include('../../DAT/conf.php');
include('../../DAT/conf.php');
?>
<h1>Tabla de Comisiones Vendedores Contratados</h1>
<div class="caja_cabezera">Ingreso de Comisiones</div>
<div class="caja">
<form action="INT/M_BONO.php" method="post" id="bono">
<input type="text" name="ff_bono" value="1" style="display:none;"> 
<table>
<tr>
<td>De </td>
<td><input type="text" name="de"></td>
<td>Hasta </td>
<td><input type="text" name="a"></td>
<td>Valor</td>
<td><input type="text" name="monto"></td>
<td><input type="submit" class="boton" value="Agregar"></td>
<td><input type="button" class="boton" value="Borrar" id="borrar1"></td>
<td><a href="INT/M_BONO.php" class="boton">Listado</a></td>
</tr>
</table>
</form>
</div>

<div class="caja_cabezera">&nbsp;</div>
<div id="ajax4" class="caja">&nbsp;</div>
