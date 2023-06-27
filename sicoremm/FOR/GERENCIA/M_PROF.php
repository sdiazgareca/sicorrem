<script type="text/javascript">
$(document).ready(function() {

 $('#ing').click(function() {

	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });


$('#ing_PROF').submit(function(){
 	
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
<h1>PROFESIONES</h1>

<form action="INT/M_PROF.php" method="post" id="ing_PROF" name="ing_PROF" >
<div class="caja_cabezera">

&nbsp;INGRESO

</div> 

<div class="caja">
<input type="text" name="ff_bus_PROF" style="display:none" value="1" /> 
 <table style="width:auto;">

<tr>
 	<td>Codigo</td>
    <td><input type="text" name="codigo" size="5" /></td>
	<td>Profesion</td>
    <td><input type="text" name="descripcion" size="50" /></td>
 	<td><div class="caja_boton" align="right"><input type="submit" value="Buscar" class="boton">&nbsp;&nbsp;<input type="button" id="borrar" class="boton" value="Borrar" /></div></td>
</tr>

</table>

<div align="left" id="link2">
<a href="FOR/GERENCIA/F_PROF.php?listado=1" class="boton2" id="ing">INGRESO PROFESIONES</a>
</div>

</div>
</form>
</div>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>