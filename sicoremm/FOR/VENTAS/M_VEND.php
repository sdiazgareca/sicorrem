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

<h1>VENDEDORES</h1>

<div class="caja_cabezera">Vendedores</div>
<form action="INT/M_VEND.php" method="post" name="M_VEND" id="M_VEND">
<div class="caja">
<table>
<tr>
<td><strong>Categor&iacute;a</strong></td>
<td>
 <input type="text" name="ff_vend" value="1" style="display:none"/>
<?php $vendedor = new Select; $vendedor->selectSimpleOpcion('v_cat','cod, v_cat.desc','desc','cod','codigo_cat','codigo_cat','NULL','TODOS');?></td>
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
<a href="FOR/VENTAS/F_VENF.php" class="boton2">FREE LANCE</a>
<a href="FOR/VENTAS/F_VCON.php" class="boton2">CONTRATADO</a>
</div>
</div>

</form>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>