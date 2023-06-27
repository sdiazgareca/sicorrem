<script type="text/javascript">
$(document).ready(function() {

$(function() {$(".calendario2").datepicker({ dateFormat: 'mm-yy' });});

$('#REND_M').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#ajax3').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});




$('#REND').submit(function(){

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

<h1>&zwnj;</h1>

<div class="caja_cabezera">Rendici&oacute;n</div>
<form action="INT/M_REND.php" method="post" name="REND" id="REND">
<div class="caja">
<table class="table2">
<tr>
<td><strong>Rendici&oacute;n</strong></td>
<td>
    <select name="rendicion" >
    <?php
    $sql = "SELECT rendicion FROM ventas_reg GROUP BY rendicion"; 
    $query = mysql_query($sql);
    while($rendicion = mysql_fetch_array($query)){
    ?>
        <option value="<?php echo $rendicion['rendicion']; ?>"><?php echo $rendicion['rendicion']; ?></option>
<?php
    }
    ?>
    </select>
</td>
<td><input type="submit" value="Ver" class="boton" /></td>
</tr>
</table>
    </div>
</form>


<form action="INT/M_REND_M.php" method="post" name="REND_M" id="REND_M">

<div class="caja">
<table class="table2">
<tr>
<td><strong>Rendici&oacute;n Mensual</strong></td>
<td>
<input type="text" class="calendario2" name="periodo" />
</td>
<td><input type="submit" value="Ver" class="boton" /></td>
</tr>
</table>
</div>
</form>


<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>