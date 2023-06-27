<?php

include('conf.php');
include('bd.php');

$sql ="SELECT lomas_ba.cod, lomas_ba.cod_plan, lomas_ba.num_so, lomas_ba.tipo_plan FROM lomas_ba";
$sql_query = mysql_query($sql);



while ($lomas = mysql_fetch_array($sql_query)){


$con = "UPDATE afiliados SET afiliados.cod_plan='".$lomas['cod_plan']."', afiliados.tipo_plan='".$lomas['tipo_plan']."' WHERE afiliados.num_solici='".$lomas['num_so']."';";

echo $con."<br />";


}

?>