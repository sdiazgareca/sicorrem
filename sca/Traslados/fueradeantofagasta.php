<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include('../conf.php');
include('../bd.php');
?>
Ciudad&nbsp;
<select id="ciudad_d">
<?php
$consulta = "select cod,lugar,costo from ciudades";
$resultados = mysql_query($consulta);
while ($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option value="<?php echo $matriz_resultados['cod']; ?>"><?php echo $matriz_resultados['lugar']; ?></option>
<?php
}
?>
</select>
<br /><br />
Direccion&nbsp;<input type="text" id="direccion_destino_f" size="60" />