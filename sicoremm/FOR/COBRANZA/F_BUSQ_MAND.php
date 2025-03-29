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

 $(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

});
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>
<h1>&zwnj;</h1>

<div class="caja_cabezera">EMPRESAS</div>

<form action="BUSQ/M_BUSQ_MAND.php" method="post" id="F_AUDI" name="F_AUDI">
<input type="text" name="ff_folio_bus" value="1" style="display:none;" />
<div class="caja">

<table class="table">
<tr>
<td>
<strong>MANDATOS</strong>

<select name="CATEGORIA">
        <option value="BCI">MANDATO PAGO AUTOMATICO BCI</option>
        <option value="OB">MANDATO PAGO AUTOMATICO OB</option>
        <option value="BE">MANDATO PAGO AUTOMATICO BANCO ESTADO</option>
        
</select>

</td>

<td>

<strong>DIA DE PAGO</strong>

    <select name="d_pago">
        <option value="TODOS">TODOS</option>
        <option value="1">1</option>
        <option value="10">10</option>
        <option value="25">25</option>
    </select>

</td>


<td><strong>RUT CONTRATO</strong>
<input type="text" name="titular" />
</td>

</tr>
<tr>

<td>
    <strong>N CONTRATO </strong>
    <input type="text" name="num_solici" />
</td>

<td>
<strong>RUT TITULAR CUENTA </strong>
<input type="text" name="rut_titular_cta" />
</td>

<td>
<strong>PERIODO</strong> <input type="text" name="periodo" class="calendario" />
</td>

</tr>

<tr>
    <td>
        <strong>Banco</strong>

        <?php
        $sql ="SELECT bancos.codigo,bancos.descripcion,bancos.mandato FROM bancos";
        $banco_query = mysql_query($sql);
        ?>
        <select name="bancos">
            <option value=""></option>
        <?php
        while($bancos = mysql_fetch_array($banco_query)){
          ?>
            <option value="<?php echo $bancos['codigo'];?>"><?php echo $bancos['descripcion'];?></option>
          <?php
        }
        ?>
        </select>

    </td>

<td><strong>Estado</strong>

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

</tr>

</table>

</div>
<br />
    <div align="right"><input type="submit" value="Buscar" class="boton" />  <input type="button" id="borr" class="boton"  value="Borrar" /></div>
<br />
</form>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>