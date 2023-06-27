<table width="500px" align="center">
<tr>
<td class="celda2">
<p>
<h1><div id="numambulancia"><?php echo $_GET['nmovil']; ?></div></h1>
</p>
<p>
<img src="IMG/car.png" width="16" height="16" />&nbsp;Marca&nbsp;<input id="marca" type="text" value="<?php echo $matriz_resultados ['marca']?>">
<img src="IMG/car.png" width="16" height="16" />&nbsp;Modelo&nbsp;<input type="text" id="modelo"  value="<?php echo $matriz_resultados ['modelo']?>">
<br /><br />
<img src="IMG/car.png" width="16" height="16" />&nbsp;Chasis&nbsp;<input id="chasis" type="text" size="30"  value="<?php echo $matriz_resultados ['chasis']?>">
</p>
<p>

<?php

$pat = $matriz_resultados ['patente'];
list($pat1,$pat2,$pat3) = explode("-",$pat);
?>

<img src="IMG/car.png" width="16" height="16" />&nbsp;Patente&nbsp;<input type="text" id="patente1"  size="4" maxlength="2" value="<?php echo $pat1; ?>"> 
-&nbsp;
<input type="text" id="patente2"  size="4" maxlength="2" value="<?php echo $pat2; ?>"> 
-&nbsp;
<input type="text" id="patente3"  size="4" maxlength="2" value="<?php echo $pat3; ?>">

<img src="IMG/date.png" width="16" height="16" />&nbsp;Año
&nbsp;<select id="anio">
<option value="<?php echo $matriz_resultados ['anio']?>"><?php echo $matriz_resultados ['anio']?></option>
<?php
$anio = date(Y);
for ($i = 1980; $i <= $anio; $i ++){
?>
<option value="<?php echo $i;?>"><?php echo $i; ?></option>
<?php
}
?>
</select>
&nbsp;
<br>
<div align="right">
<input type="button" value="Guardar" class="boton"  onclick="javascript:EditarMovil();" /></div>
</p>
</td>
</tr>
</table>