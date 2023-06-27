<script type="text/javascript">
$(document).ready(function() {

$('#guardar_usuario').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#ajax1').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

});
</script>

<?php
include('../../DAT/conf.php');
include('../../DAT/bd.php');
?>
<br />
<h1>Ingreso de Usuarios</h1>

<form action="FOR/ADMIN/PRO.php"  method="post" id="guardar_usuario">
    <table class="table2">
        <tr>
            <td>C&oacute;digo</td>
            <td><input type="text" name="cod_usuario" size="5" /></td>
            <td style="display:none;"><input type="text" name="guardar_usuario" value="1" /></td>

            <td>Clave</td>
            <td><input type="text" name="clave1" type="password" /></td>

            <td>Repita Clave</td>
            <td><input type="text" name="clave2" type="password" /></td>
        </tr>

        <tr>
            <td>Nombres</td>
            <td><input type="text" name="nombre" /></td>

            <td>Apellidos</td>
            <td><input type="text" name="apellido" /></td>

        </tr>
        
    </table>

<br />

<h1>Permisos</h1>

<br />


<?php

$permisos_sql = "SELECT links.cod_linck, links.nombre AS nombre_link, links.cod_modulo, modulos.nombre AS nombre_modulo
                   FROM links
                   INNER JOIN modulos ON links.cod_modulo = modulos.cod_modulo";

$permisos_query = mysql_query($permisos_sql);

?>
<table class="table2">

    <tr>
        <th>Opci&oacute;n</th>
        <th>M&oacute;dulo</th>
        <th>&zwnj;</th>
    </tr>


<?php

$con = 0;

while($permisos = mysql_fetch_array($permisos_query)){
    ?>
    <tr>
        <td><?php echo $permisos['nombre_link']; ?></td>
        <td><?php echo $permisos['nombre_modulo']; ?></td>
        <td><input type="checkbox" name="<?php echo $con; ?>" value="<?php echo $permisos['cod_modulo'].'-'.$permisos['cod_linck']; ?>"></td>
</tr>
        <?php
    $con ++;
}
?>
    
</table>


<div align="right"><input type="submit" value="Guardar" class="boton" /></div>

</form>
