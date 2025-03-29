<script type="text/javascript">
$(document).ready(function() {

	$('.rut').Rut({
	  	on_error: function(){ alert('Rut incorrecto'); }
	});


$('#borrar').click(function(){
	$('input[name=nro_doc]').val('');
	$('input[name=nombre1]').val('');
	$('input[name=apellidos]').val('');
});

$('#ajax #inco').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#inco2').html(data);}})

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

        <h1>VENDEDOR</h1>
	<form action="INT/M_INCO.php" method="post" id="inco">
        <?php
        $sql = "SELECT vend.nro_doc, vend.nombre1, vend.nombre2, vend.apellidos, vend.categoria FROM vend";
        $query = mysql_query($sql);
        echo "<select name='vendedor'>";

        while ($vend = mysql_fetch_array($query)){
            echo '<option value="'.$vend['nro_doc'].'">'.$vend['apellidos'].' '.$vend['nombre1'].' '.$vend['nombre2'].'</option>';
        }
        echo '</select>';
        ?>

	<h1>Contrato</h1>

	<table style="width:auto;">
	<tr>
	<td><strong>CONTRATO</strong></td>
	<td><input type="text" name="num_solici" /></td>
	<td><input type="submit" value="Comprobar" class="boton"></td>
	</table>
	</form>

        <div id="inco2"></div>