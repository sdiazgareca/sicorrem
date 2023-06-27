<?php
include('../conf.php');
include('../bd.php');

$busq =$_GET['busq'];

if ( isset($busq) ){
$con = "and desc_plan like '".$busq."%'";
}
else{
$con = "";
}
?>

<table style="width:500px;">
<tr>
<td class="celda3"><div align="right">
  <input type="text" name="busq" id="busq" />
  &nbsp;
  <input type="button" value="Buscar" class="boton" onclick="$ajaxload('sintomas', 'PLANES_TRASLADOS/EditarPlanes.php?busq='+document.getElementById('busq').value,'<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" /></div></td>
</tr>
</table>

<table style="width:500px;">
<?php
$consulta = "select tipo_plan, cod_plan, desc_plan from planes_traslados where tipo_plan ='6' ".$con."";
$query = mysql_query($consulta);

$num = mysql_num_rows($query);

if ( $num < 1){
	echo '<div class="mensaje"><img src="IMG/error.png" />&nbsp;No hay planes</div>';
}
else{
while ($matriz_resultados = mysql_fetch_array($query)){
?>

<tr>
<td class="celda2"><?php echo $matriz_resultados['cod_plan']; ?></td><td class="celda2"><?php echo htmlentities($matriz_resultados['desc_plan']); ?></td><td class="celda2"><div align="center">

<input type="button" onclick="$ajaxload('sintomas', 'PLANES_TRASLADOS/Form_editar_planes.php?cod=<?php echo $matriz_resultados['cod_plan']; ?>','<div class=mensaje><p><img src=IMG/bigrotation2.gif/></p><p>Cargando</p></div>',false,false);" class="boton" value="Editar" /></div></td>
</tr>

<?php
}
?>
</table>
</div>
<?php
}
?>