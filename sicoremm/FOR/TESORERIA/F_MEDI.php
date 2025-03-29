<script type="text/javascript">
$(document).ready(function() {


$('#borrar_med').click(function(){
	$('input[name=boleta]').val('');
	$('input[name=folio]').val('');
	$('input[name=nro_doc]').val('');
	$('input[name=protocolo]').val('');
	$('input[name=num_solici]').val('');
        $('input[name=ff_f_inicio]').val('');
        $('input[name=ff_f_termino]').val('');
 });


$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

$('#ajax #F_MED').submit(function(){

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
include_once('../../CLA/Datos.php');
include_once('../../CLA/Select.php');
?>
<h1>COPAGOS</h1>

<div class="caja_cabezera">&zwnj;</div>


<form action="REPO/NoReg.php" method="post">
    <h1>COPAGOS AFILIADOS NO REGISTRADOS</h1>

    <strong>Desde</strong><input type="text" name="fechainicio" class="calendario" />&zwj;
    <strong>Hasta</strong><input type="text" name="fechatermino" class="calendario" />
    <input type="submit" value="Enviar" class="boton">

</form>


<form action="REPO/PAR.php" method="post">
    <h1>COPAGOS PARTICULARES</h1>

    <strong>Desde</strong><input type="text" name="fechainicio" class="calendario" />&zwj;
    <strong>Hasta</strong><input type="text" name="fechatermino" class="calendario" />
    <input type="submit" value="Enviar" class="boton">

</form>

<form action="REPO/EMP.php" method="post">
    <h1>COPAGOS CONVENIOS EMPRESAS</h1>

    <strong>Desde</strong><input type="text" name="fechainicio" class="calendario" />&zwj;
    <strong>Hasta</strong><input type="text" name="fechatermino" class="calendario" />
    <input type="submit" value="Enviar" class="boton">

</form>


<form action="REPO/MED.php" method="post">
    <h1>Entrega Mensual MEDIMEL</h1>

    <strong>Desde</strong><input type="text" name="fechainicio" class="calendario" />&zwj;
    <strong>Hasta</strong><input type="text" name="fechatermino" class="calendario" />
    <input type="submit" value="Enviar" class="boton">

</form>



<form action="upload.php" method="post" enctype="multipart/form-data">
    <h1>Carga de Afiliados MEDIMEL </h1>
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
    <input name="userfile" type="file">
    <input type="submit" value="Enviar" class="boton">

</form>

<h1>Busquedas</h1>

<form action="INT/M_TESO_MED.php" method="post" id="F_MED" name="F_AUDI">
<input type="text" name="ff_listado_med" value="1" style="display:none;" />
<div class="caja">
<table>
<tr>
<td>
    <strong>N BOLETA</strong>
    <input type="text" name="boleta" maxlength="10" size="6"/>
</td>


<td>
    <strong>N FOLIO</strong>
    <input type="text" name="folio_med" maxlength="11" size="6" />
</td>

<td>
    <strong>N RUT</strong>
    <input type="text" name="nro_doc" maxlength="11" size="6" />
</td>


<td>
    <strong>PROTOCOLO</strong>
    <input type="text" name="correlativo" maxlength="11" size="6" />
</td>
   
<td>
    <strong>N CONTRATO</strong>
    <input type="text" name="num_solici" maxlength="11" size="6" />
</td>
</tr>

</table>

<br />

    <div>
    <strong>PERIODO</strong>
    <input type="text" name="ff_f_inicio" maxlength="10" size="10" class="calendario" />
    &zwj;<strong> A </strong>&zwj;<input type="text" name="ff_f_termino" maxlength="10" size="10" class="calendario" />

    <strong>EMPRESA</strong>&zwnj;

    <?php
    $empresa = "SELECT empresa, nro_doc FROM empresa";
    $empresa_q = mysql_query($empresa);
    echo '<select name="empresa">';
    echo '<option value="TODOS">TODOS</option>';
    while ($emp = mysql_fetch_array($empresa_q)){
    
        echo '<option value="'.$emp['nro_doc'].'">'.$emp['empresa'].'</option>';
    }
    echo '</select>';
    ?>

    </div>


<div align="right">
<!--    <input class="boton" type="button" id="borrar_med" value="Borrar"/>&zwj;-->
    <input type="submit" value="Buscar" class="boton" />
</div>

</div>
<div class="caja_cabezera">&zwj;</div>
<div class="caja" id="ajax3"></div>
</form>