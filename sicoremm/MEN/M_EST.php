<script type="text/javascript">
$(document).ready(function() {

	$("form").submit(function(){

		var url_ajax = $(this).attr("action");
		var data_ajax = $(this).serialize();

		$.ajax({type: "POST",url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$("#factu_1").html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

});
</script>

<form action="DOC/Estadistica.php" method="">
    <h1>Ventas</h1>
    <table class="table2">
        <tr>
            <td><strong>Del</strong></td>
            <td><input type="text" name="del" class="calendario" /></td>
            <td><strong>Al</strong></td>
            <td><input type="text" name="al" class="calendario" /></td>
            <td><input type="submit" value="Ver" /></td>
        </tr>
    </table>
</form>
<br />

<form action="" method="">
<h1>Boletas Emitidas</h1>
<table class="table2">
          <tr>
            <td><strong>Periodo</strong></td>
            <td><input type="text" name="del" class="calendario" /></td>
            <td><input type="submit" value="Ver" /></td>
        </tr>
</table>
</form>
<br />

<form action="" method="">
<h1>Boletas Recaudadas</h1>
<table class="table2">
          <tr>
            <td><strong>Del</strong></td>
            <td><input type="text" name="del" class="calendario" /></td>
            <td><strong>Al</strong></td>
            <td><input type="text" name="al" class="calendario" /></td>
            <td><input type="submit" value="Ver" /></td>
        </tr>
</table>
</form>

<br />
<h2>FACTURAS ELECTRONICAS EN CONSTRUCCION</h2>
<br />

<div id="factu_1"></div>