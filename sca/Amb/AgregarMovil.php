<?php
include('../conf.php');
include('../bd.php');
?>
<div id="mensajemovil" style="overflow:auto; width:auto; height:auto">

<table class="celda2" width="500px" align="center" style="background-color:#FFFEE0">
<tr>
<td><img src="IMG/user.png" width="16" height="16" />&nbsp;Medico</td>
<td>
<select id="medico">
<?php
$consultad = "select rut,nombre1,nombre2,apellidos from personal, cargo where cargo.cod = personal.cargo and personal.cargo = 1
 and (estado = 0 || estado =2) order by apellidos";
$resultadosd = mysql_query($consultad);
while ($matriz_resultados = mysql_fetch_array($resultadosd)){
?>

<option value="<?php echo $matriz_resultados['rut']; ?>"><?php echo $matriz_resultados['apellidos'].'&nbsp;'.$matriz_resultados['nombre1']; ?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<td><img src="IMG/user.png" width="16" height="16" />&nbsp;Paramedico</td>
<td><select id="paramedico">
<?php
$consultad = "select rut,nombre1,nombre2,apellidos from personal, cargo where cargo.cod = personal.cargo and personal.cargo = 2
 and (estado = 0 || estado =2)  order by apellidos" ;
$resultadosd = mysql_query($consultad);
while ($matriz_resultados = mysql_fetch_array($resultadosd)){
?>
<option value="<?php echo $matriz_resultados['rut'];?>"><?php echo $matriz_resultados['apellidos'].'&nbsp;'.$matriz_resultados['nombre1']; ?></option>
<?php
}
?>
</select>
</td>
</tr>

<tr>
<td><img src="IMG/user.png" width="16" height="16" />&nbsp;Conductor</td>
<td><select id="conductor">
<?php
$consultad = "select rut,nombre1,nombre2,apellidos from personal, cargo where cargo.cod = personal.cargo and personal.cargo = 3
 and estado = 0  order by apellidos";
$resultadosd = mysql_query($consultad);
while ($matriz_resultados = mysql_fetch_array($resultadosd)){
?>
<option value="<?php echo $matriz_resultados['rut']; ?>"><?php echo $matriz_resultados['apellidos'].'&nbsp;'.$matriz_resultados['nombre1']; ?></option>
<?php
}
?>
</select>
</td>
</tr>

<tr>
<td><img src="IMG/car.png" width="16" height="16" />&nbsp;Movil</td>
<td>
<select id="movil">
<?php
$consultad = "select patente,num from movil where estado = 0  order by num";
$resultadosd = mysql_query($consultad);
while ($matriz_resultados = mysql_fetch_array($resultadosd)){
?>
<option value="<?php echo $matriz_resultados['num']; ?>"><?php echo '( '.$matriz_resultados['num'].' ) '.$matriz_resultados['patente']; ?></option>
<?php
}
?>
</select>
</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>
<div align="right">
<input type="button" value="Guardar" class="boton" onClick="javascript:GuardarMoviAsig();" />
</div>
</td>
</tr>
</table>

<table width="500px" align="center">
<tr>
<td class="celda1">N</td>
<td class="celda1">Medico</td>
<td class="celda1">Paramedico</td>
<td class="celda1">Conductor</td>
<td class="celda1">&nbsp;</td>
</tr>
<?php

$con22 = "select numero as numerito from movilasig";
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
$consultad = "select numero,nombre1, apellidos from personal,movilasig where conductor = rut and numero = '".$mat['numerito']."'";
$resultadosd = mysql_query($consultad);
while($matriz_resultados = mysql_fetch_array($resultadosd)){
?>
<td class="celda2"><?php echo $matriz_resultados['nombre1'].'&nbsp;'.$matriz_resultados['apellidos']; ?></td>
<td class="celda2"><a href="#" class="boton1" 
onclick="$ajaxload('bus','PHP/main.php?num=<?php echo $matriz_resultados['numero']; ?>&cambiarmovil=1',false,false,false);"><img src="IMG/car_delete.png" width="16" height="16" /></a>
</td>
</tr>
<?php
}
}
?>
</table>
</div>