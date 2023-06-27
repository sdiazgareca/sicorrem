<?php

class Domicilio {
    //put your code here

    function Display($num_solici,$nro_doc,$div){


 $_GET['CONTRATO']=$num_solici;
$_GET['RUT'] = $nro_doc;

    $sql = 'SELECT tipo_dom.descripcion AS t_d_desc,pasaje,domicilios.tipo_dom as t_d,telefono,entre,piso,poblacion,tipo_dom.descripcion, calle,numero,piso,departamento,localidad,telefono,zona,seccion,manzana FROM domicilios
INNER JOIN tipo_dom ON tipo_dom.tipo_dom = domicilios.tipo_dom
WHERE num_solici="'.$_GET['CONTRATO'].'" AND nro_doc="'.$_GET['RUT'].'"';

    $query = mysql_query($sql);

    $i =0;

    While($domi = mysql_fetch_array($query)){
?>
<script type="text/javascript">
$(document).ready(function() {

    $('#editar_domi<?php echo $i; ?>').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('<?php echo $div; ?>').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

	$('.rut').Rut({
	  	on_error: function(){ alert('Rut incorrecto'); }
	});

});
</script>
<?
        ?>
<h1>Direcci&oacute;n <?php echo $domi['descripcion']; ?> CLA</h1>
<form action="BUSQ/M_BUSQ_SUB_1.php" metohd="post" id="editar_domi<?php echo $i; ?>" >
<table class="table2">
    <tr>
        <td><strong>CALLE/PASAJE</strong></td><td><input type="text" value="<?php echo $domi['calle']; ?>" name="calle" size="50"/></td>
        <td><strong>VILLA/POBLACION</strong></td><td><input type="text" value="<?php echo $domi['poblacion']; ?>" name="poblacion" size="50" /></td>
        <td><strong>NUMERO</strong></td><td><input type="text" value="<?php echo $domi['numero']; ?>" name="numero" size="5"/></td>
    </tr>

    <tr>
        <td><strong>DEPARTAMENTO</strong></td><td><input type="text" value="<?php echo $domi['departamento']; ?>" name="departamento" size="5" /></td>
        <td><strong>LOCALIDAD</strong></td><td><input type="text" value="<?php echo $domi['localidad']; ?>" name="localidad" /></td>
        <td><strong>PISO</strong></td><td><input type="text" value="<?php echo $domi['piso']; ?>" name="piso" size="5"/></td>

    </tr>
</table>


<br />

<table class="table2">

<tr>

        <td><strong>TIPO </strong></td>
        <td>
            <select name="tipo_dom">
              <option value="<?php echo $domi['t_d']; ?>"><?php echo $domi['t_d_desc']; ?></option>
              <?php 
                $sql33 ='SELECT tipo_dom.descripcion, tipo_dom.tipo_dom FROM tipo_dom WHERE tipo_dom.tipo_dom != "'.$domi['t_d'].'"';
                $query33 = mysql_query($sql33);
                while($q = mysql_fetch_array($query33)){
              ?>
              <option value="<?php echo $q['tipo_dom']; ?>"><?php echo $q['descripcion']; ?></option>
              <?php
                }
                ?>
            </select>
        </td>
        <td><strong>ENTRE</strong></td><td><input type="text" value="<?php echo $domi['entre']; ?>" name="entre" size="50" /></td>

        <td><strong>FONO</strong></td><td><input type="text" value="<?php echo $domi['telefono']; ?>" name="telefono" size="5" /></td>
</tr>

<tr style="display:none;">
    <td><input type="text" value="<?php echo $_GET['RUT']; ?>" name="nro_doc" /></td>
    <td><input type="text" value="<?php echo $_GET['CONTRATO']; ?>" name="num_solici" /></td>
    <td><input type="text" value="<?php echo $domi['t_d']; ?>" name="tipo_dom2" /></td>
    <td><input type="text" value="1" name="editar_direccion" /></td>
</tr>

</table>
<br />
<div align="right"><input type="submit" value="EDITAR" class="boton"/></div>
</form>
<br />
<?
$i ++;
    }


    }


}
?>
