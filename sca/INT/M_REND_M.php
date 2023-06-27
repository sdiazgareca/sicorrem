<script type="text/javascript">
$(document).ready(function() {

$('#ff_edit_free1').submit(function(){

	 if(!confirm(" Esta seguro de guardar los cambios?")) {
		  return false;}
	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();
	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#ajax3').html(data);}})
	url_ajax ="";
	data_ajax="";
	return false;});


$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

$('#ajax3 a:contains("ELIMINAR")').click(function() {

 if(!confirm(" Esta seguro de eliminar el vendedor?")) {
	  return false;}
  else {
	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
}
});

$('#ajax3 a:contains("VER")').click(function() {
	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('#ajax3 a:contains("Volver")').click(function() {
	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});



$('#ajax3 a:contains("Editar")').click(function() {

	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('#ajax3 a:contains("Doc")').click(function() {

	var ruta = $(this).attr('href');
 	$('#sub_1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('#ajax3 a:contains("Vent")').click(function() {

	var ruta = $(this).attr('href');
 	$('#sub_1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
});

$('#ingVenCon').submit(function(){

	 if(!confirm(" Esta seguro de guardar los cambios?")) {
		  return false;}
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

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

echo $_POST['periodo'];

if (isset($_POST['periodo'])){

    $sql = "

SELECT
ventas_reg.monto,
ventas_reg.t_credito,
vendedor.nombre1,
vendedor.nombre2,
vendedor.apellidos,
vendedor.nro_doc AS vendedor,
ventas_reg.num_solici,
ventas_reg.sec,
ventas_reg.locominion,
ventas_reg.n_documento,
doc.folio AS mandato,
contratos.secuencia,
empresa.empresa,
ventas_reg.cat_venta,
cat_venta.descripcion AS c_venta,
pago_venta.descripcion,
f_pago.codigo,
f_pago.descripcion,
contratos.titular,
pago_venta.descripcion AS pago_venta,
pago_venta.codigo AS cod_pago_venta,
t_credito.descripcion AS t_credito,
DATE_FORMAT(ventas_reg.fecha,'%d-%m-%Y') AS fecha,
titulares.nombre1 AS nt,
titulares.apellido AS apt,
planes.desc_plan,
ventas_reg.n_documento as boleta


FROM ventas_reg

LEFT JOIN vendedor ON vendedor.nro_doc = ventas_reg.vendedor
LEFT JOIN doc ON doc.num_solici = ventas_reg.num_solici AND doc.categoria='103'
LEFT JOIN contratos ON contratos.num_solici = ventas_reg.num_solici
LEFT JOIN f_pago ON f_pago.codigo = contratos.f_pago
LEFT JOIN empresa ON empresa.nro_doc = contratos.empresa
LEFT JOIN cat_venta ON cat_venta.codigo = ventas_reg.cat_venta
INNER JOIN planes ON planes.cod_plan = ventas_reg.cod_plan AND planes.tipo_plan = ventas_reg.tipo_plan
LEFT JOIN doc_f_pago ON contratos.doc_pago = doc_f_pago.numero
INNER JOIN titulares ON titulares.nro_doc = contratos.titular
LEFT JOIN t_credito ON t_credito.codigo = doc_f_pago.t_credito
INNER JOIN pago_venta ON pago_venta.codigo = ventas_reg.pago_venta
WHERE contratos.estado='500' AND cat_venta ='100'
ORDER BY vendedor.nro_doc

";


$query = mysql_query($sql);
?>
<h1>CONTRATADOS</h1>
<table class="table2">
<tr>
    <th>Contrato</th>
    <th>Fecha</th>
    <th>Nombre Titular</th>
    <th>Vendedor</th>
    <th>Plan</th>
    <th>Plan</th>
    <th>Mand</th>
    <th>Pers.</th>
    
    <th>Boleta</th>
    <th>Pagado</th>
    <th>F. Pago</th>
    <th>Empresa</th>
</tr>
<?php
while($rendicion = mysql_fetch_array($query)){
?>
<tr>
    <td><?php echo $rendicion['num_solici']; ?></td>
    <td><?php echo $rendicion['fecha']; ?></td>
    <td><?php echo $rendicion['nt'].' '.$rendicion['apt']; ?></td>
    <td><?php echo $rendicion['nombre1'].' '.$rendicion['apellidos'] ?></td>
    <td><?php echo $rendicion['desc_plan']; ?></td>
    
    <td><?php echo $rendicion['monto']; ?></td>
    <td><?php echo $rendicion['mandato']; ?></td>
    <td><?php echo $rendicion['sec']; ?></td>
    
    <td><?php echo $rendicion['boleta']; ?></td>
    <td><?php echo $rendicion['monto']; ?></td>
    
    <td><?php echo $rendicion['descripcion']; ?></td>
    <td><?php echo $rendicion['empresa']; ?></td>
</tr>
<?php
}
?>
</table>




<?php
}
/* cerrar conexion */
mysql_close($conexion);
?>
<br />
<div id="sub_1"></div>
