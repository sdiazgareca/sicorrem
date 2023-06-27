<script type="text/javascript">
$(document).ready(function() {

$('#borrar').click(function(){
	$('input[name=folio]').val('');
	$('input[name=vendedor]').val('');
	$('input[name=ff_entrega]').val('');
	$('input[name=nombre1]').val('');
	$('input[name=apellidos]').val('');
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
 
$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

});
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>
<h1>AUDITORIA DE CONTRATOS</h1>

<div class="caja_cabezera">AUDITORIA DE DOCUMENTOS</div>
<form action="INT/M_AUDI.php" method="post" id="F_AUDI" name="F_AUDI">
<input type="text" name="ff_folio_bus" value="1" style="display:none;" />
<div class="caja">
<table>
<tr>
<td><strong>RUT VENDEDOR</strong></td><td><input type="text" name="vendedor" /></td>

<td><strong>FOLIO</strong></td>
<td><input type="text" size="10" name="folio" maxlength="8" /></td>

<td><strong>F. ENTREGA</strong></td><td>
<input type="text" class="calendario" name="ff_entrega" maxlength="10" size="10" />
</td>

<td><strong>ESTADOS</strong></td><td>

<?php 
$estado ="SELECT detalle, codigo FROM e_doc";
$est_sq = mysql_query($estado);
?>

<select name="estado">
<?php 
while( $est = mysql_fetch_array($est_sq)){
	echo '<option value="'.$est['codigo'].'">'.$est['detalle'].'</option>';
}
?>
<option value="TODOS">TODOS</option>
</select>

</td>
</tr>
</table>
<div class="caja">
<table>
<tr>
	<td><strong>NOMBRE</strong></td>
	<td><input type="text" size="40" name="nombre1" /></td>
	<td><strong>APELLIDOS</strong></td>
	<td><input type="text" size="40" name="apellidos" /></td>
</tr>
</table>
</div>


<div align="right"><input type="submit" value="Buscar" class="boton" />
&nbsp;&nbsp;<input type="button" value="Borrar" class="boton" id="borrar" /></div>

<div align="left" id="link2">
<a href="FOR/VENTAS/F_BDOC.php" class="boton2">DOCUMENTOS</a>&nbsp;&nbsp;
</div>
</div>

</form>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>