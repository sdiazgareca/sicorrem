<script type="text/javascript">
$(document).ready(function() {

	$('#REND2').submit(function(){

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#factu_1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});



});
</script>

<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');
include_once('../CLA/Cobrador.php');
include_once('../CLA/Calendario.php');
?>

<h1>REND</h1>
<form action="RCOP/M_REND_DIARIA.php" method="post" id="REND2">
    <table class="table2">

        <tr>
            <td><?php $cob = new Cobrador(); $cob->SelectCobrador('cobrador','cobrador'); ?></td>
            <td><strong>Fecha</strong></td><td><?php $periodo = new Calendario(); $periodo->MuestraCalendatio('calendario',2,'periodo','periodo') ?></td>
            <td><strong>Rendicion</strong></td><td><input type="input" name="rendicion" /></td>
            <td><input type="submit" value="Ver" class="boton"></td>
        </tr>

    </table>


</form>

<br />
<div id="factu_1" class="table" style="padding: 5px;">&zwnj;</div>


