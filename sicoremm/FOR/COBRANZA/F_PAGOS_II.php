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

  $(function() {$(".calendario2").datepicker({ dateFormat: 'dd-mm-yy' });});

});
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>
<h1>&zwnj;</h1>

<div class="caja_cabezera">PAGOS</div>



<form action="BUSQ/M_PAGOS_II.php" method="post" id="F_AUDI" name="F_AUDI">

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
<strong>PERIODO</strong><br /><br /> <input type="text" name="fecha_mov" class="calendario" />
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

<td style="display:none;">

    <?php
    $sql ="SELECT f_pago.codigo,f_pago.descripcion FROM f_pago WHERE f_pago.codigo = 400";
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

</tr>

<tr><td style="display:none;">
        
        <strong>TIPO_PAGO</strong>
    <br /><br />
          <select name="cod_mov">
        <?php
        $sql = "SELECT codigo, larga AS corta FROM t_mov WHERE t_mov.operador='H' AND t_mov.codigo!=60 AND t_mov.codigo!=88 AND t_mov.codigo!=90 AND  t_mov.codigo!=91 AND t_mov.codigo!=97 AND t_mov.codigo!=98 AND t_mov.codigo!=99 AND t_mov.codigo!=100 AND  t_mov.codigo!=101 ORDER BY corta";
        $query = mysql_query($sql);
        while($m_pago = mysql_fetch_array($query)){
            echo '<option value="'.$m_pago['codigo'].'">'.$m_pago['corta'].'</option>';
        }
            ?>
      </select>
    
    </td>

    <td>

        <strong>FECHA DE RENDICION</strong>
    <br /><br />
<input type="text" class="calendario2" name="fecha"/>
    </td>

        <td>

        <strong>COBRADOR</strong>
    <br /><br />

    <select name="cobrador">
    <?php
    $sqlcob = "SELECT cobrador.codigo, CONCAT(cobrador.codigo,' ',cobrador.apellidos,' ',cobrador.nombre1) AS cobrador
                FROM cobrador";

    $query = mysql_query($sqlcob);

    while($cob = mysql_fetch_array($query)){
        echo '<option value="'.$cob['codigo'].'">'.$cob['cobrador'].'</option>';
    }
    ?>
    </select>

    </td>

    <td>&zwj;</td>
</tr>


</table>
<br />
    <div align="right"><input type="submit" value="Buscar" class="boton" /></div>
    <br />
</div>


</form>

<div class="caja_cabezera">&zwnj;</div>
<div id="ajax3" class="caja"></div>