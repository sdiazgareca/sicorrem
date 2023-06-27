
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

<h1>COMISIONES</h1>

<div class="caja_cabezera">Vendedores</div>
<div class="caja">


<div align="left" id="link">
<a href="FOR/VENTAS/F_CFRE.php" class="boton2">FREE LANCE</a>
<a href="FOR/VENTAS/F_CCON.php" class="boton2">CONTRATADO</a>
<a href="FOR/VENTAS/F_LOCO.php" class="boton2">LOCOMOCION</a>
</div>
</div>

</form>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>