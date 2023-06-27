<script type="text/javascript">
$(document).ready(function() {

$('#ajax3 a:contains("Eliminar")').click(function() {
	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
 	return false;
});

$('#ajax3 a:contains("Editar")').click(function() {
	var ruta = $(this).attr('href');
 	$('#ajax4').load(ruta);
	$.ajax({cache: false});
 	return false;
});

});

</script>

<?php
include('../../DAT/conf.php');
include('../../DAT/bd.php');


//ELIMINA USUARIO Y PRIVILEGIOS

if($_GET['eliminar'] > 0){


    $del_usuario_sql ="DELETE FROM usuarios WHERE usuarios.cod_usuario='".$_GET['cod_usuario']."'";
    $del_privile_sql ="DELETE FROM privilegios_reg WHERE cod_usuario='".$_GET['cod_usuario']."'";

    $query1 = mysql_query($del_usuario_sql);
    $query2 = mysql_query($del_privile_sql);

}




//MUESTRA FROMULARIO
foreach ($_POST AS $campo=>$valor){

    if ($valor != "" && $campo != "guardar_usuario"){

        if($campo == 'cod_usuario'){
            $condicion = $condicion.' '.$campo.' ="'.$valor.'" AND ';
        }
        else{
            $condicion = $condicion.' '.$campo.' LIKE "'.$valor.'%" AND ';
        }
    }

}

if ($condicion != ""){

    $condicion = substr ($condicion, 0, strlen($condicion) - 4);

    $where = ' WHERE '.$condicion;
    
}

$usuario_sql = "SELECT usuarios.cod_usuario, nombre, apellido FROM usuarios ".$where;

$usuario_query = mysql_query($usuario_sql);

echo '<table class="table2">';

    echo '<tr>';
    echo '<th>Codigo</th>';
    echo '<th>Nombre</th>';
    echo '<th>Apellidos</th>';
    echo '<th></th>';
    echo '<th></th>';
    echo '</tr>';

while($usuario = mysql_fetch_array($usuario_query)){

    echo '<tr>';
    echo '<td>'.$usuario['cod_usuario'].'</td>';
    echo '<td>'.$usuario['nombre'].'</td>';
    echo '<td>'.$usuario['apellido'].'</td>';
    echo '<td><a href="FOR/ADMIN/GEST2.php?editar=1&cod_usuario='.$usuario['cod_usuario'].'">Editar</a></td>';
    echo '<td><a href="FOR/ADMIN/GEST.php?eliminar=1&cod_usuario='.$usuario['cod_usuario'].'">Eliminar</a></td>';
    echo '</tr>';

}
echo '</table>';

echo '<div id="ajax4"></div>';
?>
