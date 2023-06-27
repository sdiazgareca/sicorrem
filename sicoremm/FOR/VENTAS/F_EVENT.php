
<script type="text/javascript">
$(document).ready(function() {

$(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

$('#ajax #M_EVENT2').submit(function(){

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
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>

<form action="INT/M_EVENT.php" method="post" name="M_EVENT2" id="M_EVENT2">

<div class="caja">

<input type="text" name="ff_ing" value="1" style="display:none"/>

<table>
<tr>

    <td><strong>N FACTURA</strong></td>
    <td><input type="text" name="codigo" /></td>
</tr>

<tr>
<td><strong>Fecha de Pago</strong></td><td><input type="text" name="fecha" class="calendario" /></td>

<td>
    <strong>Documento</strong>    
    <select name="docu">
    <?php

    $sql = "SELECT cod, descripcion FROM eventos_f";
    $query = mysql_query($sql);
    while ($bol = mysql_fetch_array($query)){
        echo '<option value="'.$bol['cod'].'">'.$bol['descripcion'].'</option>';
    }
    ?>  
    </select>

    &zwj;&zwnj;

    <strong>Monto</strong>
    <input type="text" name="monto" size="5" maxlength="15" />

</td>
</tr>

<tr>
    <td><strong>Cliente</strong></td>
    <td><input type="text" name="cliente" /></td>

    <td><strong>Direccion</strong>
    <input type="text" name="direccion" size="70" name="direccion" /></td>
</tr>


<tr>

    <td><strong>F.Pago</strong></td>
    <td><input type="text" name="fpago" /></td>
        <td><strong>Ciudad</strong>
    
        <?php
        $sql = "SELECT ciudad.codigo, ciudad.nombre FROM ciudad";
        $query = mysql_query($sql);
        ?>
        <select name ="ciudad">
            <?php
            while ( $ciudad = mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $ciudad['codigo'];?>"><?php echo $ciudad['nombre'];?></option>

            <?php
            }
            ?>
        </select>

    </td>
</tr>
    <tr>
    <td><strong>Categoria</strong></td>
    <td><select name="categoria">
            <option value="Evento">Evento</option>
            <option value="Traslado">Traslado</option>
            <option value="MEDIMEL">Mel</option>
        </select></td>


</tr>

</table>

<br />
<strong>Descripcion</strong>
<br />
<textarea rows="5" cols="60" name="descripcion" ></textarea>


<br />

<div align="right">
<input type="submit" value="Guardar" class="boton" />
</div>

</div>

</form>