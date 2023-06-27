<?php

include('../conf.php');
include('../bd.php');
?>
<div align="right" style="padding:0; margin:0px; font-size:12px">
Detalle Movil &nbsp;
<a href="#" onclick="javascript:cerrarPopup('DetalleAmb','')" class="boton1">
<img style="background-color:#F7F7F7" src="IMG/exclamation.png" width="16" height="16" />
</a>
</div>
<table align="center" style="width:400px">
<tr>
<td class="celda1">N</td>
<td class="celda1">Medico</td>
<td class="celda1">Paramedico</td>
<td class="celda1">Conductor</td>
</tr>
<?php
$num = $_GET['num'];
$con22 = "select numero as numerito from movilasig where numero ='".$num."'";
$res22 = mysql_query($con22);
while($mat=mysql_fetch_array($res22)){ 
?>
<tr>
<?php
$consultad = "select numero from movilasig where numero = '".$mat['numerito']."'";
$resultadosd = mysql_query($consultad);
while($matriz_resultados = mysql_fetch_array($resultadosd)){
?>
<td class="celda2"><?php echo $matriz_resultados ['numero']; ?></td>
<?php
}
?>
<?php
$consultad = "select nombre1, apellidos from personal,movilasig where medico = rut and numero = '".$mat['numerito']."'";
$resultadosd = mysql_query($consultad);
while($matriz_resultados = mysql_fetch_array($resultadosd)){
?>
<td class="celda2"><?php echo $matriz_resultados ['nombre1'].'&nbsp;'.$matriz_resultados ['apellidos']; ?></td>
<?php
}
?>
<?php
$consultad = "select nombre1, apellidos from personal,movilasig where paramedico = rut and numero = '".$mat['numerito']."'";
$resultadosd = mysql_query($consultad);
while($matriz_resultados = mysql_fetch_array($resultadosd)){
?>
<td class="celda2"><?php echo $matriz_resultados['nombre1'].'&nbsp;'.$matriz_resultados['apellidos']; ?></td>
<?php
}
?>
<?php
$consultad = "select nombre1, apellidos from personal,movilasig where conductor = rut and numero = '".$mat['numerito']."'";
$resultadosd = mysql_query($consultad);
while($matriz_resultados = mysql_fetch_array($resultadosd)){
?>
<td class="celda2"><?php echo $matriz_resultados['nombre1'].'&nbsp;'.$matriz_resultados['apellidos']; ?></td>
<?php
}
?>
</tr>
<?php
}
?>
</table>