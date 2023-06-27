<?php
include('../conf.php');
include('../bd.php');

$busq =$_GET['busq'];

if ( isset($busq) ){
$con = "where diagnostico like '".$busq."%' and estado=1";
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
  <input type="button" value="Buscar" class="boton" onclick="$ajaxload('sintomas', 'Diagnostico/Editar.php?busq='+document.getElementById('busq').value,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" /></div></td>
</tr>
</table>

<table style="width:500px;">
<?php
$consulta = "select cod, diagnostico, estado from diagnostico ".$con."";
$query = mysql_query($consulta);

$num = mysql_num_rows($query);

if ( $num < 1){
	echo '<div class="mensaje"><img src="IMG/error.png" />&nbsp;No hay diagnosticos</div>';
}
else{
while ($matriz_resultados = mysql_fetch_array($query)){
?>

<tr>
<td class="celda2"><?php echo $matriz_resultados['cod']; ?></td><td class="celda2"><?php echo htmlentities($matriz_resultados['diagnostico']); ?></td><td class="celda2"><div align="center">

<input type="button" onclick="$ajaxload('sintomas', 'Diagnostico/Form_editar.php?cod=<?php echo $matriz_resultados['cod']; ?>','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" class="boton" value="Editar" /></div></td>
</tr>

<?php
}
?>
</table>
</div>
<?php
}
?>