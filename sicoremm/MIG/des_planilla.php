<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

$sql = "SELECT RUT, COD_PLAN, TIPO_PLAN, NUM_SOLIC, EMPRESA
FROM IMG_EMPRESAS";

$query = mysql_query($sql);

while ($cam = mysql_fetch_array($query)){
    $s = "UPDATE contratos SET f_pago= 400, empresa='".$cam['EMPRESA']."' WHERE contratos.num_solici ='".$cam['NUM_SOLIC']."'";

    if (mysql_query($s)){
        echo '<br />'.$s.'<br />';
    }
    else{
        echo '<br />ERROR<br />';
    }

    $med_sql = "UPDATE contratos SET f_pago= 600, empresa='15004439' WHERE cod_plan ='W71' AND tipo_plan='2'";
    $med_query= mysql_query($med_sql);

}

?>
