<?php
include('../conf.php');
include('../bd.php');
$consulta = "select patente, año as anio, marca, modelo, chasis, nmovil, estado from movil order by nmovil";
$resultados = mysql_query($consulta);

include('MuestraAmbulancias1.php');
while ($matriz_resultados = mysql_fetch_array($resultados)){
include('MuestraAmbulancias2.php');
}
echo '</table>';
mysql_close($conexion);
?>