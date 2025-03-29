<script type="text/javascript">
$(document).ready(function() {

 $('#ing').click(function() {

	var ruta = $(this).attr('href');	
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });

$('#ing_ipc').submit(function(){
 	
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
<h1>GIROS</h1>

<form action="INT/M_IPC.php" method="post" id="ing_ipc" name="ing_ipc" >
<div class="caja_cabezera">

&nbsp;INGRESO

</div> 

<div class="caja">
<input type="text" name="ff_ipc" value="1" style="display:none" /> 
 <table style="width:auto;">

  <tr>
<td>Mes</td>
    <td>
    <select name="MES"><strong>MES</strong>
		<option value=""></option>    	
<?php
    	 for ($i =1; $i < 13; $i ++){
    		echo '<option value="'.$i.'">'.$i.'</option>';
    	 }
    	?>
    </select>
    </td>
       
    <td>A&ntilde;o</td>
    <td><input type="text" name="ANIO" size="5" maxlength="4" /></td>

    <td><div class="caja_boton" align="right"><input type="submit" value="Buscar" class="boton"></div></td>
  </tr>



</table>

<div align="left" id="link2">
<a href="FOR/COBRANZA/F_IPC.php?listado=1" class="boton2" id="ing">INGRESO GIRO</a>
</div>

</div>
</form>

</div>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>