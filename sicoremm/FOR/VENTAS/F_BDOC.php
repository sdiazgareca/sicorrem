<script type="text/javascript">
$(document).ready(function() {

$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

$('#ajax3 form').submit(function(){
 	
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax3').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});
});
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>
<h1>AUDITORIA DE CONTRATOS</h1>

<div class="caja_cabezera">AUDITORIA DE DOCUMENTOS</div>
<form action="INT/M_AUDI.php" method="post" id="F_AUDI">

<input type="text" value="1" name="ff_folio_ing" style="display:none;" />

<div class="caja">
<table style="width:auto;">
<tr>
<td><strong>FOLIO</strong></td><td><input type="text" size="5" name="folio" maxlength="8" /></td>
<td><strong>VENDEDOR</strong></td>
<td>
<?php 
$vendedor = new Select; 
$vendedor->selectSimple('vendedor','apellidos,nro_doc','apellidos','nro_doc','vendedor','vendedor','NULL');

?></td>
<td><strong>ESTADO</strong></td>
<td>
<?php 
$estado = new Select; 
$estado->selectSimple('e_doc','detalle, codigo','detalle','codigo','estado','estado','WHERE codigo != "500" && codigo != "600" && codigo != "700" ');
?></td>
</tr>
</table>

<table style="width:auto;">
<tr>
<td><strong>F. ENTREGA</strong></td>
<td><input type="text" class="calendario" maxlength="10" size="10" name="ff_entrega" /></td>
<td><strong>DOCUMENTO</strong></td>
<td>
<?php 
$estado = new Select; 
$estado->selectSimple('c_doc','detalle, codigo','detalle','codigo','categoria','categoria','');
?></td>
</tr>
</table>
<div align="right"><input type="submit" value="Guardar" class="boton" /></div>

</div>
</form>