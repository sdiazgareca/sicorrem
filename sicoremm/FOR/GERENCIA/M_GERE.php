<script type="text/javascript">
$(document).ready(function() {

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

});
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>
<h1>GESTI&Oacute;N PLANES</h1>

<div class="caja_cabezera">PLANES</div>
<form action="INT/M_PLAN.php" method="post" id="F_AUDI" name="F_AUDI">
<input type="text" name="ff_bus_plan" value="1" style="display:none;" />
<div class="caja">
<table>
<tr>
<td><strong>CODIGO</strong></td>
<td><input type="text" name="cod_plan" maxlength="3" size="3" /></td>
<td><strong>NOMBRE</strong></td>
<td><input type="text" name="desc_plan" size="40" /></td>
<td><strong>TIPO</strong></td>
<td>
<?php 
$estado = new Select; 
$estado->selectSimpleOpcion('tipo_plan','tipo_plan_desc,tipo_plan','tipo_plan_desc','tipo_plan','tipo_plan','tipo_plan','NULL','TODOS');
?></td>

<td><strong>F. ESTADO</strong></td>
<td>
<select name="estado">
<option value="TODOS">TODOS</option>
<option value="ACTIVO">ACTIVO</option>
<option value="INACTIVO">INACTIVO</option>
</select></td>
<td><div align="right"><input type="submit" value="Buscar" class="boton" /></div></td>
</tr>
</table>
<div align="left" id="link2">
<a href="FOR/GERENCIA/F_PLAN.php?listado=1" class="boton2">INGRESO PLANES</a>&nbsp;&nbsp;

<?php
/* TIPO DE PLANES */
$planes_sql = "SELECT tipo_plan, tipo_plan_desc AS pl FROM tipo_plan";
$planes_query = mysql_query($planes_sql);

while($planes = mysql_fetch_array($planes_query)){
echo '<a href="INT/M_PLAN.php?tipo_plan='.$planes['tipo_plan'].'&tipo_plan_desc='.$planes['pl'].'" class="boton2">'.strtoupper($planes['pl']).'</a>&nbsp;&nbsp;';
}

?>

</div>
</div>

</form>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>