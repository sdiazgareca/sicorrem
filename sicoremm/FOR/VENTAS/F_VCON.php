<script type="text/javascript">
$(document).ready(function() {


$('.rut').Rut({
  on_error: function(){ alert('Rut incorrecto'); }
});


$('#ajax3 #ingVenCon').submit(function(){
 	
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
<h1>INGRESO VENDEDORES CONTRATADOS</h1>

<form action="INT/M_VEND.php" method="post" id="ingVenCon" name="ingVenCon" >
<div class="caja_cabezera">

&nbsp;Antecedentes Personales

</div> 

<div class="caja">
 <table>
 <tr> 
 <td>
  <input type="text" name="ff_contratado" value="1" style="display:none"/>
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
<td><label for="ContactName">Cargo Seg&uacute;n Contrato</label></td><td>

  <?php $ecivil = new Select; 
  $ecivil->selectSimple('cargo_vend','desc,codigo','desc','codigo','cargo','cargo','NULL');
  ?>

</td>
<td><label for="ContactName">Fecha Ultima Renovaci&oacute;n</label></td>

<td>
<input type="text" name="ff_renov_contr" class="calendario" maxlength="10" size="10" value="<?php echo date('d-m-Y');?>" />
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

