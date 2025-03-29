<?php
include_once('DAT/conf.php');
include_once('DAT/bd.php');



$sql = "SELECT cta.num_solici,cta.nro_doc,cta.comprovante, cta.fecha,cobrador
FROM cta
INNER JOIN t_mov ON t_mov.codigo= cta.cod_mov
WHERE t_mov.operador= 'H' AND num_solici > 0";

$query = mysql_query($sql);

while($q = mysql_fetch_array($query)){

    $add ="";

    $sql_cob ="SELECT cobrador
        FROM cta
        WHERE num_solici='".$q['num_solici']."' AND comprovante='".$q['comprovante']."'
            AND nro_doc='".$q['nro_doc']."' AND (cta.cod_mov=1 || cta.cod_mov=53)";

    $cob_query = mysql_query($sql_cob);

    $cobrador = mysql_fetch_array($cob_query);

    if ($cobrador['cobrador'] == $q['cobrador']){

        $add = ", cobrador='".$q['cobrador']."' ";
    }
    else {
        $add ="";

        }

    $sd1 = "UPDATE cta SET fecha='".$q['fecha']." '".$add." WHERE comprovante='".$q['comprovante']."'
        AND num_solici='".$q['num_solici']."' AND nro_doc='".$q['nro_doc']."' AND cod_mov=1";

    echo $sd1.';<br />';


}





?>
