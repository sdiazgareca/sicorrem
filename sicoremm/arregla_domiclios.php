<?php
include_once('DAT/conf.php');
include_once('DAT/bd.php');

$sql = "SELECT num_solici,nro_doc,pasaje FROM domicilios WHERE calle =''";

$query = mysql_query($sql);

while($q = mysql_fetch_array($query)){

    $sd1 = "UPDATE domicilios SET calle='".$q['pasaje']."' WHERE num_solici='".$q['num_solici']."'
        AND nro_doc='".$q['nro_doc']."'";

    echo '<br />'.$sd1.';<br />';


}
?>

