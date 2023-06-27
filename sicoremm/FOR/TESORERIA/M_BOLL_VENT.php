<script type="text/javascript">
$(document).ready(function() {

$('#ajax #form2').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#inco2').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

$('#ajax a').click(function() {
	var ruta = $(this).attr('href');
 	$('#inco2').load(ruta);
	$.ajax({cache: false});
	ruta ="";
 	return false;
 });


});
</script>




<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>
<br />
<form action="BUSQ/M_BOLL.php" method="post" id="form2">

<table class="table2">

    <tr>
        <td><strong>Vendedor</strong></td>
        <td>
            <select name="vendedor">

                <?php
                $sql = "SELECT vendedor.nro_doc, vendedor.nombre1, vendedor.apellidos FROM vendedor";
                $query = mysql_query($sql);
                echo '<option value=""></option>';
                while($vendedor = mysql_fetch_array($query)){
                ?>
                <option value="<?php echo $vendedor['nro_doc']; ?>"><?php echo $vendedor['apellidos'].' '.$vendedor['nombre1']; ?></option>
                <?php
                }
                ?>
            </select></td>

            <td><strong>N Documento</strong></td>
            <td><input type="text" name="n_documento" size="7" /></td>

            <td><strong>Contrato</strong></td>
            <td><input type="text" name="num_solici" size="7" /></td>

            <td><strong>Del</strong></td>
            <td><input type="text" name="fecha1" size="10" /></td>

            <td><strong>Hasta</strong></td>
            <td><input type="text" name="fecha2" size="10" /></td>

            <td><input type="submit" value="Buscar" class="boton" /></td>
            <td><a href="BUSQ/M_BOLL_PROCESA.php?limpiar=1" class="boton">Limpiar</a></td>

    </tr>

</table>
</form>

<br />

<div id="inco2"></div>