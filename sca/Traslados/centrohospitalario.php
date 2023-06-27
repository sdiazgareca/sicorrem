<?php
include('../conf.php');
include('../bd.php');
?>
Lugar&nbsp;
<select id="direccion_destino_H">
<?php
$consulta = "SELECT cod,lugar FROM centrohospita ORDER BY lugar asc";
$resultados = mysql_query($consulta);
while ($matriz_resultados = mysql_fetch_array($resultados)){
?>
<option value="<?php echo $matriz_resultados['lugar']; ?>"><?php echo $matriz_resultados['lugar']; ?></option>
<?php
}
?>
</select>
