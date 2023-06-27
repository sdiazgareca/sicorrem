<?php

set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

include('../conf.php');
include('../bd.php');

$cambiar_sql = "SELECT copago.importe, copago.boleta, copago.folio_med,protocolo 
FROM fichas 
INNER JOIN planes ON planes.cod_plan = fichas.cod_plan
INNER JOIN copago ON fichas.correlativo = copago.protocolo
WHERE fichas.cod_plan = 'w71' AND planes.tipo_plan='2' AND CHAR_LENGTH(folio_med) < 5 AND CHAR_LENGTH(folio_med) > 3";

$cambiar_query = mysql_query($cambiar_sql);

while($cambiar = mysql_fetch_array($cambiar_query)){
$copago_sql = "UPDATE copago SET folio_med='0".$cambiar['folio_med']."' WHERE protocolo = '".$cambiar['protocolo']."'";

$copago = mysql_query($copago_sql);

echo $copago_sql.'<br />';

}

mysql_close($conexion);

?>
