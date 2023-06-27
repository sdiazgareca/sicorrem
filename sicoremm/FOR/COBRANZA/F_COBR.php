<script type="text/javascript">
$(document).ready(function() {


$('.rut').Rut({
  on_error: function(){ alert('Rut incorrecto'); }
});


$('#ajax3 #ingVenCon').submit(function(){

	 if(!confirm(" Esta seguro de guardar los cambios en el recaudador?")) {
		  return false;} 

 	
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) { 
	$('#ajax3').html(data);}}) 
	
	url_ajax ="";
	data_ajax="";
	
	return false;});

$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

});


</script>
<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>

<div id="ajax1">
<h1>INGRESO COBRADOR</h1>

<form action="INT/M_COBR.php" method="post" id="ingVenCon" name="ingVenCon" >
<div class="caja_cabezera">

&nbsp;Antecedentes Personales

</div> 

<div class="caja">
 <table>
 <tr> 
 <td>
  <input type="text" name="ff_ingreso" value="1" style="display:none"/>
 <label for="ContactName">COD</label> <input type="text" name="codigo" size="3" maxlength="3"/>
  <input type="text" name="ff_ingreso" value="1" style="display:none"/>
 <label for="ContactName">Nombre</label> <input type="text" name="nombre1"/>
 </td>
 <td>
 <label for="ContactName">Nombre 2</label> <input type="text" name="nombre2"/>
 </td>
 <td>
 <label for="ContactName">Apellidos</label> <input type="text" name="apellidos"/>
 </td>
 </tr>
 
 <tr>
 <td>
 <label for="ContactName">F. Nacimiento</label> <input type="text" name="ff_nac" class="calendario" maxlength="10" size="10" />
 </td>
 <td>
 <label for="ContactName">RUT</label> <input type="text" name="nro_doc" size="10" class="rut"/>
  <label for="ContactName">L.D.N</label> <input type="text" name="lnacimiento" size="10"/>
 </td>
 <td> <label for="ContactName">F. Inicio Contrato</label><input name="ff_inicio_cont" type="text" class="calendario" maxlength="10" size="10" /></td>
 </tr>
 
 <tr>
 <td> <label for="ContactName">P. de Salud</label>
 
  <?php $isapre = new Select; 
  $isapre->selectSimple('isapre','desc,codigo','desc','codigo','isapre','isapre','NULL');
  ?>
 
 </td>
 <td><label for="ContactName">A.F.P</label>
   <?php $afp = new Select; 
  $afp->selectSimple('AFP','desc,codigo','desc','codigo','afp','afp','NULL');
  ?>
 </td>
  <td><label for="ContactName">E. Civil</label> 
  <?php $ecivil = new Select; 
  $ecivil->selectSimple('civil','descripcion,codigo','descripcion','codigo','e_civil','e_civil','NULL');
  ?></td>  
 </tr>
 
 </table>
 
 <table>
 <tr>
 <td><label for="ContactName">Domicilio</label> <input type="text" size="50" name="domicilio"/></td>
 <td><label for="ContactName">Fono Fijo</label> <input type="text" name="fono" size="10" /></td>
 <td><label for="ContactName">Celular</label> <input type="text" name="celular" size="10"/></td>
 <td><label for="ContactName">Email</label> <input type="text" name="email" /></td>   
 </tr>
 </table>

</div>

<div class="caja_cabezera">&nbsp;En caso de Emergencia avisar a:</div>
<div class="caja">

 <table>
 <tr>
 <td><label for="ContactName">Nombre</label> <input type="text" name="emer_nombre"/></td>
 <td><label for="ContactName">Fono</label> <input type="text" name="emer_fono"/></td>
  <td><label for="ContactName">Celular</label> <input type="text" name="emer_celular"/></td>
 </tr>
 </table> 

</div>


<div class="caja_cabezera">&nbsp;Antecedentes del Contrato</div> 
<div class="caja">

<table>
<tr>

<td><label for="ContactName">Fecha Ultima Renovaci&oacute;n</label></td>

<td>
<?php $fecha = new Select; $fecha->selectFecha('ff_anio_reno','ff_mes_reno','ff_dia_reno','2001')?>
</td>
</tr>

</table>

<table>
<tr>
<td><label for="ContactName">Sueldo Base</label></td><td><input type="text" name="s_base" /></td>
<td><label for="ContactName">Otros</label></td><td><input type="text" name="otros" /></td>
</tr>
</table>

</div>

<div class="caja_cabezera">&nbsp;Otros</div> 
<div class="caja">

<table>
<tr>
<td><label for="ContactName">Alergico a:&nbsp;</label></td><td><input type="text" name="alerg" /></td>
<td><label for="ContactName">Grupo Sangu&iacute;neo</label></td><td><input type="text" name="g_san" /></td>
<td><label for="ContactName">Obervaciones</label></td><td><input type="text" name="obser" /></td>
</tr>
</table>

</div>

<div class="caja_boton"><input type="submit" value="Guardar" class="boton"></div>
</form>
</div>

