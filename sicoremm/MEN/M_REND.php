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


	$('#REND3').submit(function(){

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#factu_1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});



        $('#REND4').submit(function(){

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#factu_1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});


	$('#REND5').submit(function(){

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#factu_1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

	$('#REND6').submit(function(){

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#factu_1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

	$('#REND7').submit(function(){

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#factu_1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});
            
	$('#REND10').submit(function(){

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

<h1>RECAUDACIONES COMISIONES Y PREMIOS</h1>
<form action="RCOP/M_REND_DETALLE2.php" method="post" id="REND2">
    <table class="table2">

        <tr>
            <td><?php $cob = new Cobrador(); $cob->SelectCobrador('cobrador','cobrador'); ?></td>
            <td><strong>Inicio Periodo</strong></td><td><?php $periodo = new Calendario(); $periodo->MuestraCalendatio('calendario',2,'periodo','periodo') ?></td>
            
            <td><strong>Cierre1</strong></td><td><?php $periodo->MuestraCalendatio('y',2,'cierre1','cierre1') ?></td>
          
            <td><strong>Cierre2</strong></td><td><?php $periodo->MuestraCalendatio('t',2,'cierre2','cierre2') ?></td>
            
            <td><strong>Cierre3</strong></td><td><?php $periodo->MuestraCalendatio('z',2,'cierre3','cierre3') ?></td>
            <td><input type="submit" value="Ver" class="boton"></td>
        </tr>

    </table>


</form>
<br />

<h1>RENDICION DIARIA RECAUDADORES</h1>
<form action="RCOP/M_REND_DIARIA_RECA.php" method="post" id="REND3">
    <table class="table2">

        <tr>

            <td><strong>Periodo Actual</strong></td><td><?php $periodo->MuestraCalendatio('calendario2',1,'periodo2','periodo2') ?></td>
            <td><strong>Fecha</strong></td><td><?php $periodo->MuestraCalendatio('calendario3',2,'fecha','fecha') ?></td>
            <td><input type="submit" value="Ver" class="boton"></td>
        </tr>

    </table>



</form>

<br />

<h1>RENDICION DIARIA RECAUDADORES DETALLE</h1>
<form action="RCOP/M_REND_DIARIA.php" method="post" id="REND4">
    <table class="table2">

        <tr>

            <td><?php $cob = new Cobrador(); $cob->SelectCobrador('cobrador','cobrador'); ?></td>
            <td><strong>Fecha</strong></td><td><?php $periodo->MuestraCalendatio('calendario99',2,'periodo9','periodo9') ?></td>
            <td><strong>Rendicion</strong></td><td><input type="input" name="rendicion" /></td>
            <td><input type="submit" value="Ver" class="boton"></td>
        </tr>

    </table>


</form>

<br />

<h1>INFORME GESTION COBRANZA</h1>
<form action="DOC/IGES.php" method="post">
    <table class="table2">

        <tr>
            <td><strong>Periodo Actual</strong></td><td><?php $periodo->MuestraCalendatio('periodo22',1,'periodo22','periodo22') ?></td>
            <td><strong>DEL</strong></td><td><?php $periodo->MuestraCalendatio('del',2,'del','del') ?></td>
            <td><strong>AL </strong></td><td><?php $periodo->MuestraCalendatio('al',2,'al','al') ?></td>
            <td><input type="submit" value="Ver" class="boton"></td>
        </tr>

    </table>


</form>


<br />

<h1>DETALLE INFORME GESTION COBRANZA CONVENIOS</h1>
<form action="DOC/IGES_DETALLE.php" method="post">
    <table class="table2">

        <tr>
            <td><strong>Periodo Actual</strong></td><td><?php $periodo->MuestraCalendatio('periodo90',1,'periodo90','periodo90') ?></td>
            <td><strong>DEL</strong></td><td><?php $periodo->MuestraCalendatio('del90',2,'del90','del90') ?></td>
            <td><strong>AL </strong></td><td><?php $periodo->MuestraCalendatio('al90',2,'al90','al90') ?></td>
            <td><input type="submit" value="Ver" class="boton"></td>
        </tr>

    </table>


</form>


<br />

<h1>INFORME DE EMISION</h1>
<form action="DOC/emi.php" method="post" id="REND17">
    <table class="table2">

        <tr>
            <td><strong>Periodo Actual</strong></td><td><?php $periodo->MuestraCalendatio('periodo4',1,'periodo4','periodo4') ?></td>
            <td><input type="submit" value="Ver" class="boton"></td>
        </tr>

    </table>

</form>

<br />




<h1>INFORME EMISION Y RECAUDACION FACTURAS ELECTRONICAS</h1>
<form action="DOC/IERFELEC.php" method="post">
    <table class="table2">

        <tr>

            <td><strong>Periodo Actual</strong></td>
            <td><?php $periodo->MuestraCalendatio('periodo20',2,'periodo20','periodo20') ?></td>
            <td><input type="submit" value="Ver" class="boton"></td>
        </tr>

    </table>



</form>



<br />
<div id="factu_1" class="table" style="padding: 5px;">&zwnj;</div>