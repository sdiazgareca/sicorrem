?????????

<script type="text/javascript">
$(document).ready(function() {

$('#borr').click(function(){
	$('input[name=titular]').val('');
	$('input[name=num_solici]').val('');
	$('input[name=rut_titular_cta]').val('');
        $('input[name=periodo]').val('');

});

$('#ajax #F_AUDI').submit(function(){

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

 $(function() {$(".calendario").datepicker({ dateFormat: 'mm-yy' });});

  $(function() {$(".calendario3").datepicker({ dateFormat: 'dd-mm-yy' });});

});
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>
<h1></h1>

<div class="caja_cabezera">PAGOS</div>

<form action="BUSQ/M_PAGOS.php" method="post" id="F_AUDI" name="F_AUDI">

<div class="caja">

<table class="table">
<tr>

    <td>
        <strong>RENDICION</strong><br /><br />
        <input type="text" name="rendicion" />
    </td>

<td>

<strong>DIA DE PAGO</strong><br /><br />

    <select name="d_pago">
        <option value=""></option>
        <option value="1">1</option>
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="25">25</option>
    </select>

</td>




<td>
<strong>PERIODO</strong><br /><br /> <input type="text" name="fecha_mov" class="calendario" size="7" />
</td>

<td>
<strong>ESTADO</strong><br /><br />

        <?php
        $sql_estado ="SELECT e_contrato.cod, e_contrato.descripcion FROM e_contrato WHERE cod > 300 ORDER BY descripcion";
        $estado_query = mysql_query($sql_estado);
        ?>
        <select name="estado">
            <option value=""></option>
        <?php
        while($estado = mysql_fetch_array($estado_query)){
        ?>
            <option value="<?php echo $estado['cod'];?>"><?php echo $estado['descripcion'];?></option>
          <?php
        }
        ?>
        </select>

</td>

<td>

    <?php
    $sql ="SELECT f_pago.codigo,f_pago.descripcion FROM f_pago WHERE f_pago.codigo < 300";
    $query = mysql_query($sql);
    ?>
    <strong>F_PAGO </strong><br /><br />

    <select name="f_pago">


    <?php

    while( $f_pago = mysql_fetch_array($query)){
        ?>
        <option value="<?php echo $f_pago['codigo'];?>"> <?php echo $f_pago['descripcion'];?> </option>
        <?php
    }
    ?>
    </select>
</td>


<td>
    <?php
    $sql ="SELECT codigo, descripcion FROM t_credito";
    $query = mysql_query($sql);
    ?>
    <strong>TARJETA </strong><br /><br /><select name="tarjeta">

    <option value=""></option>

    <?php

    while( $f_pago = mysql_fetch_array($query)){
        ?>
        <option value="<?php echo $f_pago['codigo'];?>"> <?php echo $f_pago['descripcion'];?> </option>
        <?php
    }
    ?>
    </select>
</td>


<td>
    <?php
    $sql ="SELECT bancos.codigo, bancos.descripcion FROM bancos";
    $query = mysql_query($sql);
    ?>
    <strong>BANCOS </strong><br /><br />

    <select name="bancos">

    <option value=""></option>

    <?php

    while( $f_pago = mysql_fetch_array($query)){
        ?>
        <option value="<?php echo $f_pago['codigo'];?>"> <?php echo $f_pago['descripcion'];?> </option>
        <?php
    }
    ?>
    <option value="MULTIBACO">MULTIBACO</option>
    </select>
</td>

<td>

    <strong>FECHA </strong><br /><br />

    <input type="text" name="fecha"  size="7" class="calendario3"/>

</td>




</tr>

</table>
<br />
    <div align="right"><input type="submit" value="Buscar" class="boton"  /></div>
    <br />
</div>


</form>
<div class="caja_cabezera">&zwnj;</div>
<div id="ajax3" class="caja"></div>