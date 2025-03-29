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
include_once('../../CLA/Select.php');
?>
<h1>GESTI&Oacute;N EMPRESAS</h1>

<div class="caja_cabezera">EMPRESAS</div>
<form action="INT/M_CONV.php" method="post" id="F_AUDI" name="F_AUDI">
<input type="text" name="ff_folio_bus" value="1" style="display:none;" />
<div class="caja">
<table>
<tr>
<td><strong>ZO</strong></td><td><input type="text" name="ZO" maxlength="3" size="1" /></td>
<td><strong>SE</strong></td><td><input type="text" name="SE" maxlength="3" size="1" /></td>
<td><strong>MA</strong></td><td><input type="text" name="MA" maxlength="3" size="1" /></td>
<td><strong>NOMBRE</strong></td><td><input type="text" name="empresa" /></td>
<td><strong>GIRO</strong></td><td><?php 
$giro = new Select;
$giro->selectSimpleOpcion('giro','desc,codigo','desc','codigo','cod_giro','cod_giro','','TODOS');

?></td>

<td><div align="right"><input type="submit" value="Buscar" class="boton" /></div></td>
</tr>
</table>

<div align="left" id="link2">
<a href="FOR/CONVENIOS/F_EMPR.php" class="boton2">INGRESO EMPRESAS</a>&nbsp;&nbsp;
<a href="INT/M_CONV.php?listado=1" class="boton2">LISTADO</a>&nbsp;&nbsp;
</div>
</div>

</form>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>