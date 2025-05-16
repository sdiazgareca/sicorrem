<script type="text/javascript">
$(document).ready(function() {

    	$('#factu99').submit(function(){

		if(!confirm("Esta seguro de iniciar el proceso?")) {
			return false;
		 }

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#factu_1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

	$('#factu').submit(function(){

		if(!confirm("Esta seguro de iniciar el proceso?")) {
			return false;
		 }

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#factu_1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

	$('#factu2').submit(function(){

		if(!confirm("Esta seguro de iniciar el proceso?")) {
			return false;
		 }

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#factu_1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

	$('#factu3').submit(function(){

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#factu_1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

	$('#factu4').submit(function(){

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#factu_1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

 	$('#factu100').submit(function(){

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
?>

<h1>BOLETAS PARTICULARES</h1>
<form action="BUSQ/FACT_PAR.php" method="post" id="factu">
    <table class="table2">

        <tr>
            <td><strong>N BOLETA</strong></td><td><input type="text" name="boletas" /></td>
            <td><strong>Periodo</strong></td><td><input type="text" name="periodo" /></td>
            <td><strong>Ajuste</strong></td><td><input type="text" name="Ajuste" /></td>
            <td><input type="submit" value="Generar" class="boton"></td>
        </tr> 

    </table>


</form>

<h1>BOLETAS CONVENIOS</h1>
<form action="BUSQ/FACT_CONV_BOL.php" method="post" id="factu2">
    <table class="table2">
        <tr>
            <td><strong>N BOLETA</strong></td><td><input type="text" name="boletas" /></td>
            <td><strong>Periodo</strong></td><td><input type="text" name="periodo" /></td>
            <td><strong>Ajuste</strong></td><td><input type="text" name="Ajuste" /></td>
            <td><input type="submit" value="Generar" class="boton"></td>
        </tr>

    </table>


</form>

<br />
<h1>AREAS PROTEGUIDAS E-FAC</h1>
<form action="BUSQ/FACT_AP_FC.php" method="post" id="factu3">
    <table class="table2">
        <tr>
            <td><strong>Periodo</strong></td><td><input type="text" name="periodo" /></td>
            <td><input type="submit" value="Ver" class="boton"></td>
        </tr>

    </table>


</form>

<br />

<h1>PARTICULARES E-FAC</h1>
<form action="BUSQ/FACT_EFA_PAR.php" method="post" id="factu4">
    <table class="table2">
        <tr>
            <td><strong>Periodo</strong></td><td><input type="text" name="periodo" /></td>
            <td><input type="submit" value="Ver" class="boton"></td>
        </tr>

    </table>


</form>



<h1>FACTURAS ELECTRONICAS CONVENIOS</h1>
<form action="BUSQ/FACT_ELEC_CONV.php" method="post" id="factu100">
    <table class="table2">

        <?php

        $sql = "SELECT empresa.empresa, empresa.nro_doc, f_factu.breve
                FROM empresa
                INNER JOIN f_factu ON f_factu.codigo = empresa.f_factu
                WHERE empresa.f_factu = 2 || empresa.f_factu = 3 || empresa.f_factu = 4 || empresa.f_factu = 5";

        $query = mysql_query($sql);
        ?>

        <tr>
            <td><strong>Empresa</strong></td>
            <td>
                <select name="empresa">
                    <option value="0"></option>
                    <?php
                    while($empresa = mysql_fetch_array($query)){
                    echo '<option value="'.$empresa['nro_doc'].'">'.$empresa['empresa'].'</option>';
                    }
                    ?>
                </select>

            </td>
            <td><strong>N FACTURA</strong></td><td><input type="text" name="nfactu" /></td>
            <td><strong>Periodo</strong></td><td><input type="text" name="periodo" class="calendario" /></td>
            <td><strong>Ajuste</strong></td><td><input type="text" name="Ajuste" /></td>
            <td><input type="submit" value="Generar" class="boton"></td>
        </tr>

    </table>


</form>


<br />
<div id="factu_1" class="table" style="padding: 5px;">&zwnj;</div>
