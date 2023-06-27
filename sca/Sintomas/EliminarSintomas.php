<?php
include('../conf.php');
include('../bd.php');

$busq =$_GET['busq'];
$cod =$_GET['cod'];


if ( isset($cod) ){
$con = "update sintomas set estado='0' where cod='".$cod."' ";
$query1 = mysql_query($con);
}

if ( isset($busq) ){
$con = "where sintoma like '".$busq."%' and estado=1";
}
else{
$con = "where estado=1";
}
?>

<table style="width:500px;">
<tr>
<td class="celda3"><div align="right">
  <input type="text" name="busq" id="busq" />
  &nbsp;
  <input type="button" value="Buscar" class="boton" onclick="$ajaxload('sintomas', 'Sintomas/EditarSintomas.php?busq='+document.getElementById('busq').value,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" /></div></td>
</tr>
</table>

<table style="width:500px;">
<?php
$consulta = "select cod,sintoma,PreguntasClave,PreArribo,rojo,amarillo,verde,causas,observaciones from sintomas ".$con."";
$query = mysql_query($consulta);

$num = mysql_num_rows($query);

if ( $num < 1){
	echo '<div class="mensaje"><img src="IMG/error.png" />&nbsp;No hay sintomas</div>';
}
else{
while ($matriz_resultados = mysql_fetch_array($query)){
?>

<tr>
<td class="celda2"><?php echo $matriz_resultados['cod']; ?></td><td class="celda2"><?php echo htmlentities($matriz_resultados['sintoma']); ?></td><td class="celda2"><div align="center">

<input type="button" onclick="

if(confirm('Esta seguro de guardar los cambios?')) {
$ajaxload('sintomas', 'Sintomas/EliminarSintomas.php?cod=<?php echo $matriz_resultados['cod']; ?>','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);}" class="boton" value="Eliminar" /></div></td>
</tr>

<?php
}
?>
</table>
</div>
<?php
}
?>