<script type="text/javascript">
$(document).ready(function() {

$('#borrar2').click(function(){
	$('input[name=titular]').val('');
	$('input[name=nro_doc]').val('');
	$('input[name=num_solici]').val('');
	$('input[name=nombre1]').val('');
	$('input[name=apellido]').val('');
});

 $('#ing').click(function() {

	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });


$('#busq_cont1').submit(function(){

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
//include_once('../DAT/conf.php');
//include_once('../DAT/bd.php');
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>

<div id="ajax1">
<h1>BUSQUEDAS</h1>

<form action="INT/M_BUSQ_COB_1.php" method="post" name="busq_cont1" id="busq_cont1" >
<div class="caja_cabezera">

    <input type="text" value="1" style="display:none" name="bus_cont1" />

&nbsp;INGRESO

</div>

<div class="caja">

 <table style="width:auto;">

<tr>
 <td><strong>RUT TITULAR</strong></td>
 <td><input type="text" name="titular" /></td>

 <td><strong>N CONTRATO</strong></td>
 <td><input type="text" name="num_solici" /></td>

 <td><strong>RUT BENEFICIARIO</strong></td>
 <td><input type="text" name="nro_doc" /></td>
</tr>

<tr>
 <td><strong>NOMBRE 1</strong></td>
 <td><input type="text" name="nombre1" /></td>

 <td><strong>APELLIDOS</strong></td>
 <td><input type="text" name="apellido" /></td>
<td>
         <div class="caja_boton" align="right">
         <input type="submit" value="Buscar" class="boton">
         &nbsp;&nbsp;
         <input type="button" id="borrar2" class="boton" value="Borrar" />
     </div>
</td>
</tr>

</table>


</div>
</form>
</div>
<div class="caja_cabezera"></div>
<div id="ajax3" class="caja"></div>

