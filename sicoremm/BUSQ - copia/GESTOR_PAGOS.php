<script type="text/javascript">
$(document).ready(function() {

$('#pago_men2').submit(function(){

	 if(!confirm(" Esta seguro de efectuar el pago?")) {
		  return false;}

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#cont1').html(data);}})

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


  if ($_GET['f_cop'] == 'N_Credito'){
    echo 'N Credito';
}


  if ($_GET['f_cop'] == 'REMPLAZOS'){

      $cta_sql = "SELECT cta.cod_mov as cod_mov_afectada,contratos.factu,contratos.ZO, contratos.SE, contratos.MA,cobrador,cta.tipo_comp, serie, comprovante, DATE_FORMAT(fecha_mov,'%d-%m-%Y') AS fecha_mov,DATE_FORMAT(fecha_vto,'%d-%m-%Y') AS fecha_vto ,debe, haber, t_mov.corta, afectacion, importe

        FROM cta

        LEFT JOIN  t_mov ON t_mov.codigo = cta.cod_mov
        LEFT JOIN contratos ON contratos.num_solici ='".$_GET['CONTRATO']."' AND contratos.titular = '".$_GET['RUT']."'
        LEFT JOIN f_pago ON f_pago.codigo = contratos.estado

        WHERE cta.num_solici = '".$_GET['CONTRATO']."' AND cta.nro_doc='".$_GET['RUT']."'

        ORDER BY fecha_mov DESC";


 $cta_query = mysql_query($cta_sql);

 ?>
<form action="BUSQ/M_BUSQ_COB_1.php" method="post" id="pago_men2">

<table class="table2">

<tr>
    <th>&zwj;</th>
    <th>&zwj;</th>
<th>&zwj;</th>
<th>&zwj;</th>
<th>&zwj;</th>
<th>&zwj;</th>
</tr>

<tr>
<td><strong>Comprobante Ant</strong></td>
<td><input type="text" name="comp_ante" /></td>

<td><strong>Nuevo Comprobante</strong></td>
<td><input type="text" name="comprobante" /></td>

<td><strong>COBRADOR</strong></td><td>
<select name="cobrador">
<?php

$cob_sql ="SELECT cobrador.nombre1, cobrador.apellidos, cobrador.codigo, cobrador.nro_doc FROM cobrador WHERE cobrador.nro_doc != '".$cob_asignado['nro_doc']."' ORDER BY codigo";
$cob_query = mysql_query($cob_sql);
?>

    <option value="<?php echo $cob_asignado['codigo']; ?>"><?php echo $cob_asignado['codigo'].' '.$cob_asignado['apellidos'].' '.$cob_asignado['nombre1']; ?></option>

 <?php
 while($cob = mysql_fetch_array($cob_query)){
 ?>
    <option value="<?php echo $cob['codigo']; ?>"><?php echo $cob['codigo'].' '.$cob['apellidos'].' '.$cob['nombre1']; ?></option>

<?php
}
?>
</select>

    <input style="display:none;" type="text" value="1" name="Mensualidad" />
    <input style="display:none;" type="text" value="<?php echo $_GET['CONTRATO']; ?>" name="CONTRATO" />
    <input style="display:none;" type="text" value="<?php echo $_GET['RUT']; ?>" name="RUT" />

</td>
<td><strong>Monto</strong></td>
<td><input type="text" name="monto" size="6" value="<?php echo $importe; ?>" /></td>




</tr>

<tr>
<td><strong>Tipo</strong></td>
<td>
    <select name="tipo_comp">

<?php

$tipo_sql ="SELECT codigo, corta, larga, operador FROM t_mov";
$tipo_query = mysql_query($tipo_sql);

 while($tip = mysql_fetch_array($tipo_query)){
 ?>
    <option value="<?php echo $tip['codigo']; ?>"><?php echo $tip['corta'].'-'.$tip['larga']; ?></option>

<?php
}
?>

    </select>
</td>
<td><strong>Fecha</strong></td>
<td><input class="calendario22" name="fecha" type="text" value="<?php echo date('d-m-Y'); ?>" size="10" /></td>
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

<td><strong>Afectacion</strong></td>
<td><input type="text" name="afectacion" /></td>

</tr>
</table>
    <div align="right"> <input type="submit" value="Guardar" class="boton" /> </div>
</form>
<?php
}



if ($_GET['f_cop'] == 'Mensualidad'){



$cta_sql = "SELECT cta.cod_mov as cod_mov_afectada,contratos.factu,contratos.ZO, contratos.SE, contratos.MA,cobrador,cta.tipo_comp, serie, comprovante, DATE_FORMAT(fecha_mov,'%d-%m-%Y') AS fecha_mov,DATE_FORMAT(fecha_vto,'%d-%m-%Y') AS fecha_vto ,debe, haber, t_mov.corta, afectacion, importe
    FROM cta
        LEFT JOIN  t_mov ON t_mov.codigo = cta.cod_mov
        LEFT JOIN contratos ON contratos.num_solici ='".$_GET['CONTRATO']."' AND contratos.titular = '".$_GET['RUT']."'
        LEFT JOIN f_pago ON f_pago.codigo = contratos.estado

        WHERE cta.num_solici = '".$_GET['CONTRATO']."' AND cta.nro_doc='".$_GET['RUT']."' AND cta.num_solici='".$_GET['CONTRATO']."'

        AND (cod_mov = '1' || cod_mov = '98' || cod_mov = '99' || cod_mov = '100' || cod_mov = '101')

        AND afectacion = 0 ORDER BY fecha_mov DESC";



 $cta_query = mysql_query($cta_sql);

 ?>
<form action="BUSQ/M_BUSQ_COB_1.php" method="post" id="pago_men2">

<table class="table2">

<tr>
<th>Rendicion</th>
<th><input type="text" name="rendicion"  /></th>
<th>&zwj;</th>
<th>&zwj;</th>
<th>&zwj;</th>
<th>&zwj;</th>
</tr>

<tr>
<td><strong>CUOTA</strong></td><td>
<select name="n_documento">
<?php
 while($cta = mysql_fetch_array($cta_query)){
 ?>
    <option value="<?php echo $cta['comprovante'].'/'.$cta['fecha_mov'].'/'.$cta['fecha_vto'].'/'.$cta['cod_mov_afectada']; ?>"><?php echo $cta['comprovante'].' - '.$cta['fecha_mov'].' - $ '.$cta['importe']; ?></option>

<?php

$importe = $cta['importe'];
$factu = $cta['factu'];
$fecha_mov = $cta['fecha_mov'];

}

$cob_asignado_sql = "SELECT cobrador.nro_doc, cobrador.codigo, cobrador.nombre1, cobrador.apellidos FROM
                    contratos
                    INNER JOIN ZOSEMA ON ZOSEMA.ZO =  contratos.ZO AND ZOSEMA.SE =  contratos.SE AND ZOSEMA.MA = contratos.MA
                    INNER JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador AND num_solici ='".$_GET['CONTRATO']."'";

$cob_asignado_query = mysql_query($cob_asignado_sql);

$cob_asignado = mysql_fetch_array($cob_asignado_query);

?>
</select>
</td>
<td><strong>COBRADOR</strong></td><td>
<select name="cobrador">
<?php

$cob_sql ="SELECT cobrador.nombre1, cobrador.apellidos, cobrador.codigo, cobrador.nro_doc FROM cobrador WHERE cobrador.nro_doc != '".$cob_asignado['nro_doc']."' ORDER BY codigo";
$cob_query = mysql_query($cob_sql);
?>

    <option value="<?php echo $cob_asignado['codigo']; ?>"><?php echo $cob_asignado['codigo'].' '.$cob_asignado['apellidos'].' '.$cob_asignado['nombre1']; ?></option>

 <?php
 while($cob = mysql_fetch_array($cob_query)){
 ?>
    <option value="<?php echo $cob['codigo']; ?>"><?php echo $cob['codigo'].' '.$cob['apellidos'].' '.$cob['nombre1']; ?></option>

<?php
}
?>
</select>

    <input style="display:none;" type="text" value="1" name="Mensualidad" />
    <input style="display:none;" type="text" value="<?php echo $_GET['CONTRATO']; ?>" name="CONTRATO" />
    <input style="display:none;" type="text" value="<?php echo $_GET['RUT']; ?>" name="RUT" />

</td>
<td><strong>Monto</strong></td>
<td><input type="text" name="monto" size="6" value="<?php echo $importe; ?>" /></td>
</tr>

<tr>
<td><strong>Tipo</strong></td>
<td>
    <select name="tipo_comp">

<?php

$tipo_sql ="SELECT codigo, corta, larga, operador FROM t_mov WHERE operador ='H' AND codigo != '53' AND codigo != '60' AND codigo != '88' AND codigo != '91' AND codigo != '97' ";
$tipo_query = mysql_query($tipo_sql);

 while($tip = mysql_fetch_array($tipo_query)){
 ?>
    <option value="<?php echo $tip['codigo']; ?>"><?php echo $tip['corta'].'-'.$tip['larga']; ?></option>

<?php
}
?>

    </select>
</td>
<td><strong>Fecha</strong></td>
<td><input class="calendario22" name="fecha" type="text" value="<?php echo date('d-m-Y'); ?>" size="10" /></td>
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
<?php
}
?>


