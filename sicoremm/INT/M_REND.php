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

if (isset($_POST['rendicion'])){

    $sql = "SELECT
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
bancos.descripcion AS bancos,
t_credito.descripcion AS t_credito,
ventas_reg.fecha


FROM ventas_reg

LEFT JOIN vendedor ON vendedor.nro_doc = ventas_reg.vendedor
LEFT JOIN doc ON doc.num_solici = ventas_reg.num_solici AND doc.categoria='103'
LEFT JOIN contratos ON contratos.num_solici = ventas_reg.num_solici
LEFT JOIN f_pago ON f_pago.codigo = contratos.f_pago
LEFT JOIN empresa ON empresa.nro_doc = contratos.empresa
LEFT JOIN cat_venta ON cat_venta.codigo = ventas_reg.cat_venta

LEFT JOIN doc_f_pago ON contratos.doc_pago = doc_f_pago.numero
LEFT JOIN bancos ON bancos.codigo = doc_f_pago.banco
LEFT JOIN t_credito ON t_credito.codigo = doc_f_pago.t_credito
INNER JOIN pago_venta ON pago_venta.codigo = ventas_reg.pago_venta
WHERE ventas_reg.rendicion='".$_POST['rendicion']."'
GROUP BY ventas_reg.num_solici ";

$query = mysql_query($sql);

$num_ren = mysql_num_rows($query);

if($num_ren < 1){

?>
<div class="mensaje2">No existen Datos</div>

<?php
exit;
}

?>
<h1>RENDICION DIARIA N&ordm; <?php echo $_POST['rendicion']; ?></h1>
<table class="table2">
<tr>
    <th>Vendedor</th>
    <th>N Contrato</th>
    <th>T_Venta</th>
    <th>Total a Pagar</th>
    <th>Mand</th>
    <th>Conve</th>
    <th>F_PAGO_MENSUAL</th>
</tr>
<?php
while($rendicion = mysql_fetch_array($query)){
?>
<tr>
    <td><?php echo $rendicion['nombre1'].' '.$rendicion['apellidos'] ?></td>
    <td><?php echo $rendicion['num_solici']; ?></td>
    <td><?php echo substr($rendicion['c_venta'],0,4); ?></td>
    <td><?php echo $rendicion['locominion']; ?></td>
    <td><?php echo $rendicion['mandato']; ?></td>
    <td><?php echo $rendicion['empresa']; ?></td>
    <td><?php echo $rendicion['descripcion']; ?></td>
</tr>
<?php
}
?>
</table>

<h1>&zwnj;</h1>
<table class="table2">
<?php

$detalle_sql = "SELECT pago_venta.codigo,descripcion, COUNT(descripcion) AS num, SUM(ventas_reg.monto) AS monto
FROM pago_venta
LEFT JOIN ventas_reg ON ventas_reg.pago_venta = pago_venta.codigo AND ventas_reg.rendicion='".$_POST['rendicion']."'
JOIN contratos ON contratos.num_solici = ventas_reg.num_solici AND contratos.estado='500'
GROUP BY descripcion";

$detalle_query = mysql_query($detalle_sql);
$monto1=0;
$monto2=0;

while ($detalle = mysql_fetch_array($detalle_query)){

   if ($detalle['codigo'] == 20 || $detalle['codigo'] == 30 || $detalle['codigo'] == 40){
       $monto1 = $detalle['monto'];
       
   }
   if ($detalle['codigo'] == 10 || $detalle['codigo'] == 50){
       $monto2 = $detalle['monto'];
   }


?>

    <tr>
    <th><?php echo $detalle['descripcion']; ?></th>
    <td style="width:70px; text-align: right;"><?php echo $monto1; ?></td>
    <td style="width:70px; text-align: right;"><?php echo $monto2; ?></td>
    </tr>

<?php

$t_monto1 = $t_monto1 + $monto1;
$t_monto2 = $t_monto2 + $monto2;
$monto1=0;
$monto2=0;
}
?>
    
   <tr>
    <th>SUB TOTAL</th>
    <td style="width:70px; text-align: right;" class="mensaje1"><strong><?php echo $t_monto1; ?></strong></td>
    <td style="width:70px; text-align: right;" class="mensaje1"><?php echo $t_monto2; ?></td>
    </tr>

        <tr>
    <th>TOTAL</th>
    <th style="width:70px; text-align: right;"><?php echo ($t_monto1 + $t_monto2); ?></th>
    <th style="width:70px; text-align: right;">&zwj;</th>
    </tr>

</table>

<?php
$query3 = mysql_query($sql);
?>

<h1>&zwnj;</h1>
<table class="table">
<tr>
    <th>RUT</th>
    <th>Bol</th>
    <th>Contrato</th>
    <th>Vendedor</th>
    <th>T_Ven</th>
    <th>Banco</th>
    <th>Tarjeta</th>
    <th>Mand</th>
    <th>Conve</th>
    <th>SEC</th>
    <th>V_PLAN</th>
    <th>TOTAL</th>
    <th>PEND</th>
    <th>F_P_IN</th>
</tr>
<?php


$monto_1=0;
$monto_2=0;

while($rendicion2 = mysql_fetch_array($query3)){


   if ($rendicion2['cod_pago_venta'] == 20 || $rendicion2['cod_pago_venta'] == 30 || $rendicion2['cod_pago_venta'] == 40){
       $monto_1 = $rendicion2['monto'];
       

   }
   if ($rendicion2['cod_pago_venta'] == 10 || $rendicion2['cod_pago_venta'] == 50){
       $monto_2 = $rendicion2['monto'];
   }


?>
<tr>
    <td><?php $titular = new Datos; $titular->validar_rut($rendicion2['titular']);echo $titular->nro_doc; ?></td>
    <td><?php echo $rendicion2['n_documento']; ?></td>
    <td><?php echo $rendicion2['num_solici']; ?></td>
    <td><?php echo $rendicion2['nombre1'].' '.substr($rendicion2['apellidos'],0,1) ?></td>
    <td><?php echo substr($rendicion2['c_venta'],0,4); ?></td>
    <td><?php echo $rendicion2['bancos']; ?></td>
    <td><?php echo $rendicion2['t_credito']; ?></td>
    <td><?php echo $rendicion2['mandato']; ?></td>
    <td><?php echo $rendicion2['empresa']; ?></td>
    <td><?php echo $rendicion2['sec']; ?></td>
    <td style=" text-align: right;"><?php echo $rendicion2['monto']; ?></td>
    <td style=" text-align: right;"><?php echo $monto_1; ?></td>
    <td style=" text-align: right;"><?php echo $monto_2; ?></td>
    <td><?php echo $rendicion2['pago_venta']; ?></td>
    <td><?php $fe = new Datos; echo $fe->cambiaf_a_mysql($rendicion2['fecha']); ?></td>
</tr>


<?php

$t_mont1 = $t_mont1 + $monto_1;
$t_mont2 = $t_mont2 + $monto_2;

$monto_1 =0;
$monto_2 =0;
}
?>

<tr>
    <th>&zwj;</th>
    <th>&zwj;</th>
    <th>&zwj;</th>
    <th>&zwj;</th>
    <th>&zwj;</th>
    <th>&zwj;</th>
    <th>&zwj;</th>
    <th>&zwj;</th>
    <th>&zwj;</th>
    <th>&zwj;</th>
    <th style=" text-align: right;"></th>
    <th style=" text-align: right;"><?php echo $t_mont1; ?></th>
    <th style=" text-align: right;"><?php echo $t_mont2; ?></th>
     <th>&zwj;</th>
     <th>&zwnj;</th>
</tr>

</table>

<?php

$cheques_sql ="SELECT
ventas_reg.num_solici,
ventas_reg.n_che_tar,
ventas_reg.bancos,
DATE_FORMAT(ventas_reg.fecha_documento,'%d-%m-%Y') AS fecha_documento,
contratos.titular,
bancos.descripcion,
titulares.nombre1,
titulares.nombre2,
titulares.apellido,
pago_venta.descripcion AS f_pago

FROM ventas_reg
LEFT JOIN contratos ON contratos.num_solici = ventas_reg.num_solici
INNER JOIN bancos ON bancos.codigo = ventas_reg.bancos
INNER JOIN titulares ON titulares.nro_doc = contratos.titular
LEFT JOIN pago_venta ON ventas_reg.pago_venta = pago_venta.codigo AND ventas_reg.rendicion='".$_POST['rendicion']."'
WHERE ventas_reg.rendicion='".$_POST['rendicion']."' AND contratos.estado='500'";

//echo '<br />'.$cheques_sql.'<br />';


$cheques_query = mysql_query($cheques_sql);


?>

<h1>&zwj;</h1>

<table class="table2">

    <tr>
        <th>TITULAR CONTRATO</th>
        <th>N CHEQUE</th>
        <th>T_CHQUE</th>
        <th>FECHA</th>
        <th>BANCO</th>
    </tr>

    <?php
    while($cheques = mysql_fetch_array($cheques_query)){

    ?>
    <tr>
        
        
        <td><?php echo $cheques['nombre1'].' '.$cheques['apellido'];?></td>
        <td><?php echo $cheques['n_che_tar'];?></td>
        <td><?php echo $cheques['f_pago'];?></td>
        <td><?php echo $cheques['fecha_documento'];?></td>
        <td><?php echo $cheques['descripcion'];?></td>
    </tr>
    <?php
    }
    ?>
</table>

<?php

//<td><?php $titular = new Datos; $titular->validar_rut($cheques['titular']); echo $titular->nro_doc;</td>

?>





<?php
}
?>




<?php
/* cerrar conexion */
mysql_close($conexion);
?>
<br />
<div id="sub_1"></div>
