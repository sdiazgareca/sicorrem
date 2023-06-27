<?php
session_start();
include('conf.php');
include('bd.php');

$sql ="SELECT afiliados.cod_plan, afiliados.tipo_plan, afiliados.num_solici, afiliados.nro_doc FROM afiliados WHERE categoria =1";
$query = mysql_query($sql);


while( $afi = mysql_fetch_array($query) ){

$cam ="UPDATE afiliados SET afiliados.cod_plan='".$afi['cod_plan']."', afiliados.tipo_plan='".$afi['tipo_plan']."' WHERE afiliados.categoria=2 AND afiliados.num_solici='".$afi['num_solici']."'";

$cam_sql = mysql_query($cam);
echo $cam.';<br />';
}

?>
