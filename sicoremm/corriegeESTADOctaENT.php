<?php
include_once('DAT/conf.php');
include_once('DAT/bd.php');

$sql = "SELECT estado, contratos.num_solici, contratos.titular,cta.comprovante FROM contratos
INNER JOIN cta ON cta.nro_doc=contratos.titular AND cta.num_solici=contratos.num_solici
WHERE (contratos.estado='900' || estado='3100') AND contratos.f_baja!='0000-00-00'";

$query = mysql_query($sql);

while($q = mysql_fetch_array($query)){

    $sd1 = "UPDATE cta SET DEV='1' WHERE comprovante='".$q['comprovante']."'
        AND num_solici='".$q['num_solici']."' AND nro_doc='".$q['titular']."'";

    echo $sd1.';<br />';


}





?>
