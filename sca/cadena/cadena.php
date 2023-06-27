<table>
<tr>

<td>Correlativo</td>
<td>RUT</td>
<td>ISAPRE</td>
<td>NOMBRE</td>
<td>diagnostico</td>
<td>telefono</td>
<td>celular</td>
<td>horallamada</td>
<td>horallegada</td>
<td>harasalemovil</td>
<td>clave</td>
<td>Edad</td>
</tr>

<?php

include('../conf.php');
include('../bd.php');

$query ="select edad,cod,nombre,diagnostico,telefono,celular,horallamada,horallegada,harasalemovil,clave from medimel";
$resultados = mysql_query($query);
while($matriz_resultados = mysql_fetch_array($resultados)){

$cadena = $matriz_resultados['nombre'];
$result = explode(" ", $cadena);

$nombre = $result[0];
$apellidos = $result[1].' '.$result[2];

$condultilla ="select nro_doc,obra_numero from afiliados where cod_plan ='W71' and nombre1 like'".substr($nombre,0,6)."%' and apellido like'".substr($apellidos,0,6)."%'";
$re = mysql_query($condultilla);
$rut = mysql_fetch_array($re);

echo '
<tr>
<td>'.$matriz_resultados['cod'].'</td>
<td>'.$rut['nro_doc'].'</td>
<td>'.$rut['obra_numero'].'</td>
<td>'.$nombre.' '.$apellidos.'</td>
<td>'.$matriz_resultados['diagnostico'].'</td>
<td>'.$matriz_resultados['telefono'].'</td>
<td>'.$matriz_resultados['celular'].'</td>
<td>'.$matriz_resultados['horallamada'].'</td>
<td>'.$matriz_resultados['horallegada'].'</td>
<td>'.$matriz_resultados['harasalemovil'].'</td>
<td>'.$matriz_resultados['clave'].'</td>
<td>'.$matriz_resultados['edad'].'</td>
</tr>
';
}
mysql_close($conexion);
?>
</table>