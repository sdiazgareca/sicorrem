<script type="text/javascript">
$(document).ready(function() {

	$("#REND2").submit(function(){

		var url_ajax = $(this).attr("action");
		var data_ajax = $(this).serialize();

		$.ajax({type: "POST",url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$("#factu_1").html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

	$("#REND3").submit(function(){

		var url_ajax = $(this).attr("action");
		var data_ajax = $(this).serialize();

		$.ajax({type: "POST",url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$("#factu_1").html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

$(function() {$(".calendario").datepicker({ dateFormat: 'mm-yy' });});

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

<h1>BUSCADOR COMP</h1>
<form action="RCOP/E_BOL.php" method="post" id="REND2">
    <table class="table2">

        <tr>
            <td><strong>N COMP PAGO</strong></td><td><input type="input" name="boleta" /></td>
            <td><input type="submit" value="Ver" class="boton"></td>
        </tr>

    </table>


</form>

<br />


<h1>GENERADOR DE MENSUALIDADES</h1>

<form action="RCOP/E_BOL.php" method="post" id="REND3">

<table class="table2">

<tr>
<th>Contrato</th>
<th><input type="text" name="num_solici"  /></th>
<th>RUT TITULAR</th>
<th><input type="text" name="nro_doc"  /> (sin dv)</th>
<th>PERIODO</th>
<th><input type="text" name="periodo" class="calendario"  />(mes-anio)</th>
</tr>

<tr>
<td><strong>N DOCUMENTO</strong></td>
<td><input type="text" name="comprobante"  /></td>
<td><strong>COBRADOR</strong></td><td>
<select name="cobrador">
<?php

$cob_sql ="SELECT cobrador.nombre1, cobrador.apellidos, cobrador.codigo, cobrador.nro_doc FROM cobrador WHERE cobrador.nro_doc != '".$cob_asignado['nro_doc']."' ORDER BY codigo";
$cob_query = mysql_query($cob_sql);
?>

    <option value="BUSCAR">BUSCAR</option>

 <?php
 while($cob = mysql_fetch_array($cob_query)){
 ?>
    <option value="<?php echo $cob['codigo']; ?>"><?php echo $cob['codigo'].' '.$cob['apellidos'].' '.$cob['nombre1']; ?></option>

<?php
}
?>
</select>

    <input style="display:none;" type="text" value="1" name="Mensualidad" />

</td>
<td><strong>Monto</strong></td>
<td><input type="text" name="monto" size="6" value="<?php echo $importe; ?>" /></td>
</tr>

<tr>
<td><strong>Tipo</strong></td>
<td>
    <select name="tipo_comp">

<?php

$tipo_sql ="SELECT codigo, corta, larga, operador FROM t_mov WHERE (codigo = '1' || codigo = '98' || codigo = '99') ORDER BY codigo";
$tipo_query = mysql_query($tipo_sql);

 while($tip = mysql_fetch_array($tipo_query)){
 ?>
    <option value="<?php echo $tip['codigo']; ?>"><?php echo $tip['corta'].'-'.$tip['larga']; ?></option>

<?php
}
?>

    </select>
</td>
<td><strong>Comprobante</strong></td>
<td>
<select name="t_comprobante">


<?php

$t_doc_sql ="SELECT codigo, descripcion, tipo_doc FROM t_documento WHERE t_documento.codigo != 150 AND t_documento.codigo != 400 AND t_documento.codigo != 500 AND t_documento.codigo != 600 AND tipo_doc != '".$factu."' ORDER BY tipo_doc";



$t_doc_query = mysql_query($t_doc_sql);
?>

    <option value="<?php echo $factu; ?>"><?php echo $factu; ?></option>
    <?php
 while($t_doc = mysql_fetch_array($t_doc_query)){
 ?>
    <option value="<?php echo $t_doc['tipo_doc']; ?>"><?php echo $t_doc['tipo_doc']; ?></option>

<?php
}
?>
</select>

</td>
</tr>
</table>
    <div align="right"> <input type="submit" value="Guardar" class="boton" /> </div>
</form>








<h1></h1>
<div id="factu_1" class="table" style="padding: 5px;">&zwnj;</div>

