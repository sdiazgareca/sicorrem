<script type="text/javascript">
$(document).ready(function() {



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
include_once('../../CLA/Datos.php');
include_once('../../CLA/Select.php');
?>
<h1>CONTRATOS</h1>

<div class="caja_cabezera">CONTRATOS</div>


<form action="INT/M_CONT.php" method="post" id="F_AUDI" name="F_AUDI">
<input type="text" name="ff_listado" value="1" style="display:none;" />
<div class="caja">
<table>
<tr>
<td><strong>N CONTRATO</strong></td>
<td><input type="text" name="CONTRATO" maxlength="5" /></td>
<td><strong>RUT TITULAR</strong></td>
<td><input type="text" name="TITULAR" maxlength="11" /></td>

<td><div align="right"><input type="submit" value="Buscar" class="boton" /></div></td>
</tr>
</table>
</div>
<div class="caja_cabezera">DETALLE</div>
<div class="caja" id="ajax3"></div>
</form>