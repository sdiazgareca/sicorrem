<script type="text/javascript">
$(document).ready(function() {

$('#ajax3 a:contains("Quitar")').click(function() {
	var ruta = $(this).attr('href');
 	$('#ajax4').load(ruta);
	$.ajax({cache: false});
 	return false;
});

$('#ajax3 a:contains("Agregar")').click(function() {
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



if ($_GET['quitar'] > 0){
    
    $sql = "DELETE FROM privilegios_reg WHERE cod_registro='".$_GET['cod_registro']."' AND cod_modulo='".$_GET['cod_modulo']."' AND cod_link='".$_GET['cod_link']."' AND cod_usuario='".$_GET['cod_usuario']."'";
    $query2 = mysql_query($sql);

    //echo '<br />'.$sql.'<br />';
}

if($_GET['agregar'] > 0){
    $sql="INSERT INTO privilegios_reg (cod_modulo,cod_link,cod_usuario) VALUES('".$_GET['cod_modulo']."','".$_GET['cod_link']."','".$_GET['cod_usuario']."')";
    $query2 = mysql_query($sql);
    //echo '<br />'.$sql.'<br />';

}

$sql ="SELECT
links.nombre AS link,
modulos.nombre AS modulo,
cod_registro,
privilegios_reg.cod_modulo,
privilegios_reg.cod_usuario,
links.direccion,
links.cod_linck
FROM links
INNER JOIN modulos ON links.cod_modulo = modulos.cod_modulo
LEFT JOIN privilegios_reg ON privilegios_reg.cod_link = links.cod_linck AND privilegios_reg.cod_usuario='".$_GET['cod_usuario']."'";

//echo '<br />'.$sql.'<br />';

$query = mysql_query($sql);


echo '<h1></h1>';

$usuario_sql = "SELECT usuarios.cod_usuario, nombre, apellido FROM usuarios WHERE usuarios.cod_usuario='".$_GET['cod_usuario']."'";
$usuario_query = mysql_query($usuario_sql);
$usario = mysql_fetch_array($usuario_query);

echo '<br />';

echo '<h1>'.$usario['nombre'].' '.$usario['apellido'].'</h1>';

echo '<table class="table2">';

echo '<tr>';
echo '<th>Operacion</th>';
echo '<th>Modulo</th>';
echo '<th>Url</th>';
echo '<th></th>';
echo '</tr>';

while ($priv = mysql_fetch_array($query)){

    echo '<tr>';

    if ($priv['cod_registro'] > 0){
        echo '<td class="verde">'.$priv['link'].'</td>';
        echo '<td class="verde"><strong>'.$priv['modulo'].'</strong></td>';
    }
    else{
       echo '<td class="rojo">'.$priv['link'].'</td>';
       echo '<td class="rojo"><strong>'.$priv['modulo'].'</strong></td>';
    }

    echo '<td><strong>'.$priv['direccion'].'</strong></td>';

    if ($priv['cod_registro'] > 0){
        echo '<td><a class="boton2" href="FOR/ADMIN/GEST2.php?quitar=1&cod_usuario='.$_GET['cod_usuario'].'&cod_link='.$priv['cod_linck'].'&cod_modulo='.$priv['cod_modulo'].'&cod_registro='.$priv['cod_registro'].'">Quitar</a></td>';
    }

    else{
        echo '<td><a class="boton2" href="FOR/ADMIN/GEST2.php?agregar=1&cod_usuario='.$_GET['cod_usuario'].'&cod_link='.$priv['cod_linck'].'&cod_modulo='.$priv['cod_modulo'].'&cod_registro='.$priv['cod_registro'].'">Agregar</a></td>';
    }

    echo '</tr>';

}
echo '</table>';
?>
