<?php
include('../conf.php');
include('../bd.php');

$num = $_GET['num'];
$query = "select sector.sector as clave,telefono,direccion,entre,color,fichas.sector,hora_llamado,celular from fichas inner join sector on fichas.sector = sector.cod where movil= '".$num."' and estado = 1 limit 1";

$resultados = mysql_query($query);
while ($matriz_resultados = mysql_fetch_array($resultados)){
?>

Fono&nbsp;
<input name="telefono" id="telefono" type="text" size="5" maxlength="6" class="text" value="<?php echo $matriz_resultados['telefono']; ?>">
&nbsp;Celular&nbsp;
<select id="cel">

<?php
$cadena = $matriz_resultados['celular'];
?>
<option class="text" value="<?php echo $cadena[0];?>"><?php echo $cadena[0];?></option>
</select>
<input type="text" size="10" maxlength="6" id="celular" value="<?php echo substr($matriz_resultados['celular'],2);?> " />
&nbsp;
<br /><br />
<div id="DetalleAmb">&nbsp;</div>
Direcci&oacute;n&nbsp;
<input class="text" name="direccion" id="direccion" type="text" size="40" value="<?php echo $matriz_resultados['direccion'];?>" >
<a href="#" class="boton1" onclick='javascript:document.getElementById("direccion").value=""';><img src="IMG/tick.png" width="16" height="16" /></a><br />
<br />
Entre&nbsp;
<input class="text" name="entre" id="entre" type="text" size="40" value="<?php echo $matriz_resultados['entre'];?>">
&nbsp;Sector&nbsp;
<select name="sector" id="sector">
  <option class="text" value="<?php echo $matriz_resultados['sector'];?>"><?php echo $matriz_resultados['clave'];?></option>
</select>
<br />
<br />
<?
}
?>