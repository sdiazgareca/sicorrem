<script type="text/javascript">
$(document).ready(function() {

$('#guardar_usuario').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#ajax3').html(data);}})

	url_ajax ="";
	data_ajax="";

	return false;});

});
</script>
<br />
<h1>Gestor de Usuarios</h1>

<form action="FOR/ADMIN/GEST.php"  method="post" id="guardar_usuario">
    <table class="table2">
        <tr>
            <td>C&oacute;digo</td>
            <td><input type="text" name="cod_usuario" size="5" /></td>
            <td style="display:none;"><input type="text" name="guardar_usuario" value="1" /></td>

            <td>Nombres</td>
            <td><input type="text" name="nombre" /></td>

            <td>Apellidos</td>
            <td><input type="text" name="apellido" /></td>
            <td><input type="submit" value="Buscar" class="boton" /></td>
        </tr>

    </table>
</form>
<br />

<div id="ajax3"></div>