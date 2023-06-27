<script type="text/javascript">
$(document).ready(function() {

$('#borrar').click(function(){
	$('input[name=nro_doc]').val('');
	$('input[name=descripcion]').val('');
});

$('#ajax #F_AUDI').submit(function(){
 	
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
	ruta = "";
 	return false;
 });

});
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>
<h1>GESTI&Oacute;N PREVISI&Oacute;N DE SALUD</h1>

<div class="caja_cabezera">PLANES</div>
<form action="INT/M_PSALU.php" method="post" id="F_AUDI" name="F_AUDI">
<input type="text" name="ff_bus_psalu" value="1" style="display:none;" />
<div class="caja">
<table>
<tr>
<td><strong>N&Uacute;MERO</strong></td>
<td><input type="text" name="nro_doc" /></td>
<td><strong>NOMBRE</strong></td>
<td><input type="text" name="descripcion" size="40" /></td>
<td><strong>TIPO</strong></td>
<td>
<?php 
$estado = new Select; 
$estado->selectSimpleOpcion('tipo_obrasocial','tipo,codigo','tipo','codigo','cod_tipo','cod_tipo','NULL','TODOS');
?></td>

<td><div align="right"><input type="submit" value="Buscar" class="boton" />&nbsp;&nbsp;<input type="button" value="Borrar" id="borrar" class="boton" /></div></td>
</tr>
</table>

<div align="left" id="link2">
<a href="FOR/GERENCIA/F_PSAL.php?listado=1" class="boton2">INGRESO PREVISI&Oacute;N DE SALUD</a>
</div>

</div>

</form>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>
