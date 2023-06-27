<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

echo '=)';

$sql = "SELECT tip_doc, nro_doc, tipo_comp,serie, comprovante,cod_mov, afectacion, fecha_mov,fecha_vto, importe, cobrador, num_solici, fecha, debe, haber
FROM cta WHERE cod_mov = 1 AND afectacion > 0";

echo $sql.'<br /><br />';

$query = mysql_query($sql);

while ($ctate = mysql_fetch_array($query)){
    
    $busq ='SELECT tip_doc, nro_doc, tipo_comp,serie, comprovante,cod_mov, afectacion, fecha_mov,fecha_vto, importe, cobrador, num_solici, fecha, debe, haber
FROM cta WHERE afectacion ='.$ctacte['comprovante'].' AND cod_mov=51';

    echo $ctate['tipo_comp'].'<br />';
}

?>
