<script type="text/javascript">

$(document).ready(function() {

$('#cambia_afi').submit(function(){

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


$sql = "SELECT afiliados.nro_doc,afiliados.nombre1, afiliados.nombre2, afiliados.apellido, 
    planes.cod_plan, planes.tipo_plan, planes.desc_plan, mot_baja.descripcion
FROM afiliados
LEFT JOIN planes ON planes.cod_plan = afiliados.cod_plan AND planes.tipo_plan = afiliados.tipo_plan
LEFT JOIN mot_baja ON mot_baja.codigo = afiliados.cod_baja
WHERE afiliados.num_solici='".$_POST['num_solici']."'";

$query = mysql_query($sql);
$num = mysql_num_rows($query);

if ($num > 0){

?>

<br />
<form method="post" action="INT/M_TESO_MED.php" id="cambia_afi">
<table class="table2">

    <tr>
        <th>PACIENTE</th>
        <th>C_PLAN</th>
        <th>T_PLAN</th>
        <th>PLAN</th>
        <th>ESTADO</th>
        <th>&zwnj;</th>
    </tr>

    <tr>
        <td><select name="afiliados">
<?php
while($afiliados = mysql_fetch_array($query)){

    $rut = new Datos;
    $rut->validar_rut($afiliados['nro_doc']);

    $cod_plan       = $afiliados['cod_plan'];
    $tipo_plan      = $afiliados['tipo_plan'];
    $desc_plan      = $afiliados['desc_plan'];
    $descripcion    = $afiliados['descripcion'];

    ?>
    <option value="<?php echo $afiliados['nro_doc'];?>"><?php echo $rut->nro_doc.'  '.$afiliados['nombre1'].' '.$afiliados['nombre2'].' '.$afiliados['apellido'];?></option>
    <?php
}

?>
</select>
        </td>
        <td><?php echo $cod_plan; ?></td>
        <td><?php echo $tipo_plan; ?></td>
        <td><?php echo $desc_plan; ?></td>
        <td><?php echo $descripcion; ?></td>
        <td style="display:none;"><input type="text" name="protocolo" value="<?php echo $_POST['protocolo'];?>"  /></td>
         <td style="display:none;"><input type="text" name="num_solici" value="<?php echo $_POST['num_solici'];?>"  /></td>
        <td style="display:none;"><input type="text" name="cambiar" value="1"  /></td>
        <td><input type="submit" value="Cambiar" class="boton"</td>
    </tr>
</table>
</form>
<?php
}
else{
    echo '<div class="mensaje2"> El numero de contrato ingresado no existe.</div>';
}
?>