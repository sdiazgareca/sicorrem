<script type="text/javascript">
$(document).ready(function() {

$('#ajax3 #ing2').submit(function(){
 	
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

<div id="ajax1">
<h1>INGRESO ZO - SE - MA</h1>

<form action="INT/M_ZOSEMA.php" method="post" id="ing2" name="ing2" >
<div class="caja_cabezera">

&nbsp;ZO - SE - MA</div> 

<div class="caja">

<input type="text" name="ff_ing" value="1" style="display:none" />
<table style="width:auto">
<tr>
<td>ZO</td><td><input type="text" name="ZO" size="5" maxlength="3" /></td>
<td>SE</td><td><input type="text" name="SE" size="5" maxlength="3" /></td>
<td>MA</td><td><input type="text" name="MA" size="5" maxlength="3" /></td>
<td>Descripci&oacute;n</td><td><input type="text" name="descripcion" size="60" maxlength="40" /></td>
</tr>
</table>

<div class="caja_boton" align="right"><input type="submit" value="Guardar" class="boton"></div>

</div>

</form>
