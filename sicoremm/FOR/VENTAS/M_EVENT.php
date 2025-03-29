<script type="text/javascript">
$(document).ready(function() {

$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

$('#borrar').click(function(){
	$('input[name=fecha]').val('');
	$('input[name=descripcion]').val('');
});

$('#ajax #M_EVENT').submit(function(){

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
	ruta ="";
 	return false;
 });
});
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>

<h1>EVENTOS</h1>

<div class="caja_cabezera">&zwnj;</div>
<form action="INT/M_EVENT.php" method="post" name="M_EVENT" id="M_EVENT">
<div class="caja">

<input type="text" name="ff_vend" value="1" style="display:none"/>

<table>
<tr>
    <td><strong>N FACTURA</strong></td><td><input type="text" name="cod" /></td>
<td><strong>Fecha</strong></td><td><input type="text" name="fecha" class="calendario" /></td>
<td><strong>Descripcion</strong></td><td><input type="text" name="descripcion" size="30" /></td>
<td><strong>Documento</strong></td>
<td>
<select name="docu">
    <?php

    $sql = "SELECT cod, descripcion FROM eventos_f";
    $query = mysql_query($sql);
     echo '<option value="TODOS">TODOS</option>';
    while ($bol = mysql_fetch_array($query)){
        echo '<option value="'.$bol['cod'].'">'.$bol['descripcion'].'</option>';
    }
    
    ?>
</select>
</td>
<td><input type="submit" value="Buscar" class="boton" /></td>
<td><input type="button" value="Borrar" class="boton" id="borrar" /></td>
</tr>
</table>



<div align="left" id="link">
<a href="FOR/VENTAS/F_EVENT.php" class="boton2">INGRESAR</a>
</div>
</div>

</form>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>