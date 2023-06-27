<?php
include('../conf.php');
include('../bd.php');
if( (isset($_GET['rut'])) ){

$query1 = "update operador set estado='0' where rut='".$_GET['rut']."'";
$resultados1 = mysql_query($query1);
}
?>

<table style="width:500px;">
<tr>
<td class="celda1">N Usuario</td>
<td class="celda1">Nombres</td>
<td class="celda1">Apellidos</td>
<td class="celda1">Privilegios</td>
<td class="celda1">&nbsp;</td>
</tr>
<?php
$query = "select rut,clave,nombre1,nombre2,apellido,operador_privilegio.privilegio 
from operador
inner join operador_privilegio on operador_privilegio.cod = operador.privilegio
 where estado = 1";
$resultados = mysql_query($query);
while($matriz_resultados = mysql_fetch_array($resultados)){
?>
<tr>
<td class="celda3"><?php echo $matriz_resultados['rut']; ?></td>
<td class="celda3"><?php echo $matriz_resultados['nombre1']; ?>&nbsp;<?php echo $matriz_resultados['nombre2']; ?></td>
<td class="celda3"><?php echo $matriz_resultados['apellido']; ?></td>
<td class="celda3"><?php echo $matriz_resultados['privilegio']; ?></td>
<td class="celda3"><div align="right"><input type="button" class="boton" value="Eliminar" 

onclick="

if(confirm('Esta seguro de eliminar el usuario?')) {

$ajaxload('operadores', 'Operador/Eliminar_operador.php?rut=<?php echo $matriz_resultados['rut']; ?>','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);}"></div></td>
</tr>
<?php
}
mysql_close($conexion);
?>

</table>